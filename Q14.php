<!DOCTYPE html>
<html>

<head>
    <title>Q14</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q14: Find the top three courses with the highest rate scores in each department.</h1>

    <div class="notification">
    <?php
        $db_host = '127.0.0.1';
        $db_user = 'root';
        $db_password = 'root';
        $db_db = 'INSY661Database';
        $db_port = 8889;

        $mysqli = new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_db,
	        $db_port
        );
	
        if ($mysqli->connect_error) {
            echo 'Errno: '.$mysqli->connect_errno;
            echo '<br>';
            echo 'Error: '.$mysqli->connect_error;
            exit();
        }

        $sql = "SELECT 
                    d.dept_id,
                    d.dept_name,
                    r.course_id,
                    ROUND(r.avg_rate_score, 2) AS rounded_avg_rate_score
                FROM (
                    SELECT 
                        dept_id, 
                        course_id,
                        AVG(rate_score) AS avg_rate_score,
                        (
                            SELECT COUNT(DISTINCT r1.course_id)
                            FROM Rates r1
                            WHERE r1.dept_id = r.dept_id AND AVG(r.rate_score) <= (
                                SELECT AVG(r2.rate_score)
                                FROM Rates r2
                                WHERE r2.dept_id = r1.dept_id AND r2.course_id = r1.course_id
                            )
                        ) AS ranking
                    FROM Rates r
                    GROUP BY dept_id, course_id
                ) r
                JOIN Departments d ON r.dept_id = d.dept_id
                WHERE r.ranking <= 3
                ORDER BY d.dept_id, r.avg_rate_score DESC";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Department ID</th>';
        echo '<th>Department Name</th>';
        echo '<th>Course ID</th>';
        echo '<th>Average Rating Score(0-10)</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['dept_id'] . '</td>';
            echo '<td>' . $row['dept_name'] . '</td>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['rounded_avg_rate_score'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
