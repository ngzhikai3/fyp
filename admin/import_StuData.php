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

            $expectedColumns = 8; // Define the expected number of columns
            $invalidFormat = false; // Flag to track invalid formats

            foreach ($worksheet_arr as $row) {
                // Check if the number of columns in the current row matches the expected number
                if (count($row) !== $expectedColumns) {
                    $invalidFormat = true;
                    break; // Exit the loop if an invalid format is detected
                }

                $student_firstname = $row[0];
                $student_lastname = $row[1];
                $student_password = md5($row[2]); // Hash the password
                $student_email = $row[3];
                $student_phone = $row[4];
                $student_gender = $row[5];
                $date_of_birth = $row[6];
                $user_type = $row[7];

                $prevQuery = "SELECT student_id FROM student WHERE student_email = :student_email";
                $prevStatement = $con->prepare($prevQuery);
                $prevStatement->bindParam(':student_email', $student_email);
                $prevStatement->execute();
                $prevRowCount = $prevStatement->rowCount();

                if ($prevRowCount > 0) {
                    // User already exists, you can choose to update user information here if needed
                } else {
                    // Get the student ID before starting the transaction
                    $student_id = null;

                    $con->beginTransaction(); // Start a transaction

                    // Insert into student table
                    $insertStudentQuery = "INSERT INTO student (student_firstname, student_lastname, student_password, student_email, student_phone, student_gender, date_of_birth, user_type) VALUES (:student_firstname, :student_lastname, :student_password, :student_email, :student_phone, :student_gender, :date_of_birth, :user_type)";
                    $insertStudentStatement = $con->prepare($insertStudentQuery);
                    $insertStudentStatement->bindParam(':student_firstname', $student_firstname);
                    $insertStudentStatement->bindParam(':student_lastname', $student_lastname);
                    $insertStudentStatement->bindParam(':student_password', $student_password);
                    $insertStudentStatement->bindParam(':student_email', $student_email);
                    $insertStudentStatement->bindParam(':student_phone', $student_phone);
                    $insertStudentStatement->bindParam(':student_gender', $student_gender);
                    $insertStudentStatement->bindParam(':date_of_birth', $date_of_birth);
                    $insertStudentStatement->bindParam(':user_type', $user_type);
                    $insertStudentStatement->execute();


                    // Fetch the actual student ID
                    $student_id = $con->lastInsertId();

                    // Insert into login table
                    $insertLoginQuery = "INSERT INTO login (email, password, role, student_id) VALUES (:student_email, :student_password, 'student', :student_id)";
                    $insertLoginStatement = $con->prepare($insertLoginQuery);
                    $insertLoginStatement->bindParam(':student_email', $student_email);
                    $insertLoginStatement->bindParam(':student_password', $student_password);
                    $insertLoginStatement->bindParam(':student_id', $student_id);
                    $insertLoginStatement->execute();

                    $con->commit(); // Commit the transaction
                }
            }

            if ($invalidFormat) {
                header("Location: create_stu.php?invalid_format={invalid_format}");
            } else {
                header("Location: student_read.php?update={save}");
            }
        }
    } else {
        header("Location: create_stu.php?empty={empty}");
    }
}
