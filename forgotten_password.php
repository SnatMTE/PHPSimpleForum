<?php
session_start();
include 'config.php';

$page_name = "Forgot Password";
include("template/header.php");
?>
<h2>Forgotten password</h2>
<hr>
<form action="forgotten_password.php" method="post">
    <p>
        <label for="email">Email address:</label>
        <input type="email" name="email" id="email">
    </p>
    <p>
        <input type="submit" name="submit" value="Submit">
    </p>
</form>
<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([
            'email' => $email
        ]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate a new random password
            $new_password = bin2hex(random_bytes(10));

            try {
                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
                $stmt->execute([
                    'password' => password_hash($new_password, PASSWORD_BCRYPT),
                    'email' => $email
                ]);
            } catch (PDOException $e) {
                echo "Error updating password: " . $e->getMessage();
                exit;
            }

            // Send an email to the user with the new password
            $to = $email;
            $subject = "Password reset";
            $message = "Your new password is: " . $new_password;
            $headers = $site_email;
            mail($to, $subject, $message, $headers);

            echo "A new password has been sent to your email address.";
        } else {
            echo "No user found with that email address.";
        }
    } catch (PDOException $e) {
        echo "Error processing request: " . $e->getMessage();
    }
}
include("template/footer.php");
?>