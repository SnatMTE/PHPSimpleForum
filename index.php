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
        <?php if(isset($_SESSION['user'])) { ?>
          <li>Hello, <?php echo $_SESSION['user']['username']; ?></li>
          <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        <?php } ?>
      </ul>
    </nav>
  </header>
  <main>
    <h2>Topics</h2>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Created By</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($topics as $topic) { ?>
          <tr>
            <td><a href="view_topic.php?id=<?php echo $topic['id']; ?>"><?php echo $topic['title']; ?></a></td>
            <td><?php echo $topic['username']; ?></td>
            <td><?php echo $topic['created_at']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php if(isset($_SESSION['user'])) { ?>
      <a href="create_topic.php">Create a new topic</a>
    <?php } ?>
  </main>
</body>
</html>