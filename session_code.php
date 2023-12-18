<?php
session_start();

// Connect to the SQLite database using PDO
try {
  $db = new PDO("sqlite:database-03fdhgh732fhdff23fhdhd492/database");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['login'])) {
  $email = substr(htmlspecialchars($_POST['email']), 0, 40);
  $password = substr(htmlspecialchars($_POST['password']), 0, 40);

  // Check if the email and password fields are not empty
  if (empty($email) || empty($password)) {
    echo "Please enter both email and password.";
  } else {
    // Check if the user exists in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      // Generate a unique session ID and store it in a cookie
      $session_id = uniqid();
      setcookie('session_id', $session_id, time() + (7 * 24 * 60 * 60), '/');

      // Store the email in a cookie
      setcookie('email', $email, time() + (7 * 24 * 60 * 60), '/');

      // Store the email in the session for future use
      $_SESSION['email'] = $email;

      // Redirect the user to the homepage
      header("Location: profile/");
      exit;
    } else {
      echo "Incorrect email or password.";
    }
  }
} elseif (isset($_POST['register'])) {
  $email = substr(htmlspecialchars($_POST['email']), 0, 40);
  $password = substr(htmlspecialchars($_POST['password']), 0, 40);
  $username = substr(htmlspecialchars($_POST['username']), 0, 40);

  // Check if the email and password fields are empty
  if (empty($email) || empty($password)) {
    echo "Email and password are required.";
    exit;
  }

  // Check if the email is already taken
  $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    echo "Email already taken.";
    exit;
  } else {
    // Add the new user to the database
    $stmt = $db->prepare("INSERT INTO users (email, password, username) VALUES (:email, :password, :username)");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Generate a unique session ID and store it in a cookie
    $session_id = uniqid();
    setcookie('session_id', $session_id, time() + (7 * 24 * 60 * 60), '/');

    // Store the email in a cookie
    setcookie('email', $email, time() + (7 * 24 * 60 * 60), '/');

    // Store the email in the session for future use
    $_SESSION['email'] = $email;

    // Redirect the user to the homepage
    header("Location: settings/");
    exit;
  }
} else {
  // Check if the session ID cookie exists and restore the session if it does
  if (isset($_COOKIE['session_id'])) {
    session_id(htmlspecialchars($_COOKIE['session_id']));
  }
  if (isset($_COOKIE['email'])) {
    $_SESSION['email'] = htmlspecialchars($_COOKIE['email']);
  }
}
?>