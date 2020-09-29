<?php


require_once __DIR__.'/../../boot/boot.php';

use Hotel\User; 
 if(!empty(User::getCurrentUserId())){
    
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Red+Rose:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css" />
    <script
      src="https://kit.fontawesome.com/6cdc5b8190.js"
      crossorigin="anonymous"
    ></script>
    <title>Luxsio</title>
  </head>
  <body>
    <header>
      <div class="nav-container">
        <!-- Main nav -->
        <div class="logo">
          <a href="index.php">
            <img src="images/trans-logo.png" alt="Luxsio"/>
          </a>
        </div>
        <nav>
          <ul class="nav-links">
            <li><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
            <?php  if(empty(User::getCurrentUserId())):?>
            <li><a href="login.php" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <?php else: ?>
              <li><a href="profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
            <?php endif; ?>
          </ul>
          <!-- Burger for main nav -->
          <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
          </div>
        </nav>
      </div>
    </header>