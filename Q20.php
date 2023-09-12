<!DOCTYPE html>
<html>

<head>
    <title>Q20</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q20: Display the name of top student by course and show gpa also.</h1>

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
                    C.course_id,
                    C.course_name,
                    ST.sem_year,
                    S.stud_fname,
                    S.stud_lname,
                    ST.stud_gpa
                FROM Courses AS C
                JOIN Study AS ST ON C.course_id = ST.course_id
                JOIN Students AS S ON ST.stud_id = S.stud_id
                WHERE (ST.course_id, ST.stud_gpa) IN (
                    SELECT course_id, MAX(stud_gpa) 
                    FROM Study 
                    GROUP BY course_id
                )
                ORDER BY C.course_id, ST.sem_year";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>Semester Year</th>';
        echo '<th>Student First Name</th>';
        echo '<th>Student Last Name</th>';
        echo '<th>Student GPA</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['sem_year'] . '</td>';
            echo '<td>' . $row['stud_fname'] . '</td>';
            echo '<td>' . $row['stud_lname'] . '</td>';
            echo '<td>' . $row['stud_gpa'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
