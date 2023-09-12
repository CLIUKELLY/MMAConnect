<!DOCTYPE html>
<html>

<head>
    <title>Q12</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>	Q12: Identify the students who have the most connections.</h1>

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

        $sql = "SELECT stud_id, stud_fname, stud_lname, number_of_connect FROM (
            SELECT stud_id, COUNT(DISTINCT fact_id) + COUNT(DISTINCT alum_id) AS 'number_of_connect'
            FROM Stud_join
            LEFT JOIN Alum_join USING(thread_id)
            LEFT JOIN Fact_join USING(thread_id)
            GROUP BY stud_id
        ) c
        LEFT JOIN Students USING(stud_id)
        WHERE number_of_connect = (
            SELECT MAX(number_of_connect)
            FROM (
                SELECT stud_id, COUNT(DISTINCT fact_id) + COUNT(DISTINCT alum_id) AS 'number_of_connect'
                FROM Stud_join
                LEFT JOIN Alum_join USING(thread_id)
                LEFT JOIN Fact_join USING(thread_id)
                GROUP BY stud_id
            ) c1
        )";

$res = $mysqli->query($sql);

echo '<table>';
echo '<tr>';
echo '<th>Student ID</th>';
echo '<th>First Name</th>';
echo '<th>Last Name</th>';
echo '<th>Number of Connections</th>';
echo '</tr>';
        
while ($row = $res->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['stud_id'] . '</td>';
    echo '<td>' . $row['stud_fname'] . '</td>';
    echo '<td>' . $row['stud_lname'] . '</td>';
    echo '<td>' . $row['number_of_connect'] . '</td>';
    echo '</tr>';
}
echo '</table>';

        $mysqli->close();
    ?>
    </div>

</body>

</html>
