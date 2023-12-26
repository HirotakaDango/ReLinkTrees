<?php
// Get the requested path
$requestPath = trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $requestPath);

// Check if the URL matches the expected pattern (user/id)
if (count($parts) == 2 && $parts[0] == 'user') {
  $userID = $parts[1];

  // SQLite database file path
  $databasePath = '../database-03fdhgh732fhdff23fhdhd492/database';

  try {
    // Create a new PDO database connection
    $pdo = new PDO("sqlite:$databasePath");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select user data based on the provided user ID
    $query = "SELECT * FROM users WHERE id = :id";

    // Prepare and execute the query
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $userID);
    $statement->execute();

    // Fetch the user data as an associative array
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    $pdo = null;

  } catch (PDOException $e) {
    // Display an error message if the connection or query fails
    die("Error: " . $e->getMessage());
  }
} else {
  // Redirect to the default page if the URL doesn't match the expected pattern
  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="/pictures/<?php echo !empty($user['picture']) ? $user['picture'] : 'profile.jpg'; ?>"/>
    <meta property="og:title" content="<?php echo $user['username']; ?>'s Profile"/>
    <meta property="og:description" content="This is <?php echo $user['username']; ?>'s Profile"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; ?>/users/?id=<?php echo $user['id']; ?>">
    <title><?php echo $user['username']; ?>'s Profile</title>
    <link rel="icon" type="image/png" href="../pictures/<?php echo !empty($user['picture']) ? $user['picture'] : '../contents/profile.jpg'; ?>">
    <?php include('../bootstrapcss.php'); ?>
  </head>
  <body>
    <div class="vh-100 position-fixed top-0 start-0 w-100 h-100" style="background-image: url('<?php echo !empty($user['background']) ? "../backgrounds/{$user['background']}" : '../contents/background.jpg'; ?>'); background-size: cover; background-repeat: no-repeat;">
      <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="hide-scrollbar text-center w-100 overflow-auto h-100" style="max-width: 305px;">
            <br><br>
            <div class="bg-dark rounded-5 bg-opacity-25 p-4 position-relative">
              <img class="rounded-circle object-fit-cover" height="150" width="150" src="../pictures/<?php echo !empty($user['picture']) ? $user['picture'] : '../contents/profile.jpg'; ?>" alt="Profile Image">
              <h2 class="mt-3 fw-bold text-shadow"><?php echo isset($user['username']) ? $user['username'] : 'User did not exist.'; ?></h2>
              <p class="fw-medium text-shadow small"><?php echo isset($user['region']) ? $user['region'] . ' - ' . ($user['born'] ? date('Y/m/d', strtotime($user['born'])) : 'No birthdate available') : 'No data available'; ?></p>
              <?php
                if (isset($user['bio'])) {
                  // Get the full description
                  $fullDesc = $user['bio'];

                  // Limit the description to 120 characters (words)
                  $limitedDesc = substr($user['bio'], 0, 100);

                  // Check if the full description is longer than the limited description
                  if (strlen($user['bio']) > strlen($limitedDesc)) {
                    // If it is, add a "full view" link
                    $limitedDesc .= '... <button type="button" class="btn btn-sm fw-medium border-0" data-bs-toggle="modal" data-bs-target="#bioData">read more</button>';
                  }
                } else {
                  // Handle the case where $user['bio'] is not set
                  $fullDesc = $limitedDesc = "Bio not available";
                }
              ?>
              <p class="fw-medium text-shadow"><?php echo $limitedDesc; ?></p>
              <button class="btn border-0 position-absolute top-0 end-0 m-2" onclick="sharePage()"><i class="fa-solid fa-share-nodes fs-3"></i></button>
              <div>
                <?php
                  // Define the social media links and their corresponding icons
                  $socialMediaIcons = [
                    'twitter' => 'fa-brands fa-x-twitter',
                    'pixiv' => 'fa-brands fa-pixiv',
                    'github' => 'fa-brands fa-github',
                    'gitlab' => 'fa-brands fa-gitlab',
                    'linkedin' => 'fa-brands fa-linkedin',
                    'facebook' => 'fa-brands fa-facebook',
                    'instagram' => 'fa-brands fa-instagram',
                    'snapchat' => 'fa-brands fa-snapchat',
                    'whatsapp' => 'fa-brands fa-whatsapp',
                    'telegram' => 'fa-brands fa-telegram',
                    'pinterest' => 'fa-brands fa-pinterest',
                    'tumblr' => 'fa-brands fa-tumblr',
                    'flickr' => 'fa-brands fa-flickr',
                    'reddit' => 'fa-brands fa-reddit',
                    'skype' => 'fa-brands fa-skype',
                    'discord' => 'fa-brands fa-discord',
                    'twitch' => 'fa-brands fa-twitch',
                    'youtube' => 'fa-brands fa-youtube',
                    'vimeo' => 'fa-brands fa-vimeo',
                    'soundcloud' => 'fa-brands fa-soundcloud',
                    'spotify' => 'fa-brands fa-spotify',
                    'google' => 'fa-brands fa-google',
                    'yahoo' => 'fa-brands fa-yahoo',
                    'microsoft' => 'fa-brands fa-microsoft',
                    'stackoverflow' => 'fa-brands fa-stack-overflow',
                    'behance' => 'fa-brands fa-behance',
                    'dribbble' => 'fa-brands fa-dribbble',
                    'medium' => 'fa-brands fa-medium',
                    // Add more social media links and their icons as needed
                  ];
                  
                  for ($i = 1; $i <= 10; $i++) {
                    $linkKey = 'link' . $i;
                    $link = isset($user[$linkKey]) ? $user[$linkKey] : null;
    
                    $userId = isset($user['id']) ? $user['id'] : null;
                    
                    if (!empty($link) && !empty($userId)) {
                      // Prefix 'https://' if missing
                      $url = strpos($link, 'http') === false ? 'https://' . $link : $link;

                      // Extract social media name from the link using string manipulation
                      $socialMediaName = strtolower(preg_replace('#^https?://(?:www\.)?([a-z]+)\.com/.*$#', '$1', $url));

                      // Customize display names for specific social media platforms
                      switch ($socialMediaName) {
                        case 'github':
                          $socialMediaDisplayName = 'GitHub';
                          break;
                        case 'gitlab':
                          $socialMediaDisplayName = 'GitLab';
                          break;
                        case 'whatsapp':
                          $socialMediaDisplayName = 'WhatsApp';
                          break;
                        default:
                          $socialMediaDisplayName = ucfirst($socialMediaName); // Capitalize the first letter for other platforms
                      }

                      $socialMediaIconClass = isset($socialMediaIcons[$socialMediaName]) ? $socialMediaIcons[$socialMediaName] : 'fab fa-globe'; // Default icon for unknown social media

                      echo "<a href=\"$url\" target=\"_blank\" class=\"p-2 btn btn-dark opacity-75 border border-dark-subtle border-3 fw-bold w-100 rounded-pill mt-2\"><i class=\"$socialMediaIconClass fs-5\"></i> $socialMediaDisplayName</a>";
                    }
                  }
                ?>
              </div>
            </div>
            <br><br><br>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="bioData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content fw-medium rounded-4 border-0 container-fluid" style="max-width: 305px;">
          <div class="modal-header border-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p style="white-space: break-spaces; overflow: hidden; margin-top: -75px;">
              <?php
                $bioText = isset($user['bio']) ? $user['bio'] : '';

                if (!empty($bioText)) {
                  $paragraphs = explode("\n", $bioText);

                  foreach ($paragraphs as $index => $paragraph) {
                    echo "<p style=\"white-space: break-spaces; overflow: hidden;\">";
                    echo preg_replace('/\bhttps?:\/\/\S+/i', '<a href="$0" target="_blank">$0</a>', strip_tags($paragraph));
                    echo "</p>";
                  }
                } else {
                  echo "Sorry, no text...";
                }
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
    <style>
      .hide-scrollbar::-webkit-scrollbar {
        display: none;
      }

      .text-shadow {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6), 2px 2px 4px rgba(0, 0, 0, 0.8), 5px 5px 6px rgba(0, 0, 0, 0.2);
      }
    </style>
    <script>
      function sharePage() {
        if (navigator.share) {
          navigator.share({
            title: document.title,
            url: window.location.href
          }).then(() => {
            console.log('Page shared successfully.');
          }).catch((error) => {
            console.error('Error sharing page:', error);
          });
        } else {
          console.log('Web Share API not supported.');
        }
      }
    </script>
    <?php include('../bootstrapjs.php'); ?>
  </body>
</html>
