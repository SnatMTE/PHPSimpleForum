<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $new_password = $_POST['password'];
    $new_email = $_POST['email'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET password = :password, email = :email WHERE id = :id");
        $stmt->execute([
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
            'email' => $new_email,
            'id' => $_SESSION['user']['id']
        ]);
    } catch (PDOException $e) {
        echo "Error updating password and email: " . $e->getMessage();
        exit;
    }

    header('Location: index.php');
    exit;
}

$page_name = "User Profile";
include("template/header.php");
?>

    <h2>Change Password and Email</h2>
    <form action="user.php" method="post">
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <label for="email">New Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php include("template/footer.php"); ?>
