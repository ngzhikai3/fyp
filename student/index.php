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
        <?php //include 'topnav.php'; 
        ?>

        <div class="container-fluid row m-0 pt-5 bg-warning">
            <div>
                <form method="GET" action="#">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="mt-3">
                <?php
                include '../config/database.php';

                // Check if the query parameter is set
                if (isset($_GET['query'])) {
                    // Retrieve the search query from the form submission
                    $query = $_GET['query'];

                    // Prepare the search query
                    $stmt = $con->prepare("SELECT * FROM course WHERE course_name LIKE :query");

                    // Bind the search query parameter
                    $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);

                    // Execute the query
                    $stmt->execute();

                    // Fetch the search results
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Display the search results as a table with Add button
                    if (count($results) > 0) {
                        echo "<table class='table table-dark table-striped table-hover table-bordered border-secondary'>
                    <thead>
                        <tr class='table table-dark'>
                            <th>Course Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach ($results as $result) {
                            echo "<tr>
                        <td>" . $result['course_name'] . "</td>
                        <td><button class='btn btn-primary' onclick=\"addCourse('" . $result['course_id'] . "')\">Add</button></td>
                      </tr>";
                        }

                        echo "</tbody>
                </table>";
                    } else {
                        echo "No results found.";
                    }
                }
                ?>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>