<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}

// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.
$db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');

// Source: the login and logout code below is adapted from class example init.php from Lecture 16. All code was typed out by hand. Necessary changes were made to meet specific needs of Project 4.

$session_messages = array();

function log_in($username, $password){
  global $db;
  global $current_user;
  global $session_messages;

// if a user enters username and password
  if(isset($username)&&isset($password)){
    // make sure the username exists in database
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(':username' => $username);
    $records = exec_sql_query($db, $sql, $params) -> fetchAll();
    if($records){
      $account = $records[0];

      if(password_verify($password, $account['password'])){
        // generate session for the user
        $session = session_create_id();

        $sql = "INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);";
        $params = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result){
          // store session in database and send cookie back to user, expires in 30 minutes
          setcookie("session", $session, time()+1800);

          $current_user = find_session($session);
          return $current_user;
        } else {
          array_push($session_messages, "Log in unsuccessful.");
        }
      } else {
        array_push($session_messages, "Please enter valid username and password");
      }
    } else {
      array_push($session_messages, "Please enter valid username and passwords.");
    }
  }
  $current_user = NULL;
  return NULL;
}

function find_session($session){
  global $db;

  if(isset($session)){
    global $db;

    // if a session has been created, find the corresponding session
    if(isset($session)){
      $sql = "SELECT user_id FROM sessions WHERE session = :session;";
      $params = array(
        ':session' => $session
      );
      $records = exec_sql_query($db, $sql, $params) -> fetchAll();
      if($records){
        return $records[0];
      }
    }
    return NULL;
  }
}

function session_login(){
  global $db;
  global $current_user;

  if(isset($_COOKIE["session"])){
    $session = $_COOKIE["session"];

    $current_user = find_session($session);

    // renews cookie for 30 more minutes if user appears active on the website
    if(isset($current_user)){
      setcookie("session", $session, time()+1800);
    }

    return $current_user;
  }

  // when no session cookie found
  $current_user = NULL;
  return NULL;
}

function is_user_logged_in(){
  global $current_user;

  // user is logged in if there is a current user
  return ($current_user != NULL);
}

function log_out(){
  global $current_user;

  // adjust time to the past to force cookie to expire
  setcookie("session", "", time()-10000);
  $current_user = NULL;
}

// user could be logged in through entering username and password
if (isset($_POST['login'])&&isset($_POST['username'])&& isset($_POST['password'])){
  $username = trim( $_POST['username'] );
  $password = trim( $_POST['password'] );
  log_in($username, $password);
} else {
  // user might be logged iin through a cookie
  session_login();
}

// log out the user
if ( isset($current_user) && ( isset($_GET['logout']) || isset($_POST['logout']) ) ) {
  log_out();
}

?>
