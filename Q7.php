<!DOCTYPE html>
<html>

<head>
    <title>Q7</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q7: List the alumni who have joined threads related to their current industry.</h1>

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

        $sql = "SELECT CONCAT(Alumni.alum_fname, ' ', Alumni.alum_lname) AS Alumni_Name,
                       Alumni.alum_companyname AS Company_Name,
                       Industries.industry_name AS Industry,
                       Threads.thread_title AS Thread_Title
                FROM Alumni
                JOIN Worked_in ON Alumni.alum_id = Worked_in.alum_id
                JOIN Industries ON Worked_in.industry_id = Industries.industry_id
                JOIN Alum_join ON Alumni.alum_id = Alum_join.alum_id
                JOIN Threads ON Alum_join.thread_id = Threads.thread_id
                ORDER BY Alumni_Name";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Alumni Name</th>';
        echo '<th>Company Name</th>';
        echo '<th>Industry</th>';
        echo '<th>Thread Title</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Alumni_Name'] . '</td>';
            echo '<td>' . $row['Company_Name'] . '</td>';
            echo '<td>' . $row['Industry'] . '</td>';
            echo '<td>' . $row['Thread_Title'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
