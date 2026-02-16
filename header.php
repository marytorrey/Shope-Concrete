<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPage = basename($path);
if ($currentPage === '' || $currentPage === false) { $currentPage = 'index.php'; }

if (!function_exists('getTitle')) {
 function getTitle($currentPage){
     switch ($currentPage) {
         case 'index.php':
             echo 'Home | Shope Concrete - Puyallup, WA';
             break;
         case 'about.php':
             echo 'About | Shope Concrete - Puyallup, WA';
             break;
         case 'contact.php':
             echo 'Contact | Shope Concrete - Puyallup, WA';
             break;
         case 'employment.php':
             echo 'Careers | Shope Concrete - Puyallup, WA';
             break;
         case 'privacy.php':
             echo 'Privacy Policy | Shope Concrete - Puyallup, WA';
             break;
         case 'startercat.php':
             echo 'E-Catalog | Shope Concrete - Puyallup, WA';
             break;
         case 'catalog1.php':
             echo 'Concrete Pipe | Shope Concrete - Puyallup, WA';
             break;
         case 'catalog2.php':
             echo 'Catch Basins | Shope Concrete - Puyallup, WA';
             break;
         case 'catalog3.php':
             echo 'Manholes | Shope Concrete - Puyallup, WA';
             break;
         case 'catalog4.php':
             echo 'Maintenance Holes | Shope Concrete - Puyallup, WA';
             break;
         case 'catalog5.php':
             echo 'Concrete Products | Shope Concrete - Puyallup, WA';
             break;
         default:
             echo 'Shope Concrete - Puyallup, WA';
             break;
     }
 }
}

if (!function_exists('getMetaDescription')) {
 function getMetaDescription($currentPage){
     switch ($currentPage) {
         case 'index.php':
             return 'Shope Concrete manufactures precast concrete pipe, manholes, catch basins, and drainage products in Puyallup, Washington.';
         case 'about.php':
             return 'Learn about Shope Concrete, a leading manufacturer of precast concrete products in Puyallup, WA. Quality and service since 1945.';
         case 'contact.php':
             return 'Contact Shope Concrete in Puyallup, WA for inquiries about precast concrete products, sales, and customer service.';
         case 'privacy.php':
             return 'Read Shope Concrete’s privacy policy, including how we handle website data and inquiries.';
         case 'catalog1.php':
             return "Explore Shope Concrete's precast concrete pipe catalog. Sizes, specifications, and applications for drainage and infrastructure.";
         case 'catalog2.php':
             return "Discover Shope Concrete's precast catch basins. WSDOT Type 1, Type 2, and custom solutions for stormwater management.";
         case 'catalog3.php':
             return "View Shope Concrete's precast manholes. WSDOT Type 1, Type 2, Type 3, and custom maintenance hole designs.";
         case 'catalog4.php':
             return "Shope Concrete's precast maintenance holes and specialized drainage structures. High-quality solutions for various applications.";
         case 'catalog5.php':
             return "Browse Shope Concrete's full range of precast concrete products. Custom solutions, vaults, barriers, and more.";
         case 'startercat.php':
             return "Shope Concrete's comprehensive e-catalog for all precast concrete products. Browse pipe, manholes, catch basins, and custom items.";
         case 'employment.php':
             return 'Join the Shope Concrete team! Explore career opportunities in precast concrete manufacturing, sales, and operations in Puyallup, WA.';
         default:
             return 'Shope Concrete manufactures precast concrete pipe, manholes, catch basins, and drainage products in Puyallup, Washington.';
     }
 }
}
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title><?php getTitle($currentPage);?></title>
    <?php $canonical = 'https://shopeconcrete.com' . $_SERVER['REQUEST_URI']; ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="description" content="<?php echo htmlspecialchars(getMetaDescription($currentPage), ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_inet.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <![endif]-->
  </head>
  <body>
    <div class="preloader">
      <div class="wrapper-triangle">
        <div class="pen">
          <div class="line-triangle"></div>
          <div class="line-triangle"></div>
          <div class="line-triangle"></div>
          <div class="triangle"></div>
          <div class="copyright">Shope Concrete</div>
        </div>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-panel" data-xl-device-layout="rd-navbar-panel" data-xxl-layout="rd-navbar-panel" data-xxl-device-layout="rd-navbar-panel" data-stick-up-clone="false" data-md-stick-up-offset="5px" data-lg-stick-up-offset="5px" data-xl-stick-up-offset="5px" data-xxl-stick-up-offset="5px" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-panel">
              <div class="rd-navbar-nav-wrap">
                <!-- RD Navbar Nav-->
                <ul class="rd-navbar-nav">
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Home</a>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="about.php">About</a>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="employment.php">Careers</a>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="contact.php">Contact</a>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="startercat.php">Catalog</a>
                    <!-- RD Navbar Megamenu-->
                    <ul class="rd-navbar-megamenu">
                      <li class="rd-megamenu-item">
                        <ul class="rd-megamenu-list">
                          <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="catalog1.php">Concrete Pipe</a></li>
                          <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="catalog2.php">Catch Basins</a></li>
                          <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="catalog3.php">Manholes</a></li>
                          <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="catalog4.php">Maintenance Holes</a></li>
                          <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="catalog5.php">Concrete Products</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="#">Quick Links</a>
                    <!-- RD Navbar Dropdown-->
                    <ul class="rd-navbar-dropdown">
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="startercat.php">E-Catalog</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="privacy.php">Privacy Policy</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
