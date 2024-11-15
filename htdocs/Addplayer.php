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
    <form method="post">
        <table border=1 align="center" cellspacing="0" cellpadding="10">

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
    

    //     $sql = "SELECT * FROM Players WHERE Player_id = '$player_id'";
    //     $query = mysqli_query($conn, $sql);
        
        
    //     if(mysqli_num_rows($query) > 0) {
    //         echo "<script> alert('Player already exists'); </script>";
    //     } 
    // else {
            $sql = "INSERT INTO Players (Date_of_birth, Email, Contact_number , Last_name , First_name , Middle_name , Team_id)
             VALUES ('$Birthday', '$Email', '$Contact_number', '$Last_name' , '$First_name' , '$Middle_name' , '$Team_id')";
            $query = mysqli_query($conn, $sql);
        if($query)  {
                echo "<script> alert('Player is successfully registered'); window.location='Player_list.php';</script>";
            } else {
                echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn) . "'); </script>";
            }
        }
            
    // }



    ?>
    