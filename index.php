<?php
$db = new PDO('sqlite:database-03fdhgh732fhdff23fhdhd492/database');
$db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, email TEXT, password TEXT, picture TEXT, background TEXT, link1 TEXT, link2 TEXT, link3 TEXT, link4 TEXT, link5 TEXT, link6 TEXT, link7 TEXT, link8 TEXT, link9 TEXT, link10 TEXT, bio TEXT, born TEXT, region TEXT)');
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReLinkTrees - Login/Register</title>
    <?php include('bootstrapcss.php'); ?>
    <link rel="icon" type="image/png" href="contents/favicon.svg">
  </head>
  <body>
    <div class="vh-100 position-fixed top-0 start-0 w-100 h-100" style="background-image: url('/contents/background.jpg'); background-size: cover; background-repeat: no-repeat;">
      <div id="login-form" class="container position-absolute start-50 top-50 translate-middle bg-transparent rounded-5" style="max-width: 315px;">
        <h1 class="fw-bold text-center text-shadow mt-3">Login</h1>
        <div class="modal-body p-3">
          <form class="p-0" action="session_code.php" method="post">
            <div class="form-floating mb-3">
              <input name="email" type="email" class="form-control rounded-3 shadow bg-dark bg-opacity-75 border-0" id="floatingInput" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="name@example.com" required>
              <label class="fw-medium" for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input name="password" type="password" class="form-control rounded-3 shadow bg-dark bg-opacity-75 border-0" id="floatingPassword" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="Password" required>
              <label class="fw-medium" for="floatingPassword">Password</label>
            </div>
            <button name="login" class="w-100 fw-bold mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
            <h6 class="text-shadow">Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></h6>
          </form>
        </div>
      </div>
      <div id="register-form" class="container position-absolute start-50 top-50 translate-middle bg-transparent rounded-5" style="max-width: 315px; display: none;">
        <h1 class="fw-bold text-center text-shadow mt-3">Register</h1>
        <div class="modal-body p-3">
          <form class="p-0" action="session_code.php" method="post">
             <div class="form-floating mb-3">
              <input name="username" type="text" class="form-control rounded-3 shadow bg-dark bg-opacity-75 border-0" maxlength="40" id="floatingInput" placeholder="Username" required>
              <label class="fw-medium" for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input name="email" type="email" class="form-control rounded-3 shadow bg-dark bg-opacity-75 border-0" id="floatingInput" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="name@example.com" required>
              <label class="fw-medium" for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input name="password" type="password" class="form-control rounded-3 shadow bg-dark bg-opacity-75 border-0" id="floatingPassword" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="Password" required>
              <label class="fw-medium" for="floatingPassword">Password</label>
            </div>
            <button name="register" class="w-100 fw-bold mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Register</button>
            <h6 class="text-shadow">Already have an account? <a href="#" onclick="showLoginForm()">Login</a></h6>
          </form>
        </div>
      </div>
    <style>
      .text-shadow {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6), 2px 2px 4px rgba(0, 0, 0, 0.8), 5px 5px 6px rgba(0, 0, 0, 0.2);
      }
    </style>    </div>

    <script>
      function showLoginForm() {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('register-form').style.display = 'none';
      }

      function showRegisterForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
      }
    </script>
    <?php include('bootstrapjs.php'); ?>
  </body>
</html>