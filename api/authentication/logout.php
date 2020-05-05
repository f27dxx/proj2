<?php
  session_start();
  echo  $_SESSION['username'];
  echo $_SESSION['user_id'];
  echo $_SESSION['privilege'];
  echo $_SESSION['logged_in'];
  session_destroy();
?>