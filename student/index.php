<?php
include '../check.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Home Page</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/searchbar.css" rel="stylesheet" />
    <link href="../css/background.css" rel="stylesheet" />

</head>

<body>

    <div class="container-fluid px-0">
        <?php include 'stu_topnav.php';
        ?>

        <div class="container-fluid row m-0 pt-5">

            <div class="text-center">
                <form method="GET" action="#">
                    <div class="main-search-input fl-wrap">
                        <div class="main-search-input-item">
                            <input type="text" name="query" placeholder="Search Course...">
                        </div>
                        <button class="main-search-button" onclick="search()">Search</button>
                    </div>
                </form>
            </div>

            <div class="mt-3">

                <?php
                if (isset($_GET['enrollment'])) {
                    echo "<div class='alert alert-success'>You have successfully enrolled in the course!</div>";
                }

                include '../config/database.php';

                // Check if the query parameter is set
                if (isset($_GET['query'])) {
                    // Retrieve the search query from the form submission
                    $query = $_GET['query'];

                    // Prepare the search query
                    $stmt = $con->prepare("SELECT * FROM course INNER JOIN lecture ON course.lecture_id = lecture.lecture_id WHERE course_name LIKE :query OR course_id LIKE :query OR lecture_firstname LIKE :query OR lecture_lastname LIKE :query");

                    // Bind the search query parameter
                    $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);

                    // Execute the query
                    $stmt->execute();

                    // Fetch the search results
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Display the search results as a table with Add button
                    if (count($results) > 0) {
                        echo "
                        <h1 class='text-center my-5'>Search result</h1>
                        <table class='table table-dark table-striped table-hover table-bordered border-secondary'>
                                <thead>
                                    <tr class='table table-dark'>
                                        <th class='text-center fs-4'>Course Id</th>
                                        <th class='text-center fs-4'>Course Name</th>
                                        <th class='text-center fs-4'>Lecture Name</th>
                                        <th class='text-center fs-4'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        foreach ($results as $result) {
                            $course_id = $result['course_id']; // Assign the course_id to the $courseId variable
                            $lecture_firstname = $result['lecture_firstname'];
                            $lecture_lastname = $result['lecture_lastname'];

                            echo "<tr> 
                                    <td class='text-center'>" . $result['course_id'] . "</td>
                                    <td class='text-center'>" . $result['course_name'] . "</td>
                                    <td class='text-center'>" . $result['lecture_firstname'] . ' ' . $result['lecture_lastname'] . "</td>
                                    <td class='text-center'>
                                        <button class='btn btn-primary' onclick=\"redirectToJoinCourse('" . $course_id . "')\"><i class='fa-sharp fa-solid fa-right-to-bracket' style='color: #ffffff;'></i> Join Course</button>
                                    </td>
                                  </tr>";
                        }

                        echo "</tbody>
                              </table>";
                    } else {
                        echo "<div class='alert alert-danger'>No results found.</div>";
                    }
                }

                ?>
            </div>

            <div>
                <h1 class="text-center my-3">My Course</h1>
                <?php
                try {
                    // select all data
                    $student_id = $_SESSION["student_id"];
                    $query = "SELECT * FROM course INNER JOIN lecture ON course.lecture_id = lecture.lecture_id INNER JOIN student_course ON course.course_id = student_course.course_id INNER JOIN student ON student_course.student_id = student.student_id WHERE student_course.student_id = :student_id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':student_id', $student_id);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    // check if more than 0 record found
                    if ($num > 0) {
                        // Display table header
                        echo "<table class='table table-hover table-dark table-responsive table-striped table-hover table-bordered'>";
                        echo "<tr>";
                        echo "<th class='text-center col-2 fs-4'>Course ID</th>";
                        echo "<th class='text-center col-5 fs-4'>Course Name</th>";
                        echo "<th class='text-center col-5 fs-4'>Lecture Name</th>";
                        echo "</tr>";

                        // Retrieve and display table contents
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // extract row
                            extract($row);
                            // creating new table row per record
                            echo "<tr>";
                            echo "<td class='col-2 text-center'>{$course_id}</td>";
                            echo "<td class='col-5 text-center text-break'>{$course_name}</td>";
                            echo "<td class='col-5 text-center text-break'>{$lecture_firstname} {$lecture_lastname}</td>";
                            echo "</tr>";
                        }

                        // Close the table
                        echo "</table>";
                    } else {
                        echo "<div class='alert alert-danger'>No records found.</div>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage(); // Display the error message
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        function redirectToJoinCourse(course_id) {
            window.location.href = "stu_join_course.php?course_id=" + course_id;
        }
    </script>

</body>

</html>