<?php
// DO NOT REMOVE!
include("includes/init.php");
// DO NOT REMOVE!

$db = open_sqlite_db("secure/data.sqlite");


//print page
function print_table($table){
?>

  <tr>
    <td> <?php echo htmlspecialchars($table["department"]);?></td>
    <td><?php echo htmlspecialchars($table["title"]);?></td>
    <td><?php echo htmlspecialchars($table["distribution"]);?></td>
    <td><?php echo htmlspecialchars($table["comment"]);?></td>
  </tr>
  <?php
}

function print_all($list_of_tables){?>
    <h3>Cultural Analysis (CA)</h3>
    <table>
    <?php include("includes/th.php");
    foreach ($list_of_tables[0] as $x){
      print_table($x);} ;?></table>
    <h3>Historical Analysis (HA)</h3>
    <table><?php include("includes/th.php");
    foreach ($list_of_tables[1] as $x){
      print_table($x);} ;?></table>
    <h3>Knowledge, Cognition, & Moral Reasoning (KCM)</h3>
    <table><?php include("includes/th.php");
    foreach ($list_of_tables[2] as $x){
      print_table($x);} ;?></table>
    <h3>Literature & the Arts (LA)</h3>
    <table><?php include("includes/th.php");
    foreach ($list_of_tables[3] as $x){
      print_table($x);} ;?></table>
    <h3>Social & Behavioral Analysis (SBA)</h3>
    <table><?php include("includes/th.php");
    foreach ($list_of_tables[4] as $x){
      print_table($x);} ;?></table>

<?php }

//search
const SEARCH_FIELDS=[
  "department" => "Course Department",
  "title" => "Course Title",
  "distribution" => "Course Distribution",
  "comment" => "Course Comments"
];

$messages=[];

if (isset ($_GET["search"]) && isset($_GET["field"])){

  $do_search=TRUE;
  $display_all=FALSE;
  $field = filter_input(INPUT_GET, 'field', FILTER_SANITIZE_STRING);

  if (in_array($field, array_keys(SEARCH_FIELDS))){
    $search_field=$field;
  } else {
    array_push($messages, "Search field is invalid.");
    $do_search=FALSE;
  }

  //get search input
  $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);
  $search = trim($search);
} else {

  $search=NULL;
  $field=NULL;
  $do_search=FALSE;
};

if (isset($_GET["back"])){

  $search=NULL;
  $field=NULL;
  $do_search=FALSE;
  $display_all=TRUE;

}

//Insert
$courses = exec_sql_query($db, "SELECT DISTINCT title FROM courses", NULL) -> fetchALL(PDO:: FETCH_COLUMN);

if (isset($_POST["submit_review"])){
  $valid_review = TRUE;
  $id= filter_input(INPUT_POST, "course_number", FILTER_SANITIZE_NUMBER_INT);
  $department = filter_input(INPUT_POST, "department",FILTER_SANITIZE_STRING);
  $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
  $distribution = filter_input(INPUT_POST, "distribution", FILTER_SANITIZE_STRING);
  $comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


    if ($id == NULL || $department==NULL || $title==NULL ||$distribution==NULL){
      $valid_review=FALSE;
      array_push($messages, "Please fill out everything. Only comments can be left blank.");
    } else if (in_array($id, $courses)||in_array($title, $courses)){
      $valid_review=FALSE;
      array_push($messages, "Course already exists! Please submit another course review.");
    } else{
      $valid_review=TRUE;
    };

}


