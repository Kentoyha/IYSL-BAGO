<?php 
include 'db_connect.php';   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Class - PHP File Uploads</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label for="caption">Caption</label><br>
            <input type="text" name="caption"><br><br>
        <label for="upload">Select file: </label><br>
            <input type="file" name="upload"><br><br>
            <span>Maximum of 1mb only</span><br>
        <button type="submit" name='process-upload'>Upload</button>
    </form>

    <?php
        if(isset($_POST['process-upload'])) {
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
            
            // Get the current timestamp for date_uploaded
            $date_uploaded = date('Y-m-d H:i:s');

            // Insert into the database
            $sql = "INSERT INTO images (image_name, image_path, date_uploaded) VALUES ('$caption', '$upload_path', '$date_uploaded')";

            if(mysqli_query($conn, $sql)) {
                // Move the file to the target directory
                move_uploaded_file($tmp_name, $upload_path);
                echo "<script> alert('File is uploaded with caption'); window.location='display-uploads.php'; </script>";
            } else {
                echo "<script> alert('Error: Could not save image information to database'); </script>";
            }
        }
        if (isset($_GET['delete_id'])) {
            // Get the image ID to delete
            $image_id = $_GET['delete_id'];
    
            // Fetch the image details from the database to get the file path
            $sql = "SELECT image_path FROM images WHERE id = '$image_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $image_path = $row['image_path'];
    
            // Delete the image from the database
            $delete_sql = "DELETE FROM images WHERE id = '$image_id'";
            if (mysqli_query($conn, $delete_sql)) {
                // Delete the file from the server
                if (file_exists($image_path)) {
                    unlink($image_path);  // Removes the image from the server
                }
                echo "<script> alert('Image deleted successfully'); window.location='upload-display.php'; </script>";
            }
        }
        $sql = "SELECT image_name, image_path, date_uploaded FROM images ORDER BY date_uploaded DESC";
        $result = mysqli_query($conn, $sql);
    ?>
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Loop through the result set and display each image
        while ($row = mysqli_fetch_assoc($result)) {
            $image_name = $row['image_name'];
            $image_path = $row['image_path'];
            $date_uploaded = $row['date_uploaded'];

            // Display the image with its caption and date
            echo "<div>";
            echo "<h3>$image_name</h3>";
            echo "<img src='$image_path' alt='$image_name' width='300'><br>";
            echo "<p>Uploaded on: $date_uploaded</p>";
            echo "<a href='upload-display.php?delete_id=$image_id' onclick='return confirm(\"Are you sure you want to delete this image?\")'>
                        <button class='delete-button'>Delete</button></a>";
            echo "</div><br>";
        }
    } else {
        echo "<p>No images uploaded yet.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
?>
</body>

</html>
