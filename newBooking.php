<?php
session_start();
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit;
}

$conn = require "config.php";

if (isset($_GET['id'])) {
    $trainer = $_GET['id'];
    $userID = $_SESSION["userID"];
    $insert = "INSERT INTO bookings (userID, trainerID) VALUES (?, ?)";
    $stmt = $conn->stmt_init();

    if (!$stmt->prepare($insert)) {
        die("SQL error at prepare: " . $conn->error);
    }

    $stmt->bind_param("ii", $userID, $trainer);
    if ($stmt->execute()) {
        header("location: booking.php");
        exit;
    } else {
        die("SQL error at execute: " . $conn->error);
    }
}

    $sql = "SELECT * FROM trainer";
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
    <title>New Booking</title>
</head>
<body>
<h1> Here are the trainers:</h1>
<table class="table">
    <thead>
    <tr>
        <th>Trainer ID</th>
        <th>Trainer Name</th>
        <th>Trainer Email</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) {
        echo " <tr> 
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>
                        <a href='newBooking.php?id=" . $row['id'] . "'>Book Session</a>
                    </td>
                </tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>
