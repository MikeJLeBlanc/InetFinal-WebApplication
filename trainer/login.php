<?php
    $isInvalid = false;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $db = require "config.php";
        $sql = sprintf("SELECT * FROM trainer WHERE email = '%s'", $db->real_escape_string($_POST["email"]));

        $result = $db->query($sql); // Executes statement
        $user = $result->fetch_assoc(); // Gets data

        if ($user) {
            if (password_verify($_POST["password"], $user["passHash"])) {
                session_start();

                session_regenerate_id();
                $_SESSION["userID"] = $user["id"];

                header("Location: index.php");
                exit;
            }
        }
        $isInvalid = true;
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Log-In</title>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
    </head>
    <body>
        <h1>Login</h1>
        <form method="POST">
            <div class="mb-3">
                <?php if ($isInvalid): ?>
                    <em>Invalid username or password</em>
                <?php endif; ?>
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" value="<?php htmlspecialchars(isset($_POST["email"]) ? $_POST["email"] : "")?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" onclick="return validateForm()">Submit</button>
        </form>
        <script src="../validation.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
