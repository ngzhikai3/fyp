<?php
// Load the database configuration file 
include_once '../config/database.php';

// Include PhpSpreadsheet library autoloader 
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['importSubmit'])) {
    // Allowed mime types 
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // Validate whether selected file is an Excel file 
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)) {
        // If the file is uploaded 
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            // Remove header row 
            unset($worksheet_arr[0]);

            $expectedColumns = 7; // Define the expected number of columns
            $invalidFormat = false; // Flag to track invalid formats

            foreach ($worksheet_arr as $row) {
                // Check if the number of columns in the current row matches the expected number
                if (count($row) !== $expectedColumns) {
                    $invalidFormat = true;
                    break; // Exit the loop if invalid format is detected
                }

                $lecture_firstname = $row[0];
                $lecture_lastname = $row[1];
                $lecture_password = md5($row[2]); // Hash the password
                $lecture_email = $row[3];
                $lecture_phone = $row[4];
                $lecture_gender = $row[5];
                $user_type = $row[6];

                $prevQuery = "SELECT lecture_id FROM lecture WHERE lecture_email = :lecture_email";
                $prevStatement = $con->prepare($prevQuery);
                $prevStatement->bindParam(':lecture_email', $lecture_email);
                $prevStatement->execute();
                $prevRowCount = $prevStatement->rowCount();

                if ($prevRowCount > 0) {
                    // User already exists, you can choose to update user information here if needed
                } else {
                    // Get the lecture ID before starting the transaction
                    $lecture_id = null;

                    $con->beginTransaction(); // Start a transaction

                    // Insert into lecture table
                    $con->query("INSERT INTO lecture (lecture_firstname, lecture_lastname, lecture_password, lecture_email, lecture_phone, lecture_gender, user_type) VALUES ('$lecture_firstname', '$lecture_lastname','$lecture_password',  '$lecture_email', '$lecture_phone', '$lecture_gender', 'lecture')");

                    // Fetch the actual lecture ID
                    $lecture_id = $con->lastInsertId();

                    // Insert into login table
                    $insertLoginQuery = "INSERT INTO login (email, password, role, lecture_id) VALUES (:lecture_email, :lecture_password, 'lecture', :lecture_id)";
                    $insertLoginStatement = $con->prepare($insertLoginQuery);
                    $insertLoginStatement->bindParam(':lecture_email', $lecture_email);
                    $insertLoginStatement->bindParam(':lecture_password', $lecture_password);
                    $insertLoginStatement->bindParam(':lecture_id', $lecture_id);
                    $insertLoginStatement->execute();

                    $con->commit(); // Commit the transaction
                }
            }

            if ($invalidFormat) {
                header("Location: create_lec.php?invalid_format={invalid_format}");
            } else {
                header("Location: lecture_read.php?update={save}");
            }
        }
    } else {
        header("Location: create_lec.php?empty={empty}");
    }
}
?>
