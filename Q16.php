<!DOCTYPE html>
<html>

<head>
    <title>Q16</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>	Q16: compare the average GPA for each course between 2022F and 2023F.</h1>

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

        $sql = "
        SELECT 
            s.dept_id, 
            c.course_id, 
            c.course_name,
            COALESCE(ROUND(AVG(CASE WHEN o.sem_year = '2022F' THEN s.stud_gpa END), 2), 0) AS avg_gpa_2022F,
            COALESCE(ROUND(AVG(CASE WHEN o.sem_year = '2023F' THEN s.stud_gpa END), 2), 0) AS avg_gpa_2023F
        FROM 
            Study s
        JOIN 
            Courses c ON s.dept_id = c.dept_id AND s.course_id = c.course_id
        JOIN
            Offered_by o ON s.dept_id = o.dept_id AND s.course_id = o.course_id
        GROUP BY 
            s.dept_id, 
            c.course_id,
            c.course_name
        HAVING
            avg_gpa_2022F > 0 
            AND 
            avg_gpa_2023F > 0
        ORDER BY 
            s.dept_id, 
            c.course_id";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Department ID</th>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>Avg GPA 2022F</th>';
        echo '<th>Avg GPA 2023F</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['dept_id'] . '</td>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['avg_gpa_2022F'] . '</td>';
            echo '<td>' . $row['avg_gpa_2023F'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
