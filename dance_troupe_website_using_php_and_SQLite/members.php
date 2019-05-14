<?php
include("includes/init.php");

$messages = array();

// MAX_FILE_SIZE is limited to 1MB
const MAX_FILE_SIZE = 1000000;

// Source: adapted from lab 8
// if user is logged in and attempts to submit a file
if (isset($_POST["submit_upload"]) && is_user_logged_in()) {

  // acquire information about the uploaded files
  $upload_info = $_FILES["img_file"];
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
  $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
  $funfact = filter_input(INPUT_POST, 'funfact', FILTER_SANITIZE_STRING);
  $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);

  if ($upload_info["error"]==4){
    array_push($messages, "Please choose a file.");
  }
  elseif($upload_info["error"]==2){
    array_push($messages, "Please choose a file with size less than 1MB.");
  }
  elseif($name==NULL || $status==NULL){
    array_push($messages, "Please complete all required information.");
  }
  elseif ($upload_info['error'] == UPLOAD_ERR_OK) {
    // upload successful
    // get the name of the uploaded file without any path
    $file_name = basename($upload_info["name"]);

    // Get the file extension
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $sql = "INSERT INTO members (name, status, year, position, funfact, file_name, file_ext) VALUES (:name, :status, :year, :position, :funfact, :file_name, :file_ext)";
    $params = array(
      ':file_name' => substr($file_name, 0, -4),
      ':file_ext' => $file_ext,
      ':year' => $year,
      ':name' => $name,
      ':status' => $status,
      ':funfact' => $funfact,
      ':position' => $position,
    );
    $result = exec_sql_query($db, $sql, $params);
      // after successful upload, move to upload directory
      $file_id = $db->lastInsertId("id");
      $id_filename = 'uploads/member_shots/' . $file_id . '.' . $file_ext;
      move_uploaded_file($upload_info["tmp_name"], $id_filename);
  } else {
    // Upload failed.
    array_push($messages, "Upload failed.");
  }
}

function print_record($record)
{
  ?>
  <a href="onemember.php?<?php echo (http_build_query(array('id' => $record['id']))); ?>"><img class="members-img" src='<?php echo ("uploads/member_shots/" . $record['id'] . "." . $record['file_ext']); ?>' alt="members headshot" />
    <div><?php echo "<p class=\"member_name\">" . $record['name'] . "</p>" ?></div>
  </a>

  <!-- delete -->
  <div>
    <?php
    //show delete button
    if (is_user_logged_in()) {
      echo "<a href=\"members.php?" . http_build_query(array('action' => 'delete_member', 'image_id' => $record['id'], 'extension' => $record['file_ext'])) . "\" class=\"delete_img2\">&#10005; Delete</a>" . PHP_EOL;
    }
    ?>
  </div>
<?php
}
?>

<?php
//delete image from images table
if (isset($_GET['action']) && $_GET['action'] == 'delete_member') {
  $image_id = filter_input(INPUT_GET, 'image_id', FILTER_VALIDATE_INT);
  $extension = filter_input(INPUT_GET, 'extension', FILTER_SANITIZE_STRING);
  $sql = "DELETE FROM members WHERE id = :id;";
  $params = array(
    ':id' => $image_id
  );
  $delete = exec_sql_query($db, $sql, $params);
  if ($delete) {

    //unlink file
    $file_name = "uploads/member_shots/" . $image_id . "." . $extension;
    $unlinked = unlink($file_name);
    if ($unlinked) {
      echo "<div class=\"error_msg\"><p> Image has been successfully deleted. </p></div>";
    }
  }
}

//filter
if (isset($_GET["action"]) && $_GET["action"] == "filter") {
  $do_filter = TRUE;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/all.css" type="text/css" rel="stylesheet" />
  <title>Home</title>
</head>

<body>

  <?php include("includes/header.php"); ?>

  <!-- member type jump -->
  <div id="member_filter">
    <?php
    $member_types = exec_sql_query($db, "SELECT DISTINCT status FROM members", array())->fetchAll();
    echo "<ul>";
    foreach ($member_types as $type) {
      echo "<li><a href=\"#" . $type['status'] . "\">" . $type['status'] . "</a></li>";
    }
    echo "</ul>";
    ?>
  </div>

  <h1 class="members" id="Eboard">E-Board</h1>
  <div class="members-blocks">
    <?php
    $sql = "SELECT * FROM members WHERE status LIKE 'Eboard'";
    $params = array();
    $result = exec_sql_query($db, $sql, $params);
    $records = $result->fetchAll();
    foreach ($records as $record) {
      echo "<div class=\"container\">";
      print_record($record);
      echo "</div>";
    }

    if (count($records) % 3 == 2) {
      echo "<div class='filler'>";
      echo "</div>";
    }

    if (count($records) % 3 == 1) {
      echo "<div class='filler'>";
      echo "</div>";

      echo "<div class='filler'>";
      echo "</div>";
    }
    ?>


  </div>


  <h1 class="members" id="Advisor">Advisors</h1>
  <div class="members-blocks">
    <?php
    $sql = "SELECT * FROM members WHERE status LIKE 'Advisor'";
    $params = array();
    $result = exec_sql_query($db, $sql, $params);
    $records = $result->fetchAll();
    foreach ($records as $record) {
      echo "<div class=\"container\">";
      print_record($record);
      echo "</div>";
    }

    if (count($records) % 3 == 2) {
      echo "<div class='filler'>";
      echo "</div>";
    }

    if (count($records) % 3 == 1) {
      echo "<div class='filler'>";
      echo "</div>";

      echo "<div class='filler'>";
      echo "</div>";
    }
    ?>
  </div>

  <h1 class="members" id="Gbody">G-Body</h1>
  <div class="members-blocks">
    <?php
    $sql = "SELECT * FROM members WHERE status LIKE 'Gbody'";
    $params = array();
    $result = exec_sql_query($db, $sql, $params);
    $records = $result->fetchAll();
    foreach ($records as $record) {
      echo "<div class=\"container\">";
      print_record($record);
      echo "</div>";
    }
    if (count($records) % 3 == 2) {
      echo "<div class='filler'>";
      echo "</div>";
    }

    if (count($records) % 3 == 1) {
      echo "<div class='filler'>";
      echo "</div>";

      echo "<div class='filler'>";
      echo "</div>";
    }
    ?>
  </div>

  <h1 class="members" id="Alumni">Alumni</h1>
  <div class="members-blocks">
    <?php
    $sql = "SELECT * FROM members WHERE status LIKE 'Alumni'";
    $params = array();
    $result = exec_sql_query($db, $sql, $params);
    $records = $result->fetchAll();
    foreach ($records as $record) {
      echo "<div class=\"container\">";
      print_record($record);
      echo "</div>";
    }
    if (count($records) % 3 == 2) {
      echo "<div class='filler'>";
      echo "</div>";
    }

    if (count($records) % 3 == 1) {
      echo "<div class='filler'>";
      echo "</div>";

      echo "<div class='filler'>";
      echo "</div>";
    }
    ?>
  </div>

  <p>All images are provided by client.</p>

  <?php
  if (is_user_logged_in()) {
    ?>
    <!-- display upload form if user is logged in -->
    <?php
    include("includes/uploadmem.php");
  } else {
    ?>
    <!-- display login portal when the user is not signed in -->
    <?php include("includes/login.php");
  }
  ?>


  <?php include("includes/footer.php"); ?>

</body>

</html>
