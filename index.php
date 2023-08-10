<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <link href="css/login.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>

    <?php

    // Check if user is already logged in and redirect to appropriate page
    /*if (isset($_SESSION["login"])) {
        if ($_SESSION["role"] == "admin") {
            header("Location: admin/index.php");
            exit();
        } elseif ($_SESSION["role"] == "lecture") {
            header("Location: lecture/index.php");
            exit();
        } elseif ($_SESSION["role"] == "student") {
            header("Location: student/index.php");
            exit();
        }
    }*/

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include database connection file
        include 'config/database.php';

        // Retrieve username and password from the form
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        // Prepare and execute the query to fetch user details
        $query = "SELECT * FROM login WHERE email = :email";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $num = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($num == 1) {
            if ($row['password'] != $password) {
                $error = "Your password is incorrect.";
            } else {
                // Save user's name and role in session
                $_SESSION["login"] = $email;
                $_SESSION["role"] = $row['role'];

                if ($row['role'] == "lecture") {
                    $_SESSION["lecture_id"] = $row['lecture_id'];
                    header("Location: lecture/index.php");
                    exit();
                } elseif ($row['role'] == "student") {
                    $_SESSION["student_id"] = $row['student_id'];
                    header("Location: student/index.php");
                    exit();
                } elseif ($row['role'] == "admin") {
                    header("Location: admin/index.php");
                    exit();
                }
            }
        } else {
            $error = "User not found.";
        }
    }
    ?>

    <?php
    if (isset($error)) {
        echo "<div class='alert alert-danger mt-5 mx-5 w-50 d-flex justify-content-center'>" . $error . "</div>";
    }
    ?>

    <div class="login-box">
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="user-box">
                <input type="text" name="email" required>
                <label>Email</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <button type="submit">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Submit
            </button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>