<!DOCTYPE html>
<html>

<head>
    <title>Q13</title>
    <link rel="stylesheet" type="text/css" href="styles_Q.css">
</head>

<body>

    <h1>Q13: Determine the most common industry interest among students with GPA >= 3.5 in each course.</h1>

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

        $sql = "
            SELECT 
                industry_name,
                CONCAT(CAST(ROUND(proportion * 100, 2) AS CHAR), '%') AS ProportionOfHighGPAStudents,
                ROUND(AvgGPA, 2) AS AvgGPA
            FROM (
                SELECT 
                    Industries.industry_name,
                    COUNT(DISTINCT h.stud_id) * 1.0 / (
                        SELECT COUNT(DISTINCT Students.stud_id)
                        FROM Students
                        JOIN Study ON Students.stud_id = Study.stud_id
                        WHERE Study.stud_gpa IS NOT NULL AND Study.stud_gpa >= 3.5
                    ) AS proportion,
                    AVG(h.max_gpa) AS AvgGPA
                FROM (
                    SELECT 
                        Students.stud_id AS stud_id,
                        Students.stud_fname,
                        Students.stud_lname,
                        ROUND(MAX(Study.stud_gpa), 2) AS max_gpa
                    FROM 
                        Students
                    JOIN 
                        Study ON Students.stud_id = Study.stud_id
                    WHERE 
                        Study.stud_gpa IS NOT NULL AND Study.stud_gpa >= 3.5
                    GROUP BY 
                        Students.stud_id,
                        Students.stud_fname,
                        Students.stud_lname
                ) AS h
                LEFT JOIN Interested_in ON Interested_in.stud_id = h.stud_id
                LEFT JOIN Industries ON Interested_in.industry_id = Industries.industry_id
                WHERE
                    Industries.industry_name IS NOT NULL
                GROUP BY Industries.industry_name
            ) AS InnerQuery
            ORDER BY 
                InnerQuery.proportion DESC,
                InnerQuery.industry_name ASC,
                InnerQuery.AvgGPA DESC
        ";

        $res = $mysqli->query($sql);

        echo '<table>';
        echo '<tr>';
        echo '<th>Industry Name</th>';
        echo '<th>Proportion of High GPA Students</th>';
        echo '<th>Average GPA</th>';
        echo '</tr>';
                
        while ($row = $res->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['industry_name'] . '</td>';
            echo '<td>' . $row['ProportionOfHighGPAStudents'] . '</td>';
            echo '<td>' . $row['AvgGPA'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        



        $mysqli->close();
    ?>
    </div>

</body>

</html>
