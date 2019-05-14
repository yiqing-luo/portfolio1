<header>
  <!-- TODO: add logo and navigation bar -->

  <?php $currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>

  <nav>
    <img id="logo" src="images/amber_logo_cut.png" alt="the logo of Amber Dance Troupe">
    <div class="nav-box">
    <div>
    <h1>Amber Dance Troupe</h1>
</div>
<div>
    <ul>
      <li><a href="index.php" <?php if ($currentPage == 'index.php') {
                                echo 'id="here"';
                              } ?>>Home</a></li>
      <li class="bar">|</li>
      <li><a href="members.php" <?php if ($currentPage == 'members.php' or $currentPage == 'onemember.php') {
                                  echo 'id="here"';
                                } ?>>Members</a></li>
      <li class="bar">|</li>
      <li><a href="gallery.php" <?php if ($currentPage == 'gallery.php' or $currentPage == 'onepicture.php') {
                                  echo 'id="here"';
                                } ?>>Gallery</a></li>
      <li class="bar">|</li>
      <li><a href="events.php" <?php if ($currentPage == 'events.php') {
                                  echo 'id="here"';
                                } ?>>Events</a></li>
      <li class="bar">|</li>
      <li><a href="join.php" <?php if ($currentPage == 'join.php') {
                                echo 'id="here"';
                              } ?>>Join</a></li>
    </ul>
                            </div>
                            </div>
  </nav>
</header>
