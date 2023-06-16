<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <div class="d-flex justify-content-start">
            <a href="/smsfyp/admin/index.php"><img src="images/logo.png" height="50px"></a>
        </div>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Student</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/smsfyp/admin/create_stu.php">Create New Student</a></li>
                        <li><a class="dropdown-item" href="/smsfyp/admin/student_read.php">Student List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Lecture</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/smsfyp/admin/create_lec.php">Create New Lecture</a></li>
                        <li><a class="dropdown-item" href="/smsfyp/admin/lecture_read.php">Lecture List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Course</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/smsfyp/admin/create_course.php">Create New Course</a></li>
                        <li><a class="dropdown-item" href="/smsfyp/admin/course_read.php">Course List</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="d-none d-lg-block d-xl-block d-xxl-block">
            <a class="nav-link text-white bg-danger p-2 px-3 rounded-5" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>
</nav>