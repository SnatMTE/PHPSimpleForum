<?php
session_start();
include 'config.php';

$reply_id = $_POST['id'];
$topic_id = $_POST['topic_id'];

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']) || $_SESSION['user']['id'] != 1) {
    header('Location: view_topic.php?id=' . $topic_id);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM replies WHERE id = :reply_id");
    $stmt->execute([
        'reply_id' => $reply_id
    ]);
} catch (PDOException $e) {
    echo "Error deleting reply: " . $e->getMessage();
    exit;
}

header('Location: view_topic.php?id=' . $topic_id);
exit;