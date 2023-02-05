<?php

require_once 'config.php';

session_start();

if(!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    if(isset($_POST['submit'])) {
      $title = $_POST['title'];
      $body = $_POST['body'];
      $user_id = $_SESSION['user']['id'];
      $stmt = $pdo->prepare("INSERT INTO topics (title, body, created_at, user_id) VALUES (:title, :body, NOW(), :user_id)");
      
      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':body', $body);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
  
      header('Location: index.php');
      exit;
    }
  
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Forum</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <h2>Create a new topic as <?php echo $_SESSION['user']['username']; ?>.</h2>
    <form action="" method="post">
      <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
      </div>
      <div>
        <label for="body">Body</label>
        <textarea name="body" id="body"></textarea>
      </div>
      <div>
        <input type="submit" name="submit" value="Submit">
      </div>
    </form>
  </main>
</body>
</html>