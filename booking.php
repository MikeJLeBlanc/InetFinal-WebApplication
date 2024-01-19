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

    $sql = "SELECT bookings.id, bookings.trainerID, bookings.creationDate, trainer.name FROM bookings 
            INNER JOIN trainer ON bookings.trainerID = trainer.id WHERE userID = $_SESSION[userID]";
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
    <title>Your Bookings</title>
</head>
<body>
<h1> Here are your bookings: </h1>
    <a href="newBooking.php"><button>New Booking</button></a>
    <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Creation Date</th>
                <th>With Trainer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) {
                echo " <tr> 
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['creationDate'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>
                        <a href='booking.php?deleteID=" . $row['id'] . "'>Cancel Session</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="logout.php"><button>Log out</button></a>
</body>
</html>