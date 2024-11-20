<?php 
require_once "core/dbConfig.php";  // Ensure the dbConfig.php is included to initialize the $pdo object
require_once "core/models.php";     // Ensure models.php is included to use database functions

// Check if the $pdo connection is established
if (!$pdo) {
    die("Database connection failed.");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Job Application</title>
        <style>
            
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            h2 {
                text-align: center;
                color: #333;
            }

            table {
                width: 90%;
                margin: 0 auto;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                padding: 12px;
                border: 1px solid #ccc;
                text-align: left;
            }

            th {
                background-color: #5c6bc0;
                color: white;
            }

            td {
                background-color: #fff;
            }

            input[type="submit"] {
                background-color: #5c6bc0;
                color: white;
                padding: 8px 16px;
                border: none;
                cursor: pointer;
                margin: 5px;
            }

            input[type="submit"]:hover {
                background-color: #3f51b5;
            }

            input[type="text"], input[type="number"] {
                padding: 8px;
                margin: 5px;
                width: 200px;
            }

            .search-form {
                text-align: center;
                margin-top: 20px;
            }

            hr {
                width: 99%;
                height: 2px;
                color: black;
                background-color: black;
            }

            .message {
                color: red;
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h2>Job Application</h2>

        <!-- Display message if it exists -->
        <?php if (isset($_SESSION['message'])) { ?>
            <h3 class="message">
                <?php echo $_SESSION['message']; ?>
            </h3>
        <?php } unset($_SESSION['message']); ?>

        <!-- Button to add new applicant -->
        <div style="text-align: center;">
            <input type="submit" value="Submit New Applicant" onclick="window.location.href='insertApplicant.php'">
        </div>

        <hr>

        <!-- Search Form -->
        <div class="search-form">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                <label for="searchBar">Search</label>
                <input type="text" name="searchBar" placeholder="Search by name or email">
                <input type="submit" name="searchButton" value="Search Application">
                <input type="submit" name="clearButton" value="Clear Search" onclick="window.location.href='index.php'">
            </form>
        </div>

        <!-- Applicants Table -->
        <table>
            <tr>
                <th colspan="9">Applicants</th>
            </tr>

            <tr>
                <th>Applicant ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email Address</th>
                <th>Contact Number</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>

            <?php
            // Handle search functionality
            if(isset($_GET['searchButton'])) {
                $searchedApplicationsData = searchForApplicant($pdo, $_GET['searchBar'])['querySet'];
                foreach($searchedApplicationsData as $row) {
            ?>
            <tr>
                <td><?php echo $row['applicantID']?></td>
                <td><?php echo $row['first_name']?></td>
                <td><?php echo $row['last_name']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['gender']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['contact_info']?></td>
                <td><?php echo $row['date_added']?></td>
                <td>
                    <input type="submit" value="EDIT" onclick="window.location.href='editApplicant.php?applicantID=<?php echo $row['applicantID']; ?>';">
                    <input type="submit" value="DELETE" onclick="window.location.href='deleteApplicant.php?applicantID=<?php echo $row['applicantID']; ?>';">
                </td>
            </tr>
            <?php }} else {
                // Fetch all applicants if no search query
                $applicantData = getAllApplicant($pdo)['querySet'];
                foreach($applicantData as $row) {
            ?>
            <tr>
                <td><?php echo $row['applicantID']?></td>
                <td><?php echo $row['first_name']?></td>
                <td><?php echo $row['last_name']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['gender']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['contact_info']?></td>
                <td><?php echo $row['date_added']?></td>
                <td>
                    <input type="submit" value="EDIT" onclick="window.location.href='editApplicant.php?applicantID=<?php echo $row['applicantID']; ?>';">
                    <input type="submit" value="DELETE" onclick="window.location.href='deleteApplicant.php?applicantID=<?php echo $row['applicantID']; ?>';">
                </td>
            </tr>
            <?php }} ?>
        </table>
    </body>
</html>
