<form class="upload-form" action="gallery.php" method="post" enctype="multipart/form-data">
<?php foreach ($messages as $message){
        echo "<div class=\"message_error\">".htmlspecialchars($message)."</div>";
        }
        ?>
<h2>Upload Images</h2>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"/>
<div>
        <label for="img_file"><span class="required">*</span>Upload File (1MB MAX):</label>
        <input id="img_file" type="file" name="img_file"/>
</div>
<div>
        <label><span class="required">*</span>Year:</label>
        <input type="text" name="year"/>
</div>
<div>
        <button name="submit_upload" type="submit">Upload File</button>
</div>
    </div>
  </form>

<!-- display logout option if user login detected -->

<p id="logged-in">You are logged in.</p>

<?php
    $logout_url = htmlspecialchars( $_SERVER['PHP_SELF'] ) . '?' . http_build_query( array( 'logout' => '' ) );
    echo '<a id="sign-out" href="' . $logout_url . '">Sign Out</a>';
?>
