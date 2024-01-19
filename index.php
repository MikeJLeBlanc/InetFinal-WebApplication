<?php
    session_start();

    if (isset($_SESSION["userID"])) {
        $db = require __DIR__ . "/config.php";
        $sql = "SELECT * FROM users WHERE id = {$_SESSION["userID"]}";
        $result = $db->query($sql);
        $user = $result->fetch_assoc();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <title>Log-In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>
<body>
    <nav>
        <?php if (!isset($user)): ?>
            <a href="trainer/index.php">Trainer Login</a>
            <a href="admin/index.php">Admin Login</a>
        <?php endif; ?>
    </nav>
    <h1>Home</h1>
    <?php if (isset($user)): ?>
        <p>Hello, <?=htmlspecialchars($user["name"]) ?></p>
        <a href="booking.php"><button>View your sessions</button></a>
        <a href="logout.php"><button>Log out</button></a>
    <?php else: ?>
        <p><a href="login.php">Login</a> or <a href="signup.html">Sign Up</a></p>
    <?php endif; ?>    
</body>
</html>