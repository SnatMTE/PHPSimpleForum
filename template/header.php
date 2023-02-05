<!DOCTYPE html>
<html>
<head>
  <title><?php echo $page_name . " - " . $site_name; ?></title>
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
