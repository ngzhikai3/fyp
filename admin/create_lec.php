<?php
include '../check.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Lecture</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/background.css" rel="stylesheet" />

</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'admin_topnav.php'; 
        ?>

        <div class="container my-3 py-2">
            <div class="page-header text-center">
                <h1>Create Lecture Profile</h1>
            </div>

            <?php
            $lecture_firstname = $lecture_lastname = $lecture_email = $lecture_phone = $lecture_gender = "";

            if ($_POST) {
                // include database connection
                $lecture_firstname = $_POST['lecture_firstname'];
                $lecture_lastname = $_POST['lecture_lastname'];
                $lecture_password = md5($_POST['lecture_password']);
                $confirm_lecture_password = md5($_POST['confirm_lecture_password']);
                $lecture_email = $_POST['lecture_email'];
                $lecture_phone = $_POST['lecture_phone'];
                $lecture_gender = $_POST['lecture_gender'];
                $error_message = "";

                if ($lecture_firstname == "" || $lecture_lastname == "" || $lecture_password == md5("") || $confirm_lecture_password == md5("") ||  $lecture_email == "" || $lecture_phone == "" || $lecture_gender == "") {
                    $error_message .= "<div class='alert alert-danger'>Please make sure all fields are not empty</div>";
                }

                if (!preg_match('/[a-z]/', $lecture_password)) {
                    $error_message .= "<div class='alert alert-danger'>Password need include lowercase</div>";
                } elseif (!preg_match('/[0-9]/', $lecture_password)) {
                    $error_message .= "<div class='alert alert-danger'>Password need include number</div>";
                } elseif (strlen($lecture_password) < 8) {
                    $error_message .= "<div class='alert alert-danger'>Password need at least 8 charecter</div>";
                }

                if ($lecture_password != $confirm_lecture_password) {
                    $error_message .= "<div class='alert alert-danger'>Password need to same with confirm password</div>";
                }

                if (!empty($error_message)) {
                    echo "<div class='alert alert-danger'>{$error_message}</div>";
                } else {

                    include '../config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO lecture SET lecture_firstname=:lecture_firstname, lecture_lastname=:lecture_lastname, lecture_password=:lecture_password, lecture_email=:lecture_email, lecture_phone=:lecture_phone, lecture_gender=:lecture_gender, user_type=:user_type";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':lecture_firstname', $lecture_firstname);
                        $stmt->bindParam(':lecture_lastname', $lecture_lastname);
                        $stmt->bindParam(':lecture_password', $lecture_password);
                        $stmt->bindParam(':lecture_email', $lecture_email);
                        $stmt->bindParam(':lecture_phone', $lecture_phone);
                        $stmt->bindParam(':lecture_gender', $lecture_gender);
                        $user_type = "lecture";
                        $stmt->bindParam(':user_type', $user_type);
                        // Execute the query
                        if ($stmt->execute()) {
                            header("Location: lecture_read.php?update={save}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-dark table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="text-center col-3">First Name</td>
                        <td><input type='text' name='lecture_firstname' value='<?php echo $lecture_firstname ?>' class='form-control' /></td>
                        <td class="text-center col-3">Last Name</td>
                        <td><input type='text' name='lecture_lastname' value='<?php echo $lecture_lastname ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center col-3">Password</td>
                        <td><input type='password' name='lecture_password' class='form-control' /></td>
                        <td class="text-center col-3">Confirm Password</td>
                        <td><input type='password' name='confirm_lecture_password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center col-3">Email</td>
                        <td><input type='email' name='lecture_email' value='<?php echo $lecture_email ?>' class='form-control' /></td>
                        <td class="text-center col-3">Phone number</td>
                        <td><input type='tel' name='lecture_phone' value='<?php echo $lecture_phone ?>' class='form-control' pattern="[0-9]{3}-[0-9]{7-8}"/></td>
                    </tr>
                    <tr>
                        <td class="text-center">Gender</td>
                        <td colspan="3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lecture_gender" value="male" checked>
                                <label class="form-check-label">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lecture_gender" value="female">
                                <label class="form-check-label">
                                    Female
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="text-end">
                            <button type='submit' class='btn btn-success'>
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href='lecture_read.php' class='btn btn-secondary'>Go to Lecture Profile <i class="fa-sharp fa-solid fa-circle-arrow-right"></i></a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>