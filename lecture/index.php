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
    <link href="../css/button.css" rel="stylesheet" />

</head>

<body class="bg-warning">

    <div class="container-fluid px-0">
        <?php include 'lec_topnav.php';
        ?>

        <div class="container-fluid row m-0 pt-5 bg-warning">
            <div class="mt-3">
                <?php
                if (isset($_GET['grading'])) {
                    echo "<div class='alert alert-danger'>No need to grade now.</div>";
                }

                include '../config/database.php';

                $lecture_id = $_SESSION["lecture_id"];
                $query = "SELECT * FROM course WHERE lecture_id = ? ORDER BY course_id DESC";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $lecture_id);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                // link to create record form
                echo "<a href='lec_create_course.php' class='btn btn-success m-b-1em my-3'>Create New course</a>";
                echo "<h1 class='text-center pb-2'>My Course</h1>";

                //check if more than 0 record found
                if ($num > 0) {

                    // data from database will be here

                } else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }

                //new
                echo "<table class='table table-hover table-dark table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th class='text-center col-2'>Course ID</th>";
                echo "<th class='text-center col-8'>Course Name</th>";
                echo "<th class='text-center col-2'>Action</th>";
                echo "</tr>";

                // table body will be here
                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // extract row
                    // this will make $row['firstname'] to just $firstname only
                    extract($row);
                    // creating new table row per record
                    echo "<tr>";
                    echo "<td class='col-2 text-center fs-4'>{$course_id}</td>";
                    echo "<td class='col-8 text-center text-break fs-4'>{$course_name}</td>";
                    echo "<td class='col-2'>";
                    // we will use this links on next part of this post
                    echo "<a href='lec_edit_course.php?course_id={$course_id}' class='btn btn-primary m-r-1em mx-3'><i class='fa-solid fa-pen-to-square'></i></a>";

                    // we will use this links on next part of this post
                    echo "<a href='#' onclick='delete_course({$course_id});' class='btn btn-danger mx-3'><i class='fa-solid fa-trash'></a>";
                    echo "</td>";
                    echo "</tr>";
                }

                // end table
                echo "</table>";
                ?>
            </div>

            <script>
                function redirectToJoinCourse(course_id) {
                    window.location.href = "join_course.php?course_id=" + course_id;
                }
            </script>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>

</html>