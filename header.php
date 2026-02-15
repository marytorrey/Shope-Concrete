<?php
//Gets the current URL and finds which page is the main page and returns back the title tag
    //Site Title ####Fix Substring below when you go live to 24 #### -->

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
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
            case 'qc.php':
                echo 'Quality Control | Shope Concrete - Puyallup, WA';
                break;
            case '404.php':
                echo 'Page Not Found | Shope Concrete - Puyallup, WA';
                break;
            case 'aboutTwirlyBoxes.php':
                echo 'Our Sister Companies | Shope Concrete - Puyallup, WA';
                break;
            case 'verticleTwirlyBoxes.php':
                echo 'Our Suppliers | Shope Concrete - Puyallup, WA';
                break;
            case 'disbatch.php':
                echo 'Assistant Dispatcher Careers | Shope Concrete - Puyallup, WA';
                break;
            case 'drafter.php':
                echo 'CAD Drafter Careers | Shope Concrete - Puyallup, WA';
                break;
            case 'driver.php':
                echo 'Class A Driver Careers | Shope Concrete - Puyallup, WA';
                break;
            case 'frontdesk.php':
                echo 'Front Desk & Inside Sales Careers | Shope Concrete - Puyallup, WA';
                break;
            case 'general.php':
                echo 'General Labor Careers | Shope Concrete - Puyallup, WA';
                break;
            case 'video.php':
                echo 'About Us Video | Shope Concrete - Puyallup, WA';
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
                return 'Shope Concrete: Precast concrete pipe, manholes, catch basins, and drainage products in Puyallup, WA.';
            case 'about.php':
                return 'Learn about Shope Concrete, a leading precast concrete manufacturer in Puyallup, WA. History, mission, and team.';
            case 'contact.php':
                return 'Contact Shope Concrete in Puyallup, WA for precast concrete products, sales, and support. Get directions and office hours.';
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
    <title><?php getTitle($currentPage); ?></title>
    <?php $canonical = 'https://shopeconcrete.com' . $_SERVER['REQUEST_URI']; ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="description" content="<?php echo htmlspecialchars(getMetaDescription($currentPage), ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:300,300italic%7CMontserrat:400,700">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/formStyles.css">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
      <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M4SG3W3G');</script>
    <!-- End Google Tag Manager -->
  </head>
  <body>
 <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4SG3W3G"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div class="preloader">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
      </div>
    </div>
    <!-- Page-->
    <div class="page">
      <header class="page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar_transparent rd-navbar_boxed" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-lg-stick-up-offset="35px" data-xl-stick-up-offset="35px" data-xxl-stick-up-offset="35px" data-body-class="rd-navbar-absolute">
            <!-- RD Navbar Top Panel-->
            <div class="rd-navbar-top-panel">
              <div class="rd-navbar-top-panel__main">
                <div class="rd-navbar-top-panel__toggle rd-navbar-fixed__element-1 rd-navbar-static--hidden" data-rd-navbar-toggle=".rd-navbar-top-panel__main"><span></span></div>
                <div class="rd-navbar-top-panel__content">
                  <div class="rd-navbar-top-panel__left">
                    <ul class="rd-navbar-items-list">
                      <li>
                        <div class="unit flex-row align-items-center unit-spacing-xs">
                          <div class="unit-left"><span class="icon icon-sm icon-primary linear-icon-map-marker"></span></div>
                          <div class="unit-body">
                            <p><a href="#">Address: 1618 E. Main Ave.Puyallup, WA 98372-3142</a></p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="unit flex-row align-items-center unit-spacing-xs">
                          <div class="unit-left"><span class="icon icon-sm icon-primary linear-icon-telephone"></span></div>
                          <div class="unit-body">
                            <ul class="list-semicolon">
                              <li><a href="tel:#">(253) 848-1551</a></li>
                              <li><a href="tel:#"> (800) 422-7560</a></li>
                            </ul>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
					<!-- facebook, twitter, google+, vimeo, youtube, pinteret
                  <div class="rd-navbar-top-panel__right">
                    <ul class="list-inline-xxs">
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-facebook" href="#"></a></li>
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-twitter" href="#"></a></li>
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-google-plus" href="#"></a></li>
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-vimeo" href="#"></a></li>
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-youtube" href="#"></a></li>
                      <li><a class="icon icon-xxs icon-gray-darker fa fa-pinterest-p" href="#"></a></li>
                    </ul>
                  </div>
						-->
                </div>
              </div>
            </div>
            <div class="rd-navbar-inner rd-navbar-search-wrap">
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel rd-navbar-search-lg_collapsable">
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand-name" href="index.php"><img src="images/Header Logo.png" alt="" width="329" height="39"/></a></div>
              </div>
              <!-- RD Navbar Nav-->
              <div class="rd-navbar-nav-wrap rd-navbar-search_not-collapsable">
                <!-- RD Navbar Nav-->
                <div class="rd-navbar__element rd-navbar-search_collapsable">
                  <button class="rd-navbar-search__toggle" data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                </div>
                <!-- RD Search-->
               <!-- <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                  <form class="rd-search" action="search-results.html" method="GET" data-search-live="rd-search-results-live">
                    <div class="form-wrap">
                      <input class="form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">
                      <label class="form-label" for="rd-navbar-search-form-input">Enter keyword</label>
                      <div class="rd-search-results-live" id="rd-search-results-live"></div>
                    </div>
                    <button class="rd-search__toggle" type="submit"></button>
                  </form>
                </div>-->
                <ul class="rd-navbar-nav">
                  <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Home</a>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="about.php">About</a>
                    <ul class="rd-menu rd-navbar-dropdown">
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="about.php">History</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="qc.php">Quality Control</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="video.php">About Us Video</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="aboutTwirlyBoxes.php">Our Sister Companies</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="verticleTwirlyBoxes.php">Our Suppliers</a></li>
                    </ul>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="startercat.php">Products</a>
                    <div class="rd-menu rd-navbar-megamenu">
                      <ul class="rd-navbar-megamenu-markup">
                        <li>
                          <ul class="rd-navbar-megamenu-list">
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="startercat.php">E-Catalog</a></li>
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="catalog1.php">Concrete Pipe</a></li>
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="catalog2.php">Catch Basins</a></li>
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="catalog3.php">Manholes</a></li>
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="catalog4.php">Maintenance Holes</a></li>
                            <li class="rd-navbar-megamenu-list-item"><a class="rd-navbar-megamenu-list-link" href="catalog5.php">Concrete Products</a></li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="employment.php">Careers</a>
                    <ul class="rd-menu rd-navbar-dropdown">
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="employment.php">Employment Opportunities</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="disbatch.php">Assistant Dispatcher</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="drafter.php">CAD Drafter</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="driver.php">Class A Driver</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="frontdesk.php">Front Desk & Inside Sales</a></li>
                      <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="general.php">General Labor</a></li>
                    </ul>
                  </li>
                  <li class="rd-nav-item"><a class="rd-nav-link" href="contact.php">Contact</a>
                  </li>
                </ul>
              </div>
              <!-- RD Navbar Search-->
              <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                <form class="rd-search" action="search-results.html" method="GET" data-search-live="rd-search-results-live">
                  <div class="form-wrap">
                    <label class="form-label" for="rd-navbar-search-form-input">Search...</label>
                    <input class="form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">
                    <div class="rd-search-results-live" id="rd-search-results-live"></div>
                  </div>
                </form>
                <button class="rd-navbar-search__toggle" data-rd-navbar-toggle=".rd-navbar-search" onclick="document.getElementById('rd-navbar-search-form-input').value = '';"></button>
              </div>
            </div>
          </nav>
        </div>
      </header>
