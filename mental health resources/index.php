<?php
// DO NOT REMOVE!
include("includes/init.php");
// DO NOT REMOVE!

if (isset($_POST['submit'])) {
  $form_valid=TRUE;

  $name=trim($_POST['name']);
  if($name==''){
    $form_valid=FALSE;
    $show_name_error=TRUE;
  }

  $email= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  if($email != TRUE){
    $form_valid=FALSE;
    $show_email_error=TRUE;
  }

  $message=trim($_POST['comment']);
  if($message==''){
    $form_valid=FALSE;
    $show_message_error=TRUE;
  }



  $status=$_POST['status'];

  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Home</title>
</head>

<body>
  <div class="background">
    <?php include('includes/header.php'); ?>
  </div>
  <!--Image Source: https://picryl.com/media/south-on-the-quadrangle-cornell-university-ithaca-ny-->
  <p class="source">Image Source:https://picryl.com/media/south-on-the-quadrangle-cornell-university-ithaca-ny</p>

  <!--confirmation page-->
  <?php if(isset($form_valid) && $form_valid==TRUE) { ?>

    <p>Your message is sent successfully. Thank you!</p>
    <p>Name: <?php echo $name; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Message: <?php echo $message; ?></p>
    <p>I am a: <?php echo $status; ?></p>

  <?php } else{ ?>


  <div id="all-wrap">

    <article>

      <section>
        <h3>Purpose</h3>
        <hr/>
        <p>This website aims to help Cornell students, faculty and parents navigate 3 of the most popular on-campus mental health support resources. On each page you can find brief introduction of the service, and a suggestion on when to use it. </p>
        <p>You may be a student who is not feeling well recently, or just individuals concerned about someone you know. An important message here is that, seeking for mental health support does not mean you or the others are "sick". It is merely a step to take better care of oneself during the academic life at Cornell, which we all know could be tough sometimes. Imagine this process as daily work-out or doing a message, except mentally. </p>
        <!--Source: I wrote this introduction myself-->
      </section>

      <section>
        <h3 class="section_title">Contact Us</h3>
        <hr/>
        <form id="message_form" method="post" action="index.php" novalidate>
          <fieldset>
            <legend>Qeustions or Comments</legend>

            <p>
              <label for="name"><span class="required">*</span>Name: </label>
              <input id="name_id" type="text" name="name" value="<?php if(isset($name)){ echo htmlspecialchars($name); } ?>"/>
            </p>
            <p class="form_error <?php if(!isset($show_name_error)){echo 'hidden';} ?>">Please type your name here</p>

            <p>
              <label for="email"><span class="required">*</span>Email: </label>
              <input id="email_id" type="email" name="email" value="<?php if(isset($email)){ echo htmlspecialchars($email); } ?>"/>
            </p>
            <p class="form_error <?php if(!isset($show_email_error)){echo 'hidden';} ?>">Please input a valid email</p>

            <p>
              <label for="comment"><span class="required">*</span>Message: </label>
              <textarea cols="40" rows="10" id="comment_id" name="comment" ><?php if(isset($message)){ echo htmlspecialchars($message); } ?></textarea>
            </p>
            <p class="form_error <?php if(!isset($show_message_error)){echo 'hidden';} ?>">Please put down the message in the textbox</p>

            <p id="status">I am a:
              <input type="radio" name="status" value="student" <?php if (isset($status)&& $status=="student"){echo "checked";} ?>/><label>Student</label>
              <input type="radio" name="status" value="faculty" <?php if (isset($status)&& $status=="faculty"){echo "checked";} ?>/><label>Faculty</label>
              <input type="radio" name="status" value="parent" <?php if (isset($status)&& $status=="parent"){echo "checked";} ?>/><label>Parent</label>
               <span class="optional">(Optional)</span>
            </p>

            <input type="submit" value="Submit" name="submit" id="submit_button"/>
          </fieldset>
        </form>

      </section>


    </article>
  </div>

  <?php } ?>

  <p id="footer">Cornell Health, 110 Ho Plaza, Ithaca, NY 14853-3101</p>

</body>
</html>
