<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSY661 Group Project</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="mcgill Logo.png" alt="McGill Desautels Logo">
        </div>
        <div class="banner">
            Welcome to McGill MMAConnect
        </div>
    </header>

    <div class="notification">
        Click on the buttons next to the questions to navigate queries results.
    </div>

    <table>
        <thead>
            <tr>
                <th>Question #</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dummyQuestions = [
                "Q1: Find the professor id with the lowest average teaching grade and the professor id with the highest average teaching score. (teaching score: average of all the course rating scores that teach by one professor)",
                "Q2: Find the student who makes the most posts in the INSY-660 thread.",
                "Q3: Identify the average grade for the students who have joined the study thread is higher than the students who have not joined the study thread.",
                "Q4: List the 3 threads with the most recent activity.",
                "Q5: List the top five companies with the most alumni in each industry.",
                "Q6: List the companies that have hired alumni from at least two different cohorts.",
                "Q7: List the alumni who have joined threads related to their current industry.",
                "Q8: Identify the most popular course in each department and list the course average grade.",
                "Q9: Find the course with the highest average in each department and show the name of the professor and TA.",
                "Q10: Identify the tread that is most consistently active. (the time interval between the first person joining and the last person joining)",
                "Q11: Display the courses where the average GPA of students is above 3.3.",
                "Q12: Identify the students who have the most connections.",
                "Q13: Determine the most common industry interest among students with GPA >= 3.5 in each course.",
                "Q14: Find the top three courses with the highest rate scores in each department.",
                "Q15: Display the average GPA, max GPA, and min GPA for each course each semester.",
                "Q16: compare the average GPA for each course between 2022F and 2023F.",
                "Q17: Find threads and posts related to study tag names ordered by date.",
                "Q18: Query to compare the average gpa of students who posted in the threads with students who didn't post.",
                "Q19: Write query to list all courses and their respective average ratings and students average gpas with standard deviation of GPAs, number of total posts made by students of that course.",
                "Q20: Display the name of top student by course and show gpa also."
            ];

            for ($i = 0; $i < 20; $i++) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                echo "<td>" . $dummyQuestions[$i] . "</td>";
                echo "<td><a href='Q" . ($i + 1) . ".php' class='btn'>Go</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>
