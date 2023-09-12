<!DOCTYPE html>
<html>

<head>
    <title>Q9</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q9: Find the course with the highest average in each department and show the name of the professor and TA.</h1>

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
            SELECT dept_id, course_id, sem_year, fact_fname, fact_lname
            FROM (
                SELECT s.dept_id, s.course_id, s.sem_year, s.average_grade,
                       @rank := IF(@prev_dept = s.dept_id, @rank + 1, 1) AS 'highest',
                       @prev_dept := s.dept_id,
                       p.fact_fname, p.fact_lname
                FROM (
                    SELECT dept_id, course_id, sem_year, AVG(stud_gpa) AS average_grade 
                    FROM Study
                    GROUP BY dept_id, course_id, sem_year
                    ORDER BY dept_id, average_grade DESC
                ) s
                LEFT JOIN (
                    SELECT t.dept_id, t.course_id, t.sem_year, f.fact_fname, f.fact_lname 
                    FROM Teach t
                    LEFT JOIN Faculties f USING(fact_id)
                ) p ON (p.dept_id = s.dept_id) AND (p.course_id = s.course_id) AND (p.sem_year = s.sem_year),
                (SELECT @rank := 0, @prev_dept := NULL) r
            ) gg
            WHERE highest = 1
        ";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Department ID</th>';
        echo '<th>Course ID</th>';
        echo '<th>Semester Year</th>';
        echo '<th>Faculty First Name</th>';
        echo '<th>Faculty Last Name</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['dept_id'] . '</td>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['sem_year'] . '</td>';
            echo '<td>' . $row['fact_fname'] . '</td>';
            echo '<td>' . $row['fact_lname'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';



        $mysqli->close();
    ?>
    </div>

</body>

</html>
