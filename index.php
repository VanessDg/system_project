<?php
session_start();
include "db.php"; // basta database connection i2

$error_message = ""; // sa error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        // check sa database
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (hash("sha256", $password) === $row["password"]) {
            $_SESSION["admin"] = $username; // Start if success mapupunta sa dashboard
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
            } else {
                $error_message = "Invalid email password!";
            }
        } else {
            $error_message = "Admin not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <h2>Admin Login</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error" style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <div class="input-field">
                <input type="text" name="username" required>
                <label>Enter your username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember">
                    <p>Remember me</p>
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>
