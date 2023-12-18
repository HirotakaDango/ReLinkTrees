<?php
// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
  // Redirect to the login page or handle unauthorized access
  header("Location: /");
  exit();
}

// Database connection
try {
  $db = new PDO('sqlite:../database-03fdhgh732fhdff23fhdhd492/database'); // Adjust the path and file name as needed
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}

// Fetch the specific user
$query = $db->prepare('SELECT * FROM users WHERE email = :email');
$query->execute([':email' => $_SESSION['email']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Handle form submission for picture and background updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Generate a unique ID
  $uniqueID = uniqid();

  // Process profile picture upload
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    // Delete previous picture if exists
    $previousPicture = $user['picture'];
    if (!empty($previousPicture) && file_exists('../pictures/' . $previousPicture)) {
      unlink('../pictures/' . $previousPicture);
    }

    // Upload new picture with unique ID
    $pictureName = $uniqueID . '_profile.jpg'; // Adjust the naming convention as needed
    $uploadPath = '../pictures/' . $pictureName;

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
      // Update the database with the new picture name
      $updateQuery = $db->prepare('UPDATE users SET picture = :picture WHERE email = :email');
      $updateQuery->execute([':picture' => $pictureName, ':email' => $_SESSION['email']]);
    } else {
      // Handle the file upload error
      echo "Failed to move the uploaded file.";
      exit();
    }
  }

  // Process background image upload
  if (isset($_FILES['background_image']) && $_FILES['background_image']['error'] === UPLOAD_ERR_OK) {
    // Delete previous background if exists
    $previousBackground = $user['background'];
    if (!empty($previousBackground) && file_exists('../backgrounds/' . $previousBackground)) {
      unlink('../backgrounds/' . $previousBackground);
    }

    // Upload new background with unique ID
    $backgroundName = $uniqueID . '_background.jpg'; // Adjust the naming convention as needed
    $uploadPath = '../backgrounds/' . $backgroundName;

    if (move_uploaded_file($_FILES['background_image']['tmp_name'], $uploadPath)) {
      // Update the database with the new background name
      $updateQuery = $db->prepare('UPDATE users SET background = :background WHERE email = :email');
      $updateQuery->execute([':background' => $backgroundName, ':email' => $_SESSION['email']]);
    } else {
      // Handle the file upload error
      echo "Failed to move the uploaded file.";
      exit();
    }
  }

  // Update other columns in the users table
  $updateQuery = $db->prepare('
    UPDATE users SET
    link1 = :link1,
    link2 = :link2,
    link3 = :link3,
    link4 = :link4,
    link5 = :link5,
    link6 = :link6,
    link7 = :link7,
    link8 = :link8,
    link9 = :link9,
    link10 = :link10,
    bio = :bio,
    born = :born,
    region = :region,
    username = :username
    WHERE email = :email
  ');

  $updateQuery->execute([
    ':link1' => $_POST['link1'],
    ':link2' => $_POST['link2'],
    ':link3' => $_POST['link3'],
    ':link4' => $_POST['link4'],
    ':link5' => $_POST['link5'],
    ':link6' => $_POST['link6'],
    ':link7' => $_POST['link7'],
    ':link8' => $_POST['link8'],
    ':link9' => $_POST['link9'],
    ':link10' => $_POST['link10'],
    ':bio' => nl2br($_POST['bio']),
    ':born' => $_POST['born'],
    ':region' => $_POST['region'],
    ':username' => $_POST['username'],
    ':email' => $_SESSION['email']
  ]);

  // Redirect to prevent form resubmission
  header("Location: /settings/");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <?php include('../bootstrapcss.php'); ?>
    <link rel="icon" type="image/png" href="../contents/favicon.svg">
  </head>
  <body>
    <div class="container mt-3 mb-5">
      <a class="btn btn-outline-light position-absolute top-0 start-0 m-3 rounded-pill fw-bold border-0" href="../profile/">back to profile</a>
      <br>
      <h2 class="fw-bold text-center mt-5 mb-5">Edit Profile</h2>
      <form method="post" enctype="multipart/form-data">
        <div class="mb-2 row">
          <label for="username" class="col-md-4 col-form-label text-nowrap fw-medium">Username :</label>
          <div class="col-md-8">
            <input type="text" name="username" class="form-control fw-bold text-white" value="<?php echo $user['username']; ?>">
          </div>
        </div>
        <div class="mb-2 row">
          <label for="password" class="col-md-4 col-form-label text-nowrap fw-medium">Password :</label>
          <div class="col-md-8">
            <input type="password" name="password" class="form-control fw-bold text-white" value="<?php echo $user['password']; ?>">
          </div>
        </div>
        <div class="mb-2 row">
          <label for="bio" class="col-md-4 col-form-label text-nowrap fw-medium">Bio :</label>
          <div class="col-md-8">
            <textarea name="bio" class="form-control fw-bold text-white vh-100" oninput="stripHtmlTags(this)"><?php echo strip_tags($user['bio']); ?></textarea>
          </div>
        </div>
        <div class="mb-2 row">
          <label for="born" class="col-md-4 col-form-label text-nowrap fw-medium">Born :</label>
          <div class="col-md-8">
            <input type="date" name="born" class="form-control fw-bold text-white" value="<?php echo $user['born']; ?>">
          </div>
        </div>
        <div class="mb-2 row">
          <label for="region" class="col-md-4 col-form-label text-nowrap fw-medium">Region :</label>
          <div class="col-md-8">
            <input type="text" name="region" class="form-control fw-bold text-white" value="<?php echo $user['region']; ?>">
          </div>
        </div>
        <div class="mb-2 row">
          <label for="picture" class="col-md-4 col-form-label text-nowrap fw-medium">Profile Picture :</label>
          <div class="col-md-8">
            <input type="file" name="profile_picture" class="form-control fw-bold text-white">
          </div>
        </div>
        <div class="mb-2 row">
          <label for="background" class="col-md-4 col-form-label text-nowrap fw-medium">Background :</label>
          <div class="col-md-8">
            <input type="file" name="background_image" class="form-control fw-bold text-white">
          </div>
        </div>
        <?php for ($i = 1; $i <= 10; $i++) : ?>
          <div class="mb-2 row">
            <label for="link<?php echo $i; ?>" class="col-md-4 col-form-label text-nowrap fw-medium">Link <?php echo $i; ?> :</label>
            <div class="col-md-8">
              <input type="text" name="link<?php echo $i; ?>" class="form-control fw-bold text-white" value="<?php echo $user['link' . $i]; ?>">
            </div>
          </div>
        <?php endfor; ?>
        <button class="btn btn-outline-light rounded w-100 fw-bold mt-3" type="submit">Update Profile</button>
      </form>
    </div>
    <?php include('../bootstrapjs.php'); ?>
  </body>
</html>
