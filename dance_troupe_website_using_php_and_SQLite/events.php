<?php
include("includes/init.php");
function print_record($record) {
  ?>
  <div class="events"><h2 class="events"><?php echo $record['name'];?></h2>
  <p><?php echo $record['date'];?> at <?php echo $record['time'];?> in <?php echo $record['location'];?></p>
  <p><?php echo $record['description'];?></p></div>
  <?php
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

<h1 class="events">Practice Schedule</h1>

<div class="practice">

<p>Jazz Funk Workshop: At Noyes 1st floor dance studio</p>

<p>Time: Friday 9:30-11:00 pm</p>

<br>

<p>Modern : At Helen Newman dance studio</p>

<p>Time: Friday 9:30-12:00 pm</p>

<br>

<p>Classic : At WSH 601</p>

<p>Time: Saturday and Sunday 10:00 – 12: 00 pm</p>

<br>

<p>Folk : At WSH 602</p>

<p>Time: Sunday 9:00 - 12:00 pm</p>
</div>

<h1 class="events">All Events</h1>
<?php
$sql = "SELECT * FROM events";
$params=array();
  $result = exec_sql_query($db, $sql, $params);
  $records=$result->fetchAll();
  foreach($records as $record) {
    print_record($record);
  }
?>

<?php include("includes/footer.php"); ?>

</body>
</html>
