<!DOCTYPE html>
<html>

<head>
    <title>Q1</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q1：Find the professor id with the lowest average teaching grade and the professor id with the highest average teaching score. (teaching score: average of all the course rating scores that teach by one professor)</h1>

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


        $sql_lowest = "SELECT t.fact_id, ROUND(AVG(r.rate_score), 2) AS 'average_rate_score'
        FROM Rates r, Courses c, Teach t
        WHERE r.dept_id=c.dept_id AND r.course_id=c.course_id AND t.dept_id=c.dept_id AND t.course_id=c.course_id
        GROUP BY t.fact_id
        ORDER BY AVG(r.rate_score)
        LIMIT 1";

$res_lowest = $mysqli->query($sql_lowest);

echo '<h2>Lowest Teaching Score</h2>';
echo '<table>';
echo '<tr>';
echo '<th>Faculty ID</th>';
echo '<th>Average Rate Score</th>';
echo '</tr>';

while ($row = $res_lowest->fetch_assoc()) {
echo '<tr>';
echo '<td>' . $row['fact_id'] . '</td>';
echo '<td>' . $row['average_rate_score'] . '</td>';
echo '</tr>';
}
echo '</table>';

$sql_highest = "SELECT t.fact_id, ROUND(AVG(r.rate_score), 2) AS 'average_rate_score'
                FROM Rates r, Courses c, Teach t
                WHERE r.dept_id=c.dept_id AND r.course_id=c.course_id AND t.dept_id=c.dept_id AND t.course_id=c.course_id
                GROUP BY t.fact_id
                ORDER BY AVG(r.rate_score) DESC
                LIMIT 1";

$res_highest = $mysqli->query($sql_highest);

echo '<h2>Highest Teaching Score</h2>';
echo '<table>';
echo '<tr>';
echo '<th>Faculty ID</th>';
echo '<th>Average Rate Score</th>';
echo '</tr>';

while ($row = $res_highest->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['fact_id'] . '</td>';
    echo '<td>' . $row['average_rate_score'] . '</td>';
    echo '</tr>';
}
echo '</table>';



        $mysqli->close();
    ?>
    </div>

</body>

</html>
