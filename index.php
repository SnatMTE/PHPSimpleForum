<?php

require_once 'config.php';

session_start();

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM topics ORDER BY created_at DESC");
  $stmt->execute();
  $topics = $stmt->fetchAll();

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$page_name = "Forum";
include("template/header.php");
include("template/left.php");

?>

<h2>Topics</h2><hr />

<main>

        <?php foreach($topics as $topic) { ?>
          <section class="index">
          <div class="index_body"><a href="view_topic.php?id=<?php echo $topic['id']; ?>"><?php echo $topic['title']; ?></a></div>          

            <?php 
            $user_id = $topic['user_id'];
            $user_stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
            $user_stmt->execute([
                'id' => $user_id
            ]);
            $user = $user_stmt->fetch();
            echo "<div class=\"index_sidebar\">Created by ";
            echo $user['username'];
            echo "</div>"; 
            ?>
 
           <div class="grow1"><?php echo date("F jS, Y", strtotime($topic['created_at'])); ?></div>
           
          </section>
          <hr />
          <?php } ?>
    <?php if(isset($_SESSION['user'])) { ?>
      <a href="create_topic.php">Create a new topic</a>
    <?php } ?>
  </main>

<?php include("template/footer.php") ?>