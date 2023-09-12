<!DOCTYPE html>
<html>

<head>
    <title>Q19</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q19: Write query to list all courses and their respective average ratings and students average gpas with standard deviation of GPAs, number of total posts made by students of that course.</h1>

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

        $res = $mysqli->query($sql);

        $sql = "SELECT
        C.course_id,
        C.course_name,
        ROUND(AVG(R.rate_score), 2) AS average_rating,
        ROUND(AVG(ST.stud_gpa), 2) AS average_gpa,
        ROUND(STDDEV(ST.stud_gpa), 2) AS gpa_standard_deviation,
        COUNT(P.stud_id) AS total_posts
    FROM Courses AS C
    LEFT JOIN Rates AS R ON C.course_id = R.course_id
    LEFT JOIN Study AS ST ON C.course_id = ST.course_id
    LEFT JOIN Posts AS P ON ST.stud_id = P.stud_id
    GROUP BY C.course_id, C.course_name
    HAVING 
        average_rating IS NOT NULL 
    AND average_gpa IS NOT NULL 
    AND gpa_standard_deviation IS NOT NULL 
    AND total_posts IS NOT NULL";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Course ID</th>';
        echo '<th>Course Name</th>';
        echo '<th>Average Rating</th>';
        echo '<th>Average GPA</th>';
        echo '<th>GPA Standard Deviation</th>';
        echo '<th>Total Posts</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['course_id'] . '</td>';
            echo '<td>' . $row['course_name'] . '</td>';
            echo '<td>' . $row['average_rating'] . '</td>';
            echo '<td>' . $row['average_gpa'] . '</td>';
            echo '<td>' . $row['gpa_standard_deviation'] . '</td>';
            echo '<td>' . $row['total_posts'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
