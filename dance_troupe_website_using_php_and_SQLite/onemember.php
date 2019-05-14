<?php
include("includes/init.php");
if (isset($_GET['id'])) {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $sql = "SELECT * FROM members WHERE id = :id;";
  $params = array(
    ':id' => $id
  );
  $result = exec_sql_query($db, $sql, $params);
  if ($result) {
    $members = $result->fetchAll();
    if (count($members) > 0) {
      $member = $members[0];
      $member_id = $member['id'];
    }
  }
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
  <h1 class="members"><?php echo $member['name']; ?></h1>
  <img class="one-member" src="uploads/member_shots/<?php echo ($member['id']); ?>.<?php echo ($member['file_ext']); ?>" />
  <p class="centered">Image provided by client.</p>
  <h2 class="one-member"><?php echo $member['position']; ?></h2>
  <?php
  if ($member['year'] == 0) {
    ?>
    <p class="one-member">Graduate Student</p>
  <?php } else { ?>
    <p class="one-member">Class of <?php echo $member['year']; ?></p>
  <?php } ?>

  <?php
  if ($member['funfact']) {
    ?>
    <h3 class="one-member">Fun Fact: </h3>
    <p class="one-member"><?php echo $member['funfact']; ?></p>
  <?php } ?>
  <div class="back"><a href="members.php">Back</a></div>
</body>

</html>
