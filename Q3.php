<!DOCTYPE html>
<html>

<head>
    <title>Q3</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q3: Identify the average grade for the students who have joined the study thread is higher than the students who have not joined the study thread.</h1>

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


        // First SQL Query
        $sql_study = "SELECT AVG(stud_gpa) AS avg_gpa_in_study_thread
        FROM Students ss, Stud_join sj, Threads t, Study sy
        WHERE ss.stud_id=sj.stud_id AND sj.thread_id=t.thread_id AND ss.stud_id=sy.stud_id AND t.thread_title='study'";

  $res_study = $mysqli->query($sql_study);
  $row_study = $res_study->fetch_assoc();
  $avg_gpa_in_study_thread = $row_study['avg_gpa_in_study_thread'];

  echo '<h2>Average GPA of Students in "study" Thread:</h2>';
  echo $avg_gpa_in_study_thread;
  echo '<br>';

  // Second SQL Query
  $sql_not_in_study = "SELECT AVG(stud_gpa) AS avg_gpa_notin_study_thread
                       FROM Study
                       WHERE stud_id NOT IN (SELECT DISTINCT ss.stud_id
                                             FROM Students ss, Stud_join sj, Threads t, Study sy
                                             WHERE ss.stud_id=sj.stud_id AND sj.thread_id=t.thread_id AND ss.stud_id=sy.stud_id AND t.thread_title='study')";

  $res_not_in_study = $mysqli->query($sql_not_in_study);
  $row_not_in_study = $res_not_in_study->fetch_assoc();
  $avg_gpa_notin_study_thread = $row_not_in_study['avg_gpa_notin_study_thread'];

  echo '<h2>Average GPA of Students NOT in "study" Thread:</h2>';
  echo $avg_gpa_notin_study_thread;



        $mysqli->close();
    ?>
    </div>

</body>

</html>
