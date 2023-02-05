<?php
session_start();
include 'config.php';

$topic_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM topics WHERE id = :topic_id");
    $stmt->execute([
        'topic_id' => $topic_id
    ]);
    $topic = $stmt->fetch();
} catch (PDOException $e) {
    echo "Error loading topic: " . $e->getMessage();
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM replies WHERE topic_id = :topic_id");
    $stmt->execute([
        'topic_id' => $topic_id
    ]);
    $replies = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error loading replies: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Topic</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <p><a href="./">Go back to forum</a></p>
    <h1><?php echo $topic['title']; ?></h1>
    <p>
        <?php echo $topic['body']; ?>
    </p>
    <hr>
    <h2>Replies</h2>
    <?php foreach ($replies as $reply) { 
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
            $stmt->execute([
                'user_id' => $reply['user_id']
            ]);
            $user = $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error loading user: " . $e->getMessage();
            exit;
        }
    ?>
        <p>
            <strong><?php echo $user['username']; ?></strong> posted on <?php echo $reply['created_at']; ?><br>
            <?php echo $reply['body']; ?>
        </p>
        <hr>
    <?php } ?>
    <?php if (isset($_SESSION['user'])) { ?>
        <h2>Post a Reply as <?php echo $_SESSION['user']['username']; ?>.</h2>
        <form action="post_reply.php" method="post">
            <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
            <p>
                <textarea name="body" rows="5" cols="80"></textarea>
            </p>
            <p>
            <input type="submit" name="submit" value="Submit">
            </p>
        </form>
    <?php } else { ?>
        <p>
            Please <a href="login.php">login</a> to post a reply.
        </p>
    <?php } ?>
</body>
</html>
