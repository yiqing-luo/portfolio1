<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="styles/all.css" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="scripts/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="scripts/slideshow.js"></script>
  <title>Home</title>
</head>

<body>

<?php include("includes/header.php"); ?>

  <!-- TODO: This should be your main page for your site. -->

  <div class="slideshow">
  <div id="last_button" class="slide_button">
        <a>&lt;</a>
    </div>
    <div class="img_holder">
      <img id="slideshow_img" src="images/cover_1.jpg" alt=""/>
    </div>
    <div id="next_button" class="slide_button">
        <a>&gt;</a>
    </div>
  </div>

  <div id="home-info">

  <div id="home-info-1">
    <h2>About Amber</h2>
    <p>
    Amber was founded in 2003 to present the Cornell community both traditional and contermporary Chinese dance. Right now we have 35 active members and are continuning to grow. Every year, not only do we bring many wonderful performances to Cornell events, we also host our annual showcase -- Rhythms of China.
    </p>
    <cite>
      <a href="http://www.amberdancetroupe.com/">
      Source: Amber Dance Troupe Original Website
    </a>
    </cite>
  </div>

  <div id="home-info-2">
    <h2>Our purpose</h2>
    <p>
    Amber's purpose is to spread the rich heritage of Chinese culture and the beauty of Chinese dance to the public. Also,we hope members can both perfecting their dance skills and grow together. Anyone interested can join us and learn some interesting Chinese dance through regular practice and get opportunity to perform.
    </p>
    <cite>
      <a href="http://www.amberdancetroupe.com/">
      Source: Amber Dance Troupe Original Website
    </a>
    </cite>
  </div>

  <div>
    <h2>Practice Schedule</h2>
    <p>Jazz Funk Workshop:</p>
    <p>Location: Noyes 1st Floor Dance Studio</p>
    <p>Time: Friday 9:30-11:00 pm</p>
    <p>Classic:</p>
    <p>Location: Willard Straight Hall 601</p>
    <p>Time: Saturday & Sunday 10:00 – 12: 00 pm</p>
    <cite>Source: information provided from client </cite>
  </div>
  </div>

  <?php include("includes/footer.php");?>

</body>


</html>
