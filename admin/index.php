<?php
//include 'check.php';
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

<body>

    <div class="container-fluid px-0">
        <?php include 'topnav.php'; ?>

        <div class="container-fluid row m-0 pt-5 bg-warning">
            <div class="">
                <?php
                include '../config/database.php';

                $query = "SELECT * FROM student";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $student = $stmt->rowCount();

                $query = "SELECT * FROM lecture";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $lecture = $stmt->rowCount();

                $query = "SELECT * FROM course";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $course = $stmt->rowCount();
                echo "<div class='row my-3'>
                    <div class='col-xl-4 col-lg-6 col-md-6 my-2'>
                        <div class='card bg-light'>
                            <div class='card-header'>
                                <h3 class='card-title'>Total <strong class='text-warning'>$student</strong> Student</h1>
                            </div>
                            <div class='card-body d-flex justify-content-end'>
                                <a href='/smsfyp/admin/student_read.php' class='btn submitbtn w-50 p-2'>View All</a>
                            </div>
                        </div>
                    </div>
                    <div class='col-xl-4 col-lg-6 col-md-6 my-2'>
                        <div class='card bg-light'>
                            <div class='card-header'>
                                <h3 class='card-title'>Total <strong class='text-warning'>$lecture</strong> Lecture</h1>
                            </div>
                            <div class='card-body d-flex justify-content-end'>
                                <a href='/smsfyp/admin/lecture_read.php' class='btn submitbtn w-50 p-2'>View All</a>
                            </div>
                        </div>
                    </div>
                    <div class='col-xl-4 col-lg-6 col-md-6 my-2'>
                        <div class='card bg-light'>
                            <div class='card-header'>
                                <h3 class='card-title'>Total <strong class='text-warning'>$course</strong> Course</h1>
                            </div>
                            <div class='card-body d-flex justify-content-end'>
                                <a href='/smsfyp/admin/course_read.php' class='btn submitbtn w-50 p-2'>View All</a>
                            </div>
                        </div>
                    </div>
                </div>";
                ?>
            </div>

            <div>
                <?php
                $query = "SELECT * FROM student ORDER BY student_id DESC LIMIT 10";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo " <h1 class='text-center'>Latest 10 Student</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr class='table table-light'>
                        <th class='col-1'>Student ID</th>
                        <th class='col-3'>Entry Date</th>
                        <th class='col-2'>First Name</th>
                        <th class='col-2'>Last Name</th>
                        <th class='col-3'>Gender</th>
                        <th class='col-1'>View Details</th>
                    </tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr class='table-dark'>
                        <td class='col-1'>$student_id</td>
                        <td class='col-3'>$student_entrytime</td>
                        <td class='col-2'>$student_firstname</td>
                        <td class='col-2'>$student_lastname</td>
                        <td class='col-3'>$student_gender</td>
                        <td class='col-1'><a href='student_read_one.php?student_id={$student_id}' class='btn btn-light m-r-1em mx-3'><i class='fa-solid fa-circle-info'></i></a></td>
                    </tr>";
                    }
                    echo " </table>";
                }
                ?>
            </div>

            <div>
                <?php
                $query = "SELECT * FROM lecture ORDER BY lecture_id DESC LIMIT 10";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo " <h1 class='text-center'>Latest 10 Lecture</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr class='table table-light'>
                        <th class='col-1'>Lecture ID</th>
                        <th class='col-3'>Entry Date</th>
                        <th class='col-2'>First Name</th>
                        <th class='col-2'>Last Name</th>
                        <th class='col-3'>Gender</th>
                        <th class='col-1'>View Details</th>
                    </tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr class='table-dark'>
                        <td class='col-1'>$lecture_id</td>
                        <td class='col-3'>$lecture_entrytime</td>
                        <td class='col-2'>$lecture_firstname</td>
                        <td class='col-2'>$lecture_lastname</td>
                        <td class='col-3'>$lecture_gender</td>
                        <td class='col-1'><a href='lecture_read_one.php?lecture_id={$lecture_id}' class='btn btn-light m-r-1em mx-3'><i class='fa-solid fa-circle-info'></i></a></td>
                    </tr>";
                    }
                    echo " </table>";
                }
                ?>
            </div>

            <div>
                <?php
                $query = "SELECT * FROM course ORDER BY course_id DESC LIMIT 10";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo " <h1 class='text-center'>Latest 10 Course</h1>
                <table class='table table-dark table-hover table-responsive table-bordered text-center'>
                    <tr class='table table-light'>
                        <th class='col-1'>course ID</th>
                        <th class='col-2'>Course Name</th>
                        <th class='col-1'>View Details</th>
                    </tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr class='table-dark'>
                        <td class='col-1'>$course_id</td>
                        <td class='col-2'>$course_name</td>
                        <td class='col-1'><a href='course_read.php' class='btn btn-light m-r-1em mx-3'><i class='fa-solid fa-circle-info'></i></a></td>
                    </tr>";
                    }
                    echo " </table>";
                }
                ?>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>