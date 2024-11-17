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
            <form method="post" enctype="multipart/form-data">
            <label for="upload_file">Choose a file to upload:</label><br>
            <input type="file" name="file_upload" id="upload_file"> <br>
            Maximum of 1mb per file<br>
            </form>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="Insert"> Submit</button>
                </td>
            </tr>
    </form>
    <?php 
        if(isset($_POST['Insert'])) {
            echo "<pre>";
            print_r($_FILES);
            echo "</pre>";

            /*
                Traditional Version:
                $_FILES['file_upload']['name']
                $_FILES['file_upload']['type']
                $_FILES['file_upload']['tmp_name']
                $_FILES['file_upload']['size']

                Simplified Version:
                $filename = $_FILES['file_upload']['name'];
                $filetype = $_FILES['file_upload']['type'];
                $tmpname = $_FILES['file_upload']['tmp_name'];
                $filesize = $_FILES['file_upload']['size'];

                Standard Version:
                $file_upload = $_FILES['file_upload'];
                $file_upload['name'];
                $file_upload['type'];
                $file_upload['tmp_name'];
                $file_upload['size'];
            */

            $filename = $_FILES['file_upload']['name'];
            $filetype = $_FILES['file_upload']['type'];
            $tmpname = $_FILES['file_upload']['tmp_name'];
            $filesize = $_FILES['file_upload']['size'];
            
            //Allowed File Types to be processed.
            $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'];
            if(!in_array($filetype, $allowedFileTypes)) {
                echo "<script> alert('File type does not match to the allowed types'); window.location='upload_form.php'; </script>";
                exit();
            }

            $maximumFileSize = 1 * 1024 * 1024; //impose a 1mb limit on every file upload
            if($filesize > $maximumFileSize) {
                echo "<script> alert('File only accepts 1mb only.'); window.location='upload_form.php'; </script>";
                exit();
            }
            $modifiedFilename = uniqid()."_".time()."_".uniqid()."_".$filename;
            $uploadPath = "uploads/" . basename($modifiedFilename);
            move_uploaded_file($tmpname, $uploadPath);

            $sql = "INSERT INTO Teams (file_name1, file_1path) VALUES ('$filename', '$uploadPath')";
            if(mysqli_query($conn, $sql)) {
                echo "<script> alert('Image file uploaded'); window.location='gallery.php'; </script>";
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