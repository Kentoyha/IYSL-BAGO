<?php
include("db_connect.php");
?>

<head>
<link rel="stylesheet" href="addt.css">  </link>
</head>

<body>
    <?php
        include("menu.php");
        include("header.php");
    ?>

<h1>REGISTER A TEAM</h1>
<hr>

    <form method="post">
        <table border=1 align="center" cellspacing="0" cellpadding="10">
           
            <tr>
                <td> Team Name </td>
                <td> <input type="text" name="team_name" required> </td>
            </tr>
            <tr>
                <td> City </td>
                <td> <input type="text" name="city" required > </td>
            </tr>
            <tr>
                <td> Manager's Last Name </td>
                <td> <input type="text" name="Manager_lastname" required > </td>
            </tr>
            <tr>
                <td> Manager's First name </td>
                <td> <input type="text" name="Manager_firstname" required > </td>
            </tr>
            <tr>
                <td> Manager's Middle Name </td>
                <td> <input type="text" name="Manager_middlename" > </td>
            </tr>
            <tr>
            <td>
            <form method="post" enctype="multipart/form-data">
             <label for="caption">Image Name</label><br>
            <input type="text" name="caption"><br><br>
            <label for="upload">Select file: </label><br>
            <input type="file" name="upload"><br><br>
            <span>Maximum of 1mb only</span><br>
                
             </tr>
             </td>
            <tr>
                <td colspan="2">
                    <button type="submit" name="Insert"> Submit</button>
                </td>
            </tr>
    </form>
    <?php
    if(isset($_POST['Insert'])) {
            echo "<pre>";
                print_r($_FILES['upload']);
            echo "</pre>";

            // Declare variables for processing text-based data.
            $caption = trim($_POST['caption']);


            // Simplifying $_FILES['upload'] into a local variable
            $filename = $_FILES['upload']['name'];
            $filetype = $_FILES['upload']['type'];
            $tmp_name = $_FILES['upload']['tmp_name'];
            $filesize = $_FILES['upload']['size'];

            // File validation and processing
            $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/png']; // .jpg, .jpeg, .png
            $maxFileSizeLimit = 1 * 1024 * 1024; // 1mb

            if(!in_array($filetype, $allowedFileTypes)) {
                echo "<script> alert('Uploaded file not in allowed list'); </script>";
            }

            if($filesize > $maxFileSizeLimit) {
                echo "<script> alert('Uploaded file exceeds the allowed limit.'); </script>";
            }

            // Move the quarantined file to the folder
            $upload_path = "uploads/" . basename($filename);
            
            $sql = "INSERT INTO Teams (caption, filepath, filename) VALUES ('$caption', '$upload_path')";

            if(mysqli_query($conn, $sql)) {
                move_uploaded_file($tmp_name, $upload_path);
                echo "<script> alert('File is uploaded with caption'); window.location='Insert_team.php'; </script>";
            }
        }
    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
     
    <?php
        if(isset($_POST['Insert'])) {
           
            $team_name = $_POST['team_name'];
            $city = $_POST['city'];
            $Manager_Lname = $_POST['Manager_lastname'];
            $Manager_Fname = $_POST['Manager_firstname'];
            $Manager_Mname = $_POST['Manager_middlename'];
           
           
           {
                $sql = "INSERT INTO Team (Team_name, City, Manager_Lastname , Manager_Firstname , Manager_Middlename)
                 VALUES ('$team_name', '$city', '$Manager_Lname', '$Manager_Fname' , '$Manager_Mname')";
                $query = mysqli_query($conn, $sql);
                if($query) {
                    echo "<script> alert(' Team is successfully registered'); window.location='Teams.php';</script>";
                } else {
                    echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
                }
            }
                
        }
    ?>
</body>