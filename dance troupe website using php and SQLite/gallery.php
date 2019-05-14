<?php
include("includes/init.php");

// upload

$messages = array();
$img_deleted=array();

// MAX_FILE_SIZE is limited to 1MB
const MAX_FILE_SIZE = 1000000;

// Source: adapted from lab 8
// if user is logged in and attempts to submit a file
if ( isset($_POST["submit_upload"]) && is_user_logged_in() ) {

  // acquire information about the uploaded files
  $upload_info = $_FILES["img_file"];
  $upload_year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING);
  if ($upload_info["error"]==4){
    array_push($messages, "Please choose a file.");
  }
  elseif($upload_info["error"]==2){
    array_push($messages, "Please choose a file with size less than 1MB.");
  }
  elseif($upload_year>2018 || $upload_year==NULL){
    array_push($messages, "Please enter a year equal or less than 2018.");
  }
  elseif ( $upload_info['error'] == UPLOAD_ERR_OK ) {
    // upload successful
    // get the name of the uploaded file without any path
    $upload_name = basename($upload_info["name"]);
    // Get the file extension
    $upload_ext = strtolower( pathinfo($upload_name, PATHINFO_EXTENSION) );
    $sql = "INSERT INTO images (file_name, file_ext, year) VALUES (:filename, :extension, :year)";
    $params = array(
      ':filename' => substr($upload_name, 0, -4),
      ':extension' => $upload_ext,
      ':year' => $upload_year,
    );
    $result = exec_sql_query($db, $sql, $params);
      // after successful upload, move to upload directory
      $file_id = $db->lastInsertId("id");
      $id_filename = 'uploads/gallery/' . $file_id . '.' . $upload_ext;
      move_uploaded_file($upload_info["tmp_name"], $id_filename );
  } else {
    // Upload failed.
    array_push($messages, "Upload failed.");
  }
}

function print_tag($tag){
  echo "<li>".$tag["tag"]."</li>";
}

function print_record($db, $records) {
  foreach($records as $record) {
    echo "<div>";
    ?>

    <!--show image-->
    <a href="onepicture.php?<?php echo (http_build_query(array('id' => $record['id']))); ?>"><img class="gallery-pics" src='<?php echo("uploads/gallery/".$record['id'].".".$record['file_ext']);?>' alt="showcase pictures"/></a>
    <!-- all images are provided by client -->
    <?php
    $tags=exec_sql_query($db, "SELECT tags.tag FROM images INNER JOIN images_tags ON image_id = images.id INNER JOIN tags ON tags.id=images_tags.tag_id WHERE images.id =\"".$record['id']."\"", array())->fetchAll();
    echo "<ul class=\"tags_list\">";
    foreach ($tags as $tag){
      print_tag($tag);
    }
    echo "</ul>";
         //show delete button
         if (is_user_logged_in()){
          echo "<a href=\"gallery.php?".http_build_query( array( 'action'=> 'delete_image', 'image_id'=>$record['id'],'extension'=>$record['file_ext']) )."\" class=\"delete_img\">&#10005 Delete</a>".PHP_EOL;
        }
    echo "</div>"; //image+tag div
  }
}


    //delete image from images table
    if (isset($_GET['action']) && $_GET['action']=='delete_image') {
      $image_id = filter_input(INPUT_GET, 'image_id', FILTER_VALIDATE_INT);
      $extension = filter_input(INPUT_GET, 'extension', FILTER_SANITIZE_STRING);
      $sql = "DELETE FROM images WHERE id = :id;";
      $params = array(
        ':id' => $image_id
      );
      $delete = exec_sql_query($db, $sql, $params);
      if ($delete) {
        //unlink file
        $file_name="uploads/gallery/" .$image_id.".".$extension;
        $unlinked= unlink($file_name);
        if($unlinked){
          array_push($img_deleted,"Image has been successfully deleted.");
        }
      }

      //delete from img_tag table
      // <!-- all images are provided by client -->
      $imgids = exec_sql_query($db, "SELECT DISTINCT image_id FROM images_tags", NULL) -> fetchALL(PDO:: FETCH_COLUMN);
      if (in_array($image_id, $imgids)){
        $sql = "DELETE FROM images_tags WHERE image_id = :id;";
        $params = array(
          ':id' => $image_id
        );
        $delete = exec_sql_query($db, $sql, $params);
      }
    }

    //filter
    if (isset($_GET["action"]) && $_GET["action"]=="filter"){
      $do_filter=TRUE;
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

<?php foreach ($img_deleted as $message){
  echo "<div class=\"message_error\">".htmlspecialchars($message)."</div>";
}?>

<div id="large-box">
<!-- dance type filters -->
<div id="gallery_filter">
<?php
  $dance_types = exec_sql_query($db, "SELECT * FROM tags", array())->fetchAll();
    echo "<p>Filter by:</p>";
    echo "<ul>";
    foreach($dance_types as $type){
      echo "<li><a href=\"gallery.php?".http_build_query( array( 'action'=> 'filter', 'tag_id'=>$type['id']))."\">".htmlspecialchars($type["tag"])."</a></li>".PHP_EOL;
    }
    echo"</ul>";
?>
</div>


<div id="gallery-content">
<h2 class="h2-gallery">2018</h2>
<div class="gallery-blocks">
<?php
if ($do_filter==FALSE){
  $sql = "SELECT * FROM images WHERE year>=2018";
  $params=array();
  $result = exec_sql_query($db, $sql, $params);
  $records=$result->fetchAll();
  print_record($db, $records);
}else{
  $filter_id = filter_input(INPUT_GET, 'tag_id', FILTER_VALIDATE_INT);
  $sql="SELECT images.id, images.file_name, images.file_ext FROM images INNER JOIN images_tags ON image_id = images.id AND year=2018 INNER JOIN tags ON tags.id=images_tags.tag_id WHERE tags.id=\"".$filter_id."\"";
  $params=array();
  $result = exec_sql_query($db, $sql, $params);
  $records=$result->fetchAll();
  print_record($db, $records);
}


if (count($records)%3 == 2){
  echo "<div class='filler'>";
  echo "</div>";
}

if (count($records)%3 == 1){
  echo "<div class='filler'>";
  echo "</div>";

  echo "<div class='filler'>";
  echo "</div>";
}

?>
</div>

<h2 class="h2-gallery">2017 or Earlier</h2>
<div class="gallery-blocks">
<?php
if ($do_filter==FALSE){
  $sql = "SELECT * FROM images WHERE year<2018";
  $params=array();
  $result = exec_sql_query($db, $sql, $params);
  $records=$result->fetchAll();
  print_record($db, $records);
}else{
  $filter_id = filter_input(INPUT_GET, 'tag_id', FILTER_VALIDATE_INT);
  $sql="SELECT images.id, images.file_name, images.file_ext FROM images INNER JOIN images_tags ON image_id = images.id AND year<2018 INNER JOIN tags ON tags.id=images_tags.tag_id WHERE tags.id=\"".$filter_id."\"";
  $params=array();
  $result = exec_sql_query($db, $sql, $params);
  $records=$result->fetchAll();
  print_record($db, $records);
}?>

</div>

</div>

</div>

<p>All images are provided by client.</p>

<!-- log in log out -->

<?php
  if (is_user_logged_in()){
    ?>
    <!-- display upload form if user is logged in -->
    <?php
    include("includes/upload.php");
  } else {
    ?>
  <!-- display login portal when the user is not signed in -->
  <?php include("includes/login.php");
  }
  ?>


<?php include("includes/footer.php"); ?>

</body>
</html>
