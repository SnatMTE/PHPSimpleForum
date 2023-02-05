<?php
include 'config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([
            'username' => $username
        ]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error = "Username already exists.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            header('Location: login.php');
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error signing up: " . $e->getMessage();
    }
}

$page_name = "Sign Up";
include("template/header.php")

?>
    <h1>Sign Up</h1>
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

    <?php include("template/footer.php"); ?>