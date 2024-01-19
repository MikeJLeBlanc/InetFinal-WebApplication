<?php
session_start();
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit;
}

$conn = require "config.php";

if (isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];
    $delete = $conn->prepare("DELETE FROM trainer WHERE id = ?");
    $delete->bind_param("i", $id);

    if ($delete->execute()) {
        header("location: booking.php");
    } else {
        echo "Error: " . $conn->error;
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
    <title>Trainer Admin Panel</title>
</head>
<body>
<h1> Here are all the trainers: </h1>
<a href="newTrainer.html"><button>New Trainer</button></a>
<a href="index.php"><button>Main Menu</button></a>

<table class="table">
    <thead>
    <tr>
        <th>Trainer ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created on:</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) {
        echo " <tr> 
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['creationDate'] . "</td>
                    <td>
                        <a href='trainers.php?deleteID=" . $row['id'] . "'>Remove Trainer</a>
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