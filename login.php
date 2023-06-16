<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login Page</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <link href="css/button.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body class="bg-warning">

    <div class="container w-50 bg-dark p-3 pt-1 my-5" data-aos="fade-top">

        <?php

        if (isset($_GET['update'])) {
            echo "<div class='alert alert-success mt-3'>User Registered.</div>";
        }

        if (isset($_GET["error"])) {
            echo "<div class=\"alert alert-danger my-5\" role=\"alert\">Please Login</div>";
        }
        ?>

        <div class="text-center mt-5"><img src="images/logo.png" height="50px"></div>

        <h1 class="text-center my-5 text-white">Please sign in</h1>

        <div class="container mt-5">

            <?php
            include 'config/database.php';

            if (isset($_POST['username']) && isset($_POST['password'])) {

                $username = ($_POST['username']);
                $password = md5($_POST['password']);

                $query = "SELECT * FROM customers WHERE username = '$username'";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $num = $stmt->rowCount();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($num == 1) {
                    if ($row['password'] != $password) {
                        echo "<h3 class='alert alert-danger'>Your password is incorrect.</h3>";
                    } elseif ($row['account_status'] != "active") {
                        echo "<h3 class='alert alert-danger'>Your account is suspended.</h3>";
                    } else {
                        $_SESSION["login"] = $username;
                        header("Location: index.php");
                    }
                } else {
                    echo "<h3 class='alert alert-danger'>User not found.</h3>";
                }
            };

            ?>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered '>
                    <div class="form-floating my-3" data-aos="fade-left">
                        <input type="text" class="form-control" id="floatingInput" name="username">
                        <label for="floatingInput">Username</label>
                    </div>

                    <div class="form-floating my-3" data-aos="fade-right">
                        <input type="password" class="form-control" id="floatingPassword" name="password">
                        <label for="floatingPassword">Password</label>
                    </div>

                    <div class="text-center my-4" data-aos="fade-left">
                        <button class="submitbtn w-100" role="button" type="submit"><span class="text">Sign In</span></button>
                    </div>
                    <div class="text-center my-4">
                        <a href="register.php"><i class="fa-solid fa-user-plus text-success fs-3"></i></a>
                    </div>
                </table>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>




<?php
// Assuming you have already established a database connection

// Start the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_name']) && isset($_SESSION['user_role'])) {
    // Redirect the user to the dashboard or desired page
    header('Location: dashboard.php'); // Assuming you have a dashboard page
    exit();
}

// Check if the login form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the user's email and password from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute a database query to retrieve the user's name and role
    $query = "SELECT student_firstname, student_lastname, 'student' as role FROM student WHERE student_email = ? AND student_password = ? UNION SELECT lecture_firstname, lecture_lastname, 'lecture' as role FROM lecture WHERE lecture_email = ? AND lecture_password = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $password, $email, $password]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the query returned a result
    if ($result) {
        // Store the user's name and role in session variables
        $_SESSION['user_name'] = $result['student_firstname'] . ' ' . $result['student_lastname'];
        $_SESSION['user_role'] = $result['role'];

        // Redirect to the dashboard or desired page based on the role
        if ($_SESSION['user_role'] === 'student') {
            header('Location: student/index.php'); // Assuming you have a student dashboard page
        } elseif ($_SESSION['user_role'] === 'lecture') {
            header('Location: lecture/index.php'); // Assuming you have a lecture dashboard page
        }
        exit();
    } else {
        // Invalid credentials or user not found
        // Handle error or display appropriate message
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>