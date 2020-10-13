<!DOCTYPE html>
<html lang="en">
     <head>
     <title>Search</title>
     <meta charset="utf-8">
     <link rel="icon" href="images/favicon.ico">
     <link rel="shortcut icon" href="images/favicon.ico" />
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/jquery.countdown.css">
     <script src="js/jquery.js"></script>
     <script src="js/jquery-migrate-1.1.1.js"></script>
     <script src="js/superfish.js"></script>
     <script src="search/search.js"></script>
          <script src="js/script.js"></script>

  
     <script src="js/jquery.equalheights.js"></script>
     <script src="js/jquery.easing.1.3.js"></script>
     <script src="js/jquery.countdown.js"></script>
     <script>

   
     </script>
     <!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
         </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <link rel="stylesheet" media="screen" href="css/ie.css">

    <![endif]-->
     </head>
     <body  class="">
<!--==============================header=================================-->
 <header> 
  <div class="container_12">
   <div class="grid_12"> 
    <h1><a href="index.html"><img src="images/logo.png" alt="Boo House"></a> </h1>
    <div id="countdown"></div>
    <div class="clear"></div>
    <div class="menu_block">

     <nav  class="" >
      <ul class="sf-menu">
         <li><a href="index.html">Home</a></li>
         <li><a href="index-1.html">History</a></li>
         <li><a href="index-2.html">Recipes</a></li>
         <li><a href="index-3.html">Party Planning</a></li>
         <li><a href="index-4.html">Decorations</a></li>
         <li class=""><a href="index-5.html">Contacts</a></li>
       </ul>
    </nav>
     <form id="search" action="search.php" method="GET">
        <input type="text" name="s">                           
            <a onClick="document.getElementById('search').submit()"></a>
        <div class="clear"></div>
     </form>
 <div class="clear"></div>
</div>
           
<div class="clear"></div>
          </div>
      </div>
</header>

<!--==============================Content=================================-->

<div class="content"><div class="ic">More Website Templates @ TemplateMonster.com - September 07, 2013!</div>
  <div class="container_12">
    <div class="grid_12 ">
      <div class="box bx2 pb1">
        <h3>Search result:</h3>
        <div id="search-results"></div>
      </div>
    </div>
  </div>
</div>

<!--==============================footer=================================-->

<footer>    
  <div class="container_12">
    <div class="grid_12">
    <div class="socials">
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
      <a href="#"></a>
    </div>
      <div class="copy">
      Halloween    &copy; 2013 | <a href="#">Privacy Policy</a> | Website Template Collect from <a href="http://www.cssmoban.com/"  title="网页模板">网页模板</a>
      </div>
    </div>
  </div>
</footer>

</body>
</html>