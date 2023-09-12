<!DOCTYPE html>
<html>

<head>
    <title>Q2</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q2: Find the student who makes the most posts in the INSY-660 thread.</h1>

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

        $sql = "SELECT S.stud_fname, S.stud_lname, COUNT(*) AS num_post
        FROM Threads T, Posts P, Students S
        WHERE T.thread_id=P.thread_id AND S.stud_id=P.stud_id AND T.thread_title='INSY-660'
        GROUP BY P.stud_id
        ORDER BY num_post DESC
        LIMIT 1";

$res = $mysqli->query($sql);

echo '<h2>Student with Most Posts in INSY-660 Thread</h2>';
display_student_posts($res);

function display_student_posts($res) {
    echo '<table>';
    echo '<tr>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Number of Posts</th>';
    echo '</tr>';
        
    while ($newArray = $res->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $newArray['stud_fname'] . '</td>';
        echo '<td>' . $newArray['stud_lname'] . '</td>';
        echo '<td>' . $newArray['num_post'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

        $mysqli->close();
    ?>
    </div>

</body>

</html>
