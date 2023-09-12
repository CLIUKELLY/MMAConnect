<!DOCTYPE html>
<html>

<head>
    <title>Q11</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q11: Display the courses where the average GPA of students is above 3.3.</h1>

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

        $sql = "SELECT c.dept_id, c.course_id, c.course_name, s.sem_year, ROUND(AVG(s.stud_gpa), 2) AS 'average_grade'
                FROM Courses c
                LEFT JOIN Study s ON (c.dept_id = s.dept_id) AND (c.course_id = s.course_id)
                GROUP BY c.dept_id, c.course_id, c.course_name, s.sem_year
                HAVING average_grade >= 3.3
                ORDER BY average_grade DESC";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Department ID</th>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>Semester Year</th>';
        echo '<th>Average Grade</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['dept_id'] . '</td>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['sem_year'] . '</td>';
            echo '<td>' . $row['average_grade'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        $mysqli->close();
    ?>
    </div>

</body>

</html>
