<?php
 // This page is partially based on Cornell CS2300 SP2019 lab8
//url: https://github.coecis.cornell.edu/info2300-sp2019/qb25-lab-08/blob/master/includes/login.php
?>

<ul>
    <?php
  //print each message
    foreach ($session_messages as $message) {
      echo "<li><strong>" . htmlspecialchars($message) . "</strong></li>\n";
    }
    ?>
</ul>
       <!-- TODO: include login/logout -->

<!-- login form -->
<form id="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <h2>Sign In</h2>
    <div>
    <label for="username">Username:</label>
    <input id="username" type="text" name="username" />
    <label for="password">Password:</label>
    <input id="password" type="password" name="password" />
    <button name="login" type="submit">Sign In</button>
  </div>
</form>
