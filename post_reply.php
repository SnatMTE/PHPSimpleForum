<?php
session_start();
include 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $user_id = $_SESSION['user']['id'];
        echo $user_id;

        $stmt = $pdo->prepare("INSERT INTO replies (body, created_at, user_id, topic_id) VALUES (:body, NOW(), :user_id, :topic_id)");

        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: view_topic.php?id=' . $topic_id);
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>