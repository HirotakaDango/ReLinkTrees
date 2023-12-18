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
      <div id="login-form" class="container position-absolute start-50 top-50 translate-middle bg-dark rounded-5 p-3 bg-opacity-50" style="max-width: 315px;">
        <h1 class="fw-bold text-center mb-5 mt-3">Login</h1>
        <div class="modal-body p-4 pt-0">
          <form class="" action="session_code.php" method="post">
            <div class="form-floating mb-3">
              <input name="email" type="email" class="form-control rounded-3 bg-dark bg-opacity-25" id="floatingInput" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="name@example.com" required>
              <label class="fw-medium" for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input name="password" type="password" class="form-control rounded-3 bg-dark bg-opacity-25" id="floatingPassword" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="Password" required>
              <label class="fw-medium" for="floatingPassword">Password</label>
            </div>
            <button name="login" class="w-100 fw-bold mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
            <p>Don't have an account? <a href="#" onclick="showRegisterForm()">Register</a></p>
          </form>
        </div>
      </div>
      <div id="register-form" class="container position-absolute start-50 top-50 translate-middle bg-dark rounded-5 p-3 bg-opacity-50" style="max-width: 315px; display: none;">
        <h1 class="fw-bold text-center mb-5 mt-3">Register</h1>
        <div class="modal-body p-4 pt-0">
          <form class="" action="session_code.php" method="post">
             <div class="form-floating mb-3">
              <input name="username" type="text" class="form-control rounded-3 bg-dark bg-opacity-25" maxlength="40" id="floatingInput" placeholder="Username" required>
              <label class="fw-medium" for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input name="email" type="email" class="form-control rounded-3 bg-dark bg-opacity-25" id="floatingInput" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="name@example.com" required>
              <label class="fw-medium" for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input name="password" type="password" class="form-control rounded-3 bg-dark bg-opacity-25" id="floatingPassword" maxlength="40" pattern="^[a-zA-Z0-9_@.-]+$" placeholder="Password" required>
              <label class="fw-medium" for="floatingPassword">Password</label>
            </div>
            <button name="register" class="w-100 fw-bold mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Register</button>
            <p>Already have an account? <a href="#" onclick="showLoginForm()">Login</a></p>
          </form>
        </div>
      </div>
    </div>
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