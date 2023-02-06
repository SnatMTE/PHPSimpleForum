<?php
session_start();
include 'config.php';

$topic_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT t.*, u.username FROM topics t LEFT JOIN users u ON t.user_id = u.id WHERE t.id = :topic_id");
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

$page_name = $topic['title'];
include("template/header.php");
?>
<h1><?php echo $topic['title']; ?></h1>
<p>
    <?php echo $topic['body']; ?>
</p>
<p>
    Created by: <?php echo $topic['username']; ?>
</p>
<p>
    Created on: <?php echo $topic['created_at']; ?>
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
        <?php echo $reply['body']; ?>
    </p>
    <p>
        Replied by: <?php echo $user['username']; ?> on <?php echo $reply['created_at']; ?>
    </p>
    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] === 1 || $_SESSION['user']['id'] === $reply['user_id'])) { ?>
        <form action="delete_reply.php" method="post">
            <input type="hidden" name="id" value="<?php echo $reply['id']; ?>">
            <input type="hidden" name="topic_id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Delete">
        </form>
    <?php } ?>
    <hr>
<?php } ?>
<?php if (isset($_SESSION['user'])) { ?>
    <h2>Post a Reply</h2>
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
<?php } 

include("template/footer.php");
?>

