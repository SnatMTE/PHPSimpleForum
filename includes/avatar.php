<?php

function getGravatarImageUrl($email, $size = 80) {
    $email = md5(strtolower(trim($email)));
    return "<img src='https://www.gravatar.com/avatar/$email?s=$size' />";
  }

?>