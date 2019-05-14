<?php
include("includes/init.php");
if (isset($_GET['id'])) {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $sql = "SELECT * FROM images WHERE id = :id;";
  $params = array(
    ':id' => $id
  );
  $result = exec_sql_query($db, $sql, $params);
  if ($result) {
    $images = $result->fetchAll();
    if (count($images) > 0) {
      $image = $images[0];
      $image_id = $image['id'];
    }
  }
}

function print_tag($tag)
{
  ?>
  <li class="tag"><?php echo ($tag['tag']); ?></li>
<?php
}

function print_filter($tag)
{
  ?>
  <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag']; ?></option>
<?php
}

if (isset($_POST['submit']) && isset($_POST['tags'])) {
  $sql = "INSERT INTO images_tags (image_id, tag_id) VALUES (:image_id, :tag_id)";
  $params = array(
    ':image_id' => $image_id,
    ':tag_id' => $_POST['tags'],
  );
  $result = exec_sql_query($db, $sql, $params);
}

if (isset($_POST['submit']) && isset($_POST['tag_name'])) {
  $tag = filter_input(INPUT_POST, 'tag_name', FILTER_SANITIZE_STRING);
  $sql = "INSERT INTO tags (tag) VALUES (:tag)";
  $params = array(
    ':tag' => $tag,
  );
  $result = exec_sql_query($db, $sql, $params);
  $tag_id = $db->lastInsertId("id");
  $sql = "INSERT INTO images_tags (image_id, tag_id) VALUES (:image_id, :tag_id)";
  $params = array(
    ':image_id' => $image_id,
    ':tag_id' => $tag_id,
  );
  $result = exec_sql_query($db, $sql, $params);
}

if (isset($_POST['submit']) && isset($_POST['tag_delete'])) {
  $sql = "DELETE FROM images_tags WHERE image_id=:image_id AND tag_id=:tag_id";
  $params = array(
    ':image_id' => $image_id,
    ':tag_id' => $_POST['tag_delete'],
  );
  $result = exec_sql_query($db, $sql, $params);
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
  <img class="one-picture" alt="showcase picture" src="uploads/gallery/<?php echo ($image['id']); ?>.<?php echo ($image['file_ext']); ?>" />
  <p class="centered">Image provided by client.</p>
  <h2>Tags:</h2>
  <?php
  $query = "SELECT tags.id,tags.tag FROM tags INNER JOIN images_tags ON tags.id=images_tags.tag_id INNER JOIN images ON images_tags.image_id=images.id WHERE images.id=$image_id";
  $array = array();
  $exec = exec_sql_query($db, $query, $array);
  $tags = $exec->fetchAll();
  ?>
  <ul class="tags_list2">
    <?php foreach ($tags as $tag) {
      print_tag($tag);
    }
    ?>
  </ul>
  <?php if (is_user_logged_in()) {
    ?>
    <!-- Display forms to add new tags, add existing tags, or delete tags from the image if logged in -->
    <div class="upload-tag-form">
      <form id="add_tag" method="post" action="onepicture.php?id=<?php echo $image_id; ?>" novalidate>
        <legend>Add an existing tag to this image:</legend>
        <?php
        $query = "SELECT * FROM tags";
        $array = array();
        $exec = exec_sql_query($db, $query, $array);
        $tags2 = $exec->fetchAll();
        ?>
        <select name="tags">
          <option value="" selected disabled>Add Tag</option>
          <?php
          foreach ($tags2 as $tag) {
            if (!in_array($tag, $tags)) {
              print_filter($tag);
            }
          }
          ?>
        </select>
        <input type="submit" value="submit" name="submit" />
      </form>
      <h3>OR</h3>
      <form id="add_new_tag" method="post" action="onepicture.php?id=<?php echo $image_id; ?>" novalidate>
        <legend>Add a new tag to this image:</legend>
        <input id="tag_name" type="text" name="tag_name" />
        <input type="submit" value="submit" name="submit" />
      </form>

      <form id="delete_tag" method="post" action="onepicture.php?id=<?php echo $image_id; ?>" novalidate>
        <legend>Delete a tag from this image:</legend>
        <?php
        $query = "SELECT tags.id,tags.tag FROM tags INNER JOIN images_tags ON tags.id=images_tags.tag_id INNER JOIN images ON images_tags.image_id=images.id WHERE images.id=$image_id";
        $array = array();
        $exec = exec_sql_query($db, $query, $array);
        $tags = $exec->fetchAll();
        ?>
        <select name="tag_delete">
          <option value="" selected disabled>Delete Tag</option>
          <?php
          foreach ($tags as $tag) {
            print_filter($tag);
          }
          ?>
        </select>
        <input type="submit" value="Delete" name="submit" />
      </form>
    </div>
  <?php
}
?>

  <div class="back"><a href="gallery.php">Back</a></div>


</body>

</html>
