<!DOCTYPE html>
<html>

<head>
    <title>Q15</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q15: Display the average GPA, max GPA, and min GPA for each course each semester.</h1>

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
                    c.course_name,
                    s.sem_year,
                    ROUND(AVG(s.stud_gpa), 2) AS avg_gpa,
                    MAX(s.stud_gpa) AS max_gpa,
                    MIN(s.stud_gpa) AS min_gpa
                FROM 
                    Study s
                JOIN 
                    Courses c ON s.dept_id = c.dept_id AND s.course_id = c.course_id
                GROUP BY 
                    c.course_name, s.sem_year
                ORDER BY 
                    c.course_name, s.sem_year";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Course Name</th>';
        echo '<th>Semester Year</th>';
        echo '<th>Average GPA</th>';
        echo '<th>Max GPA</th>';
        echo '<th>Min GPA</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['sem_year'] . '</td>';
            echo '<td>' . $row['avg_gpa'] . '</td>';
            echo '<td>' . $row['max_gpa'] . '</td>';
            echo '<td>' . $row['min_gpa'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';       



        $mysqli->close();
    ?>
    </div>

</body>

</html>
