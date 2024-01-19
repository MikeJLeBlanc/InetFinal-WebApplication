<?php
session_start();
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit;
}

$conn = require "config.php";

if (isset($_GET['deleteID'])) {
    $bookingId = $_GET['deleteID'];
    $delete = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete->bind_param("i", $bookingId);

    if ($delete->execute()) {
        header("location: users.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM users";
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
</head>
<body>
<h1> Here are all the users:</h1>
<a href="newUser.html"><button>New User</button></a>
<a href="index.php"><button>Main Menu</button></a>
<table class="table">
    <thead>
    <tr>
        <th>Member ID</th>
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
                        <a href='users.php?deleteID=" . $row['id'] . "'>Remove User</a>
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