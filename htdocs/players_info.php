
<?php
include "db_connect.php";
include "menu.php";
include "header.php";   
?>
<?php 
     $player_id = trim($_GET['player_id']);
     $team = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Players WHERE player_id = '$team_id'"));
    ?>

    <h1 align="center"> Player Information</h1>
    
    <table class="player-table" border="1" align="center" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Players WHERE player_id = '$player_id' ORDER BY Last_name ASC";
            $query = mysqli_query($conn, $sql);
            if (!$query) {
                echo "<tr><td colspan='4'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</td></tr>";
            } else {
                while ($result = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $result["Last_name"] . ", " . $result["First_name"] . " " . $result["Middle_name"] . "</td>";
                    echo "<td>" . date("F d, Y", strtotime($result["Date_of_birth"])) . "</td>";
                    echo "<td>" . $result["Email"] . "</td>";
                    echo "<td>" . $result["Contact_number"] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

