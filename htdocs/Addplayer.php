<?php
include("db_connect.php");
include("menu.php");
include("header.php");

?>
<html>
<head>
    <link rel="stylesheet" href="addp.css">  </link>
</head>



<h1> REGISTER A PLAYER </h1>
<hr>
    <form method="post" enctype="multipart/form-data">
        <table border=1 align="center" cellspacing="0" cellpadding="10">

            
            <tr>
                <td>Last Name </td>
                <td> <input type="text" name="Lname" required> </td>
            </tr>
            <tr>
                <td>First Name </td>
                <td> <input type="text" name="Fname" required> </td>
            </tr>
            <tr>
                <td>Middle Name </td>
                <td> <input type="text" name="Mname" > </td>
            </tr>
            <tr>
                <td>Image</td>
                <td><input type="file" name="upload">

            </tr>
            <tr>
                <td> Date of Birth </td>
                <td> <input type="date" name="Birthday" required> </td>
            </tr>
            <tr>
                <td> Email </td>
                <td> <input type="text" name="email" required> </td>
            </tr>
            <tr>
                <td> Contact Number </td>
                <td> <input type="number" name="Contact" required> </td>
            </tr>
            <tr>
                <td>Team </td>
                <td>
                    <select name="Team" required>
                
                    <?php
                            $sql = "SELECT * FROM Team";
                            $query = mysqli_query($conn, $sql);
                            if (!$query) {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            } else {
                                while ($result = mysqli_fetch_assoc($query)) {
                                    echo "<option value='{$result['Team_id']}'>{$result['Team_name']}</option>";
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <button type="submit" name="Insert1"> Submit</button>
                </td>
            </tr>
            
        </table>
    </form>
    
</body>
    
    
   </html>
    <?php
    
    
    if(isset($_POST['Insert1'])) {
        $Birthday = $_POST['Birthday'];
        $Email = $_POST['email'];
        $Contact_number = $_POST['Contact'];
        $Last_name = $_POST['Lname'];
        $First_name = $_POST['Fname'];
        $Middle_name = $_POST['Mname'];
        $Team_id = $_POST['Team'];
        $filename = $_FILES['upload']['name'];
        $filetype = $_FILES['upload']['type'];
        $tmp_name = $_FILES['upload']['tmp_name'];
        $filesize = $_FILES['upload']['size'];

        $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/png']; 
            $maxFileSizeLimit = 1 * 1024 * 1024; 

            if(!in_array($filetype, $allowedFileTypes)) {
                echo "<script> alert('Uploaded file not in allowed list'); </script>";
            }

            if($filesize > $maxFileSizeLimit) {
                echo "<script> alert('Uploaded file exceeds the allowed limit.'); </script>";
            }

           
            $upload_path = "uploads/" . basename($filename);
            
            $sql = "INSERT INTO uploads (filepath) VALUES ('$upload_path')";

            if(mysqli_query($conn, $sql)) {
                move_uploaded_file($tmp_name, $upload_path);
                echo "<script> alert('File is uploaded with caption'); window.location='display-uploads.php'; </script>";
            }

        
    

    //     $sql = "SELECT * FROM Players WHERE Player_id = '$player_id'";
    //     $query = mysqli_query($conn, $sql);
        
        
    //     if(mysqli_num_rows($query) > 0) {
    //         echo "<script> alert('Player already exists'); </script>";
    //     } 
    // else {
            $sql = "INSERT INTO Players (Date_of_birth, Email, Contact_number , Last_name , First_name , Middle_name , filepath , Team_id)
             VALUES ('$Birthday', '$Email', '$Contact_number', '$Last_name' , '$First_name' , '$Middle_name' , '$Team_id' , '$upload_path')";
            $query = mysqli_query($conn, $sql);
        if($query)  {
                echo "<script> alert('Player is successfully registered'); window.location='Player_list.php';</script>";
            } else {
                echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
            }
        }
            
    // }



    ?>
    