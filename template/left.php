<div id="leftcolumn">
<header>
    <nav>
      <ul>
        <?php if(isset($_SESSION['user'])) { ?>
            <?php
              echo getGravatarImageUrl($_SESSION['user']['email'], 80);
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