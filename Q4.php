<!DOCTYPE html>
<html>

<head>
    <title>Q4</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q4. List the 3 threads with the most recent activity.</h1>

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

        $sql = "SELECT thread_title, MAX(post_timestamp) AS latest_activity
        FROM Threads T JOIN Posts P ON P.thread_id=T.thread_id
        GROUP BY T.thread_id
        ORDER BY latest_activity DESC
        LIMIT 3";

$res = $mysqli->query($sql);

echo '<table>';
echo '<tr>';
echo '<th>Thread Title</th>';
echo '<th>Latest Activity</th>';
echo '</tr>';
        
while ($row = $res->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['thread_title'] . '</td>';
    echo '<td>' . $row['latest_activity'] . '</td>';
    echo '</tr>';
}
echo '</table>';


        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
