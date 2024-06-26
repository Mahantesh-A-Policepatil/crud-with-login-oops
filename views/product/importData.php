<?php

    session_start();
    if (!isset($_SESSION) || empty($_SESSION)) {
        header("Location: ../user/login.php");
    }
    include_once "../layout/header.php";
    include_once "../../Controllers/DataController.php";

    if (isset($_POST["submit"])) {
        $obj = new DataController();
        $result = $obj->store();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV File</title>
</head>
<body>
    <form action="importData.php" method="post" enctype="multipart/form-data">
    <div class="container">
         <div class="panel panel-default">
            <div class="panel-heading">CSV Import</div>
            <div class="panel-body">                
                <div class="form-group">
                    <input type="file" name="file" accept=".csv">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit">Upload CSV</button>
                </div>
            </div>
          </div>   
     </div>   
    </form>
</body>
</html>