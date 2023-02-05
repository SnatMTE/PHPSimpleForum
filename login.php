<?php
session_start();
include 'config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([
            'username' => $username
        ]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Incorrect username or password.";
        }
    } catch (PDOException $e) {
        $error = "Error logging in: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<p><a href="./">Go back to forum</a></p>
    <h1>Login</h1>
    <hr>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form action="" method="post">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
    </form>
    <p>
        Don't have an account? <a href="signup.php">Sign up here</a>.
    </p>
</body>
</html>
