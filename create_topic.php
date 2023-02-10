<?php

require_once 'config.php';

session_start();

if(!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

  try {
  
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $user_id = $_SESSION['user']['id'];
        executeQuery("INSERT INTO topics (title, body, created_at, user_id) VALUES (:title, :body, NOW(), :user_id)", $pdo, [
            ':title' => $title,
            ':body' => $body,
            ':user_id' => $user_id
        ]);

        header('Location: index.php');
        exit();
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

  $page_name = "Create new topic";
  include("template/header.php");
  include("template/left.php");?>

<main>
  <h2>Create a new topic as <?php echo $_SESSION['user']['username']; ?>.</h2><hr />
  <form action="" method="post">
    <div>
      <label for="title">Title</label><br />
      <input type="text" name="title" id="title">
    </div><br />
    <div>
      <label for="body">Body</label>
      <textarea name="body" id="body"></textarea>
    </div>
    <div><br />
      <input type="submit" name="submit" value="Submit">
    </div>
  </form>
  <script>
    CKEDITOR.replace('body');
  </script>
</main>


<?php include("template/footer.php") ?>