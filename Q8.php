<!DOCTYPE html>
<html>

<head>
    <title>Q8</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q8: Identify the most popular course in each department and list the course average grade.</h1>

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


        $sql = "SELECT
        Departments.dept_name AS Department,
        Courses.course_name AS Course_Name,
        CONCAT(Courses.dept_id, Courses.course_id) AS Course_Number,
        COUNT(Study.stud_id) AS Enrollment_Count,
        AVG(Study.stud_gpa) AS Average_Grade
    FROM Study
    JOIN Courses ON Study.dept_id = Courses.dept_id AND Study.course_id = Courses.course_id
    JOIN Departments ON Study.dept_id = Departments.dept_id
    JOIN (
        SELECT dept_id, course_id
        FROM Study
        GROUP BY dept_id, course_id
        HAVING COUNT(*) = (
            SELECT MAX(enrollment_count)
            FROM (
                SELECT dept_id, course_id, COUNT(*) AS enrollment_count
                FROM Study
                GROUP BY dept_id, course_id
            ) AS CoursePop
            WHERE CoursePop.dept_id = Study.dept_id
        )
    ) AS MaxEnrollment ON Study.dept_id = MaxEnrollment.dept_id AND Study.course_id = MaxEnrollment.course_id
    GROUP BY Department, Course_Number, Course_Name
    ORDER BY Department";

$res = $mysqli->query($sql);

echo '<table>';
echo '<tr>';
echo '<th>Department</th>';
echo '<th>Course Name</th>';
echo '<th>Course Number</th>';
echo '<th>Enrollment Count</th>';
echo '<th>Average Grade</th>';
echo '</tr>';
    
while ($row = $res->fetch_assoc()) {
echo '<tr>';
echo '<td>' . $row['Department'] . '</td>';
echo '<td>' . $row['Course_Name'] . '</td>';
echo '<td>' . $row['Course_Number'] . '</td>';
echo '<td>' . $row['Enrollment_Count'] . '</td>';
echo '<td>' . number_format($row['Average_Grade'], 2) . '</td>';
echo '</tr>';
}
echo '</table>';



        $mysqli->close();
    ?>
    </div>

</body>

</html>
