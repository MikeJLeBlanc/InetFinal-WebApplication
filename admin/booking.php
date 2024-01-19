<?php
    session_start();
    if (!isset($_SESSION["userID"])) {
        header("Location: login.php");
        exit;
    }
    
    $conn = require "config.php";

    if (isset($_GET['deleteID'])) {
        $bookingId = $_GET['deleteID'];
        $delete = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $delete->bind_param("i", $bookingId);

        if ($delete->execute()) {
            header("location: booking.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $sql = "SELECT bookings.id, bookings.userID, bookings.trainerID, bookings.creationDate, users.name AS uName, trainer.name AS tName FROM bookings 
            INNER JOIN users ON bookings.userID = users.id
            INNER JOIN trainer ON bookings.trainerID = trainer.id";
    $result = $conn->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
    <title>Booking records</title>
</head>
<body>
<h1> Here are all bookings: </h1>
<a href="index.php"><button>Main Menu</button></a>
    <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Member</th>
                <th>Trainer</th>
                <th>Booked on:</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) {
                echo " <tr> 
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['uName'] . "</td>
                    <td>" . $row['tName'] . "</td>
                    <td>" . $row['creationDate'] . "</td>
                    <td>
                        <a href='booking.php?deleteID=" . $row['id'] . "'>Cancel</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="/logout.php"><button>Log out</button></a>
</body>
</html>