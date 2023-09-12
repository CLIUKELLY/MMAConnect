<!DOCTYPE html>
<html>

<head>
    <title>Q5</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q5 List the top five companies with the most alumni in each industry</h1>

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

        $sql = "SELECT Industries.industry_name AS Industry_Name, Alumni.alum_companyname AS Company_Name, COUNT(DISTINCT Alumni.alum_id) AS Alumni_Count
                FROM Industries
                JOIN Worked_in ON Industries.industry_id = Worked_in.industry_id
                JOIN Alumni ON Worked_in.alum_id = Alumni.alum_id
                GROUP BY Industries.industry_name, Alumni.alum_companyname
                HAVING Alumni_Count >= 2
                ORDER BY Industries.industry_name, Alumni_Count DESC
                LIMIT 5";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Industry Name</th>';
        echo '<th>Company Name</th>';
        echo '<th>Alumni Count</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Industry_Name'] . '</td>';
            echo '<td>' . $row['Company_Name'] . '</td>';
            echo '<td>' . $row['Alumni_Count'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
