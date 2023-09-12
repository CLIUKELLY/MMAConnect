<!DOCTYPE html>
<html>

<head>
    <title>Q6</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q6 List the companies that have hired alumni from at least two different cohorts</h1>

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

        $sql = "SELECT alum_companyname AS Company, COUNT(DISTINCT mmaCo_id) AS Alumni_Hired
                FROM Alumni
                GROUP BY alum_companyname
                HAVING Alumni_Hired >= 2";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Company</th>';
        echo '<th>Alumni Hired</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Company'] . '</td>';
            echo '<td>' . $row['Alumni_Hired'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        $mysqli->close();
    ?>
    </div>

</body>

</html>
