<form class="upload-form" action="members.php" method="post" enctype="multipart/form-data">
<?php foreach ($messages as $message){
        echo "<div class=\"message_error\">".htmlspecialchars($message)."</div>";
        }
        ?>
  <h2>Add a Member</h2>
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
  <div>
    <div>
      <label for="img_file">*Upload Headshot (1MB MAX, squared pictures only):</label>
      <input id="img_file" type="file" name="img_file" />
    </div>
    <div>
      <label>*Name:</label>
      <input type="text" name="name" /> <br/>
      <label>*Status (Eboard/Gbody/Advisor/Alumni):</label>
      <select name="status">
      <option value="Eboard" selected>Eboard</option>
      <option value="Gbody" selected>Gbody</option>
      <option value="Advisor" selected>Advisor</option>
      <option value="Alumni" selected>Alumni</option>
      </select><br/>
      <label>Year:</label>
      <input type="text" name="year" /> <br/>
      <label>Position:</label>
      <input type="text" name="position" /> <br/>
      <label>Fun Fact:</label>
      <input type="text" name="funfact" /> <br/>
    </div>
    <div>
      <button name="submit_upload" type="submit">Upload File</button>
    </div>
  </div>
</form>

<!-- display logout option if user login detected -->

<p id="logged-in">You are logged in.</p>

<?php
$logout_url = htmlspecialchars($_SERVER['PHP_SELF']) . '?' . http_build_query(array('logout' => ''));
echo '<a id="sign-out" href="' . $logout_url . '">Sign Out</a>';
?>
