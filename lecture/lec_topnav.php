<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <div class="d-flex justify-content-start">
            <a href="/smsfyp/lecture/index.php"><img src="../images/logo.png" height="80px" width="160px" ></a>
        </div>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white fs-4" href="lec_create_course.php" role="button" aria-expanded="false">Create Course</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fs-4" href="lec_grading.php" role="button" aria-expanded="false">Grading</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fs-4" href="grade_list.php" role="button" aria-expanded="false">Grade List</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-block d-xl-block d-xxl-block px-3">
            <div class="text-dark text-center bg-light px-2 rounded-3">
                <?php echo $_SESSION["login"]; ?>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <a class="nav-link text-dark p-2 px-3 rounded-3 bg-light" href="lec_profile.php?lecture_id=<?php echo $_SESSION["lecture_id"]; ?>"><i class="fa-solid fa-user"></i></a>
                <a class="nav-link text-white bg-danger p-2 px-3 rounded-3" href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>

    </div>
</nav>