<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
  phpmotorsConnect();
?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="UTF-8">
    <title>Home | PHP Motors</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- screen is used for computer screens, tablets, smart-phones etc. -->
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    <!--<link href="/phpmotors/css/normalize.css" type="text/css" rel="stylesheet" media="screen"> -->
  
  </head>

  <body>
    <div id="wrapper">
      <header id="page_header">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/header.php" ?>
      </header>
      <nav>
        <?php //include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/nav.php"
        echo $navList; ?>
      </nav>
      <main>
        <h1>Welcome to PHP Motors!</h1>
        <div id="display_div">
          <div id="Delorean_description">
            <h2 id="Delorean_header">DMC Delorean</h2>
            <p>3 Cup holders <br>
              Superman doors<br>
              Fuzzy dice!</p>
          </div>
           <img src="/phpmotors/images/vehicles/delorean.jpg" id="Delorean_img" alt="DMC Delorean">
          <a href="/" title="Own Today">
             <img src="/phpmotors/images/site/own_today.png" id="own_today" alt="rectangle stating 'own today' ">
          </a>
        </div>
        <div id="Delorean_details"> 
          <div id="Delorean_reviews">
            <h2 id="reviews">DMC Delorean Reviews</h2>
            <ul>
              <li>"So fast it's almost like traveling in time." (4/5)</li>
              <li>"Coolest ride on the road." (4/5)</li>
              <li>"I'm feeling pretty Marty McFly!" (5/5)</li>
              <li>"The most futuristic ride of our day." (4.5/5)</li>
              <li>"80's livin and I love it." (5/5)</li>
            </ul>
          </div>
        
          <h2 id="Delorean_upgrades">Delorean Upgrades</h2>
          <div id="upgrades">  
            <figure>
              <img src="/phpmotors/images/upgrades/flux-cap.png"
              alt="Flux Capacitor">
              <figcaption>Flux Capacitor</figcaption>
            </figure> 
            <figure>
              <img src="/phpmotors/images/upgrades/flame.jpg"
              alt="flames">
              <figcaption>Flame Decals</figcaption>
            </figure> 
            <figure>
              <img src="/phpmotors/images/upgrades/bumper_sticker.jpg"
              alt="bumper stickers">
              <figcaption>Bumper Stickers</figcaption>
            </figure> 
            <figure>
              <img src="/phpmotors/images/upgrades/hub-cap.jpg"
              alt="Hub caps">
              <figcaption>Hub Caps</figcaption>
            </figure> 
          </div>
</div>
      </main>
      <hr>
      <footer id="page_footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>