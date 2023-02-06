<div id="leftcolumn">
<header>
    <nav>
      <ul>
        <?php if(isset($_SESSION['user'])) { ?>
            <?php

            $email = $_SESSION['user']['email'];
            $hash = md5(strtolower(trim($email)));
            $url = "https://www.gravatar.com/avatar/$hash";

            // Check if the Gravatar exists
            $response = get_headers($url, 1);
            if (strpos($response[0], "200") === false) {
                // Gravatar does not exist, display default image
                echo '<img src="default-gravatar.jpg" alt="Gravatar">';
            } else {
                // Gravatar exists, display it
                echo '<img src="' . $url . '" alt="Gravatar">';
            }

            ?>

          <li>Hello, <a href="user.php"><?php echo $_SESSION['user']['username']; ?></a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        <?php } ?>
      </ul>
    </nav>
  </header>
        </div>
        <div id="content">