<!DOCTYPE html>
<html>

<head>
    <title>Q10</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q10: Identify the tread that is most consistently active. (the time interval between the first person joining and the last person joining)"</h1>

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

        $sql = "SELECT thread_id, thread_title, time_interval FROM (
            SELECT thread_id, thread_title, TIMESTAMPDIFF(DAY, MIN(join_time), MAX(join_time)) AS 'time_interval'
            FROM (
                SELECT thread_id, thread_title, fact_join_date_time AS 'join_time', fact_id AS 'member'
                FROM Threads
                LEFT JOIN Fact_join USING(thread_id)
                UNION ALL
                SELECT thread_id, thread_title, alum_join_date_time AS 'join_time', alum_id AS 'member'
                FROM Threads
                LEFT JOIN Alum_join USING(thread_id)
                UNION ALL
                SELECT thread_id, thread_title, stud_join_date_time AS 'join_time', stud_id AS 'member'
                FROM Threads
                LEFT JOIN Stud_join USING(thread_id)
            ) a
            GROUP BY thread_id, thread_title
        ) f
        WHERE time_interval = (
            SELECT MAX(time_interval)
            FROM (
                SELECT thread_id, thread_title, TIMESTAMPDIFF(DAY, MIN(join_time), MAX(join_time)) AS 'time_interval'
                FROM (
                    SELECT thread_id, thread_title, fact_join_date_time AS 'join_time', fact_id AS 'member'
                    FROM Threads
                    LEFT JOIN Fact_join USING(thread_id)
                    UNION ALL
                    SELECT thread_id, thread_title, alum_join_date_time AS 'join_time', alum_id AS 'member'
                    FROM Threads
                    LEFT JOIN Alum_join USING(thread_id)
                    UNION ALL
                    SELECT thread_id, thread_title, stud_join_date_time AS 'join_time', stud_id AS 'member'
                    FROM Threads
                    LEFT JOIN Stud_join USING(thread_id)
                ) a
                GROUP BY thread_id, thread_title
            ) f2
        )";

$res = $mysqli->query($sql);

echo '<table>';
echo '<tr>';
echo '<th>Thread ID</th>';
echo '<th>Thread Title</th>';
echo '<th>Join Time Interval (Days)</th>';
echo '</tr>';
        
while ($row = $res->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['thread_id'] . '</td>';
    echo '<td>' . $row['thread_title'] . '</td>';
    echo '<td>' . $row['time_interval'] . '</td>';
    echo '</tr>';
}
echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
