<!DOCTYPE html>
<html>

<head>
    <title>Q18</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q18: Query to compare the average gpa of students who posted in the threads with students who didn't post.</h1>

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
        ROUND(X.AvgGpa_StudsWithNoPost, 2) AS AvgGpa_StudsWithNoPost,
        ROUND(Y.AvgGpa_StudsWithPost, 2) AS AvgGpa_StudsWithPost
    FROM
        (SELECT AVG(ST.stud_gpa) as AvgGpa_StudsWithNoPost
        FROM Students AS S
        LEFT JOIN Posts AS P ON S.stud_id = P.stud_id
        LEFT JOIN Threads AS T ON P.thread_id = T.thread_id
        LEFT JOIN Study AS ST ON S.stud_id = ST.stud_id
        WHERE P.stud_id IS NULL) AS X,
        (SELECT AVG(ST.stud_gpa) as AvgGpa_StudsWithPost
        FROM Students AS S
        LEFT JOIN Posts AS P ON S.stud_id = P.stud_id
        LEFT JOIN Threads AS T ON P.thread_id = T.thread_id
        LEFT JOIN Study AS ST ON S.stud_id = ST.stud_id) AS Y";


        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Average GPA (Students without posts)</th>';
        echo '<th>Average GPA (Students with posts)</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['AvgGpa_StudsWithNoPost'] . '</td>';
            echo '<td>' . $row['AvgGpa_StudsWithPost'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        $mysqli->close();
    ?>
    </div>

</body>

</html>