if ($valid_review){
  $params = array(
    ':id' => $id,
    ':title' => $title,
    ':department' => $department,
    ':distribution' => $distribution,
    ':comment' => $comment
  );




  $sql = "INSERT INTO courses(id, department, title, distribution, comment) VALUES (:id, :department, :title, :distribution, :comment)";


  $query = $db->prepare($sql);


  if ($query and $query->execute($params)) {
      $result = $query; }



  if($result){
    array_push($messages, "Thank you for your review!");
  } else {
    array_push($messages, "Failed to add review.");
  }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Home</title>

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
</head>

<body>
<?php
  //message is for submit review feedback
  foreach($messages as $message){
    echo "<div id='messages'><p>".htmlspecialchars($message)."</p></div>";}?>

  <?php include("includes/header.php"); ?>

  <div id="all-wrap">


  <form id="searchForm" action="index.php" method="get">
    <input type="text" name="search" placeholder=" What are you looking for?"/>
    <!--drop down selection-->
    <select name="field" >
    <!--default selected-->
      <option value="" selected disabled >Search By</option>
    <!--foreach xxx key=> label-->
      <?php foreach (SEARCH_FIELDS as $field_name => $label){
        ?>
        <option value="<?php echo $field_name;?>"><?php echo $label;?></option>
        <?php
      }
      ?>
    </select>
    <button type="submit">Search</button>
    <button name="back" id="back">Back</button>
  </form>

  <!--query search result-->
  <?php if ($do_search) {?>
    <h2>Search Results</h2>
    <?php

    $display_all=FALSE;
    $sql= "SELECT * FROM courses WHERE $search_field LIKE '%' || :search || '%' ";
    $params = array(
      ":search" => $search
    );
  } else {

    $display_all=TRUE;
    $sql=[];
    $params=[] ;?>
    <h2>All Couses</h2>
    <?php array_push($sql, "SELECT * FROM courses WHERE distribution= 'CA' ");?>
    <?php array_push($sql, "SELECT * FROM courses WHERE distribution= 'HA' ");?>
    <?php array_push($sql, "SELECT * FROM courses WHERE distribution= 'KCM' ");?>
    <?php array_push($sql, "SELECT * FROM courses WHERE distribution= 'LA' ");?>
    <?php array_push($sql, "SELECT * FROM courses WHERE distribution= 'SBA' ");?>
  <?php }


  //display
  $records=[];
  if ($display_all){
    foreach ($sql as $section){
    $query = $db -> prepare($section);
    if ($query and $query -> execute($params)) {
      array_push($records, $query -> fetchAll());
      };
    };
  }else {
    $query = $db -> prepare($sql);
    if ($query and $query -> execute($params)) {
      $records = $query -> fetchAll();
    }
  }



    if (count($records)>0) {
    ;?>
    <table>
        <?php if ($display_all){
          print_all($records);

        } else {
          include("includes/th.php");

          foreach ($records as $record) {
            print_table($record);}
        }
      ;?>
      </table>
    <?php } else {
      echo "<p>No matching course was found.</p>";
      }
    ?>

    <h2>Add a Course Review!</h2>
    <form id="addReview" action="index.php" method="post" novalidate>
      <p>Create a New Course</p>
        <ul>
          <li class="review_short">
            <label>Course Number:</label>
            <input type="number" name="course_number"/>
          </li>
          <li class="review_short">
            <label >Course Department:</label>
           <input type="text" name="department"/>
          </li>
          <li id="review_title">
            <label >Course Title:</label>
           <input type="text" name="title"/>
          </li>
          <li>
            <label>Distribution:</label>
            <div class="choices">
              <input type="radio" name="distribution" value="CA"/><label>Cultural Analysis (CA)</label>
              <input type="radio" name="distribution" value="HA" /><label>Historical Analysis (HA)</label>
              <input type="radio" name="distribution" value="KCM" /><label>Knowledge, Cognition, & Moral Reasoning (KCM)</label>
              <input type="radio" name="distribution" value="LA" /><label>Literature & the Arts (LA)</label>
              <input type="radio" name="distribution" value="SBA" /><label>Social & Behavioral Analysis (SBA)</label>
            </div>
         </li>
          <li>
          <label for="comment">Comment:</label>
            <textarea cols="40" rows="10" id="content" name="comment" required placeholder="Input your content here..."></textarea>
          </li>
          <li><button name="submit_review" type="submit">Add Review</button></li>
        </ul>
      </form>




  </div>


</body>
</html>
