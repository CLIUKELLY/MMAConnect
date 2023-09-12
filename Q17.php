<!DOCTYPE html>
<html>

<head>
    <title>Q17</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q17: Find threads and posts related to study tag names ordered by date.</h1>

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

        $sql = "SELECT DISTINCT T.thread_id, T.thread_title, P.post_id, P.post_content, P.post_timestamp
        FROM Threads AS T
        JOIN Categorize_by AS CB ON T.thread_id = CB.thread_id
        JOIN Tags AS TG ON CB.tag_id = TG.tag_id
        JOIN Posts AS P ON T.thread_id = P.thread_id
        WHERE TG.tag_name LIKE '%study%'
        ORDER BY P.post_timestamp ASC";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Thread ID</th>';
        echo '<th>Thread Title</th>';
        echo '<th>Post ID</th>';
        echo '<th>Post Content</th>';
        echo '<th>Post Timestamp</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['thread_id'] . '</td>';
            echo '<td>' . $row['thread_title'] . '</td>';
            echo '<td>' . $row['post_id'] . '</td>';
            echo '<td>' . $row['post_content'] . '</td>';
            echo '<td>' . $row['post_timestamp'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
