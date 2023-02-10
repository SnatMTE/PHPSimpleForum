<?php
session_start();
include 'config.php';

$topic_id = $_GET['id'];
$topic = fetchData("SELECT t.*, u.username FROM topics t LEFT JOIN users u ON t.user_id = u.id WHERE t.id = :topic_id", $pdo, ['topic_id' => $topic_id]);

$topic = $topic[0] ?? [];
$replies = fetchData("SELECT * FROM replies WHERE topic_id = :topic_id", $pdo, ['topic_id' => $topic_id]);

$page_name = $topic['title'];
include("template/header.php");
include("template/left.php");

?>
<h2><?php echo $topic['title']; ?></h2>
<p>
    Created by: <?php echo $topic['username']; ?>
</p>
<p>
    <?php echo $topic['body']; ?>
</p>

<p>
    Created on: <?php echo $topic['created_at']; ?>
</p>
<hr>

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
    <section class="layout">  
        <div class="userdetail"><?php echo $user['username']; ?>
    
        <p>
        <?php
            echo getGravatarImageUrl($user['email'], 80);
        ?>
        </p>
    </div>  
        <div class="post">
            <p><?php echo date("F jS, Y", strtotime($reply['created_at'])); ?></p><?php echo $reply['body']; ?>
        </div>

    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] === 1 || $_SESSION['user']['id'] === $reply['user_id'])) { ?>
        <form action="delete_reply.php" method="post">
            <input type="hidden" name="id" value="<?php echo $reply['id']; ?>">
            <input type="hidden" name="topic_id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Delete">
        </form>
    <?php } ?>
        </section>
    <hr>
<?php } ?>
<?php if (isset($_SESSION['user'])) { ?>
    <h2>Post a Reply</h2>
<form action="post_reply.php" method="post">
    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
    
    <p>
        <textarea name="body" id="body" rows="5" cols="80"></textarea>
    </p>
    <p>
        <input type="submit" name="submit" value="Submit">
    </p>
</form>
<script>
    CKEDITOR.replace( 'body' );
</script>
<?php } else { ?>
    <p>
        Please <a href="login.php">login</a> to post a reply.
    </p>
<?php } 

include("template/footer.php");
?>