<?php
include("includes/init.php");


if (isset($_POST['submit'])) {
  $form_valid=TRUE;

  $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  if($name!=TRUE){
    $form_valid=FALSE;
    $show_name_error=TRUE;
  }

  $email= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  if($email != TRUE){
    $form_valid=FALSE;
    $show_email_error=TRUE;
  }

  $phone= filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);


  $message=filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
  if($message!=TRUE){
    $form_valid=FALSE;
    $show_message_error=TRUE;
  }


  $dance=$_POST['dance'];

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

<!--confirmation page-->
<?php if(isset($form_valid) && $form_valid==TRUE) { ?>

<p>Your message is sent successfully. Thank you!</p>
<p>Name: <?php echo htmlspecialchars($name); ?></p>
<p>Email: <?php echo htmlspecialchars($email); ?></p>
<p>Phone: <?php echo htmlspecialchars($phone); ?></p>
<p>Type of Dance Interested: <?php echo $dance; ?></p>
<p>Message: <?php echo htmlspecialchars($message); ?></p>

<?php } else{ ?>

<h1 class="members">Recruitment</h1>
<p class="join">We are looking for individuals who have passion, time, and positive attitude. Amber welcomes everyone, any skill level, any ethnicity. A minimum of 2 to 5 hours of practice time per week is expected. Mastering these dances is not easy, but we are eager to teach and help you grow. Welcome to Amber Dance Troupe.</p>

<p class="join">
Amber has no formal audition process. At the beginning of each semester we hold information sessions and every year we have a booth at clubfest, but we never hold auditions. If you would like to join or "try-out" Amber for yourself, simply attend one of our rehearsals or one of our workshops and see if you like it.
</p>
<cite class="join">
      <a href="http://www.amberdancetroupe.com/">
      Source: Amber Dance Troupe Original Website
    </a>
    </cite>

<h1 class="members">Contact Us</h1>
<section>
  <form id="contact_form" method="post" action="join.php" novalidate>
    <div>
      <div>
        <label><span class="required">*</span>Name: </label>
        <input id="name_id" type="text" name="name" value="<?php if(isset($name)){ echo htmlspecialchars($name); } ?>"/>
        <p class="form_error <?php if(!isset($show_name_error)){echo 'hidden';} ?>">Please type your name here</p></div>

        <div>
        <label><span class="required">*</span>Email: </label>
        <input id="email_id" type="email" name="email" value="<?php if(isset($email)){ echo htmlspecialchars($email); } ?>"/>
        <p class="form_error <?php if(!isset($show_email_error)){echo 'hidden';} ?>">Please input a valid email</p></div>

        <div>
        <label>Phone: </label>
        <input id="phone_id" type="text" name="phone" value="<?php if(isset($phone)){ echo htmlspecialchars($phone); } ?>"/>

        <p id="dance">Type of Dance Interested:
          <input type="checkbox" name="dance" value="classic" <?php if (isset($dance)&& $dance=="classic"){echo "checked";} ?>/><label>Chinese Classic</label>
          <input type="checkbox" name="dance" value="folk" <?php if (isset($dance)&& $dance=="folk"){echo "checked";} ?>/><label>Chinese Folk</label>
          <input type="checkbox" name="dance" value="jazz" <?php if (isset($dance)&& $dance=="jazz"){echo "checked";} ?>/><label>Jazz</label>
        </p>

        <div><label><span class="required">*</span>Message: </label>
        <textarea cols="40" rows="10" id="message_id" name="message" ><?php if(isset($message)){ echo htmlspecialchars($message); } ?></textarea></div>
        <p class="message_error <?php if(!isset($show_message_error)){echo 'hidden';} ?>">Please write the message in the textbox</p>

        <input type="submit" value="Submit" name="submit" id="submit_button"/>
      </div>
    </form>
  </section>
<?php };?>


<?php include("includes/footer.php"); ?>

</body>
</html>
