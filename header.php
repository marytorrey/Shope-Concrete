<?php
//Gets the current URL and finds which page is the main page and returns back the title tag
    //Site Title ####Fix Substring below when you go live to 24 #### -->

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPage = basename($path);
if ($currentPage === '' || $currentPage === false) { $currentPage = 'index.php'; }

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

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title><?php getTitle($currentPage);?></title>
    <?php $canonical = 'https://shopeconcrete.com' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;1,300&family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/bundle.min.css">
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
                              <li><a href="tel:+12538481551">(253) 848-1551</a></li>
                              <li><a href="tel:+18004227560">(800) 422-7560</a></li>
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
                  <button class="rd-navbar-search__toggle rd-navbar-fixed--hidden" data-rd-navbar-toggle=".rd-navbar-search-wrap"></button>
                </div>
                <!-- RD Search-->
               <!-- <div class="rd-navbar-search rd-navbar-search_toggled rd-navbar-search_not-collapsable">
                  <form class="rd-search" action="search-results.html" method="GET" data-search-live="rd-search-results-live">
                    <div class="form-wrap">
                      <input class="form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">
                      <label class="form-label" for="rd-navbar-search-form-input">Enter keyword</label>
                      <div class="rd-search-results-live" id="rd-search-results-live"></div>
                    </div>
                    <button class="rd-search__submit" type="submit"></button>
                  </form>
                  <div class="rd-navbar-fixed--hidden">
                    <button class="rd-navbar-search__toggle" data-custom-toggle=".rd-navbar-search-wrap" data-custom-toggle-disable-on-blur="true"></button>
                  </div>
                </div> -->

				<!-- Npca -->
				  <div class="rd-navbar-top-panel__right">
                    <ul class="list-inline-xxs">
                      <li>
						  <article class="post-link-mt" style="height: 50px; width: 90px">
						   <!-- Post Link-->
							<a class="" href="images/Shope concrete certification.PNG" data-lightgallery="item">
							<figure><img src="images/NPCA-Plant-Cert-logo.gif" width="45px" height="25px"/>
							 </figure>
							</a>

                		</article>
						  <!--<a class="icon icon-xxs" href="#"><img src="images/NPCA-Plant-Cert-logo.gif" alt="NPCA Certified" height="50px" width="90px"></a>-->
					  </li>
                    </ul>
                  </div>
				<!-- end NPCA -->
                <div class="rd-navbar-search_collapsable">
                  <ul class="rd-navbar-nav">
                    <li><a href="index.php">Home</a>

                    </li>
                    <li><a href="about.php">About</a>
                    </li>
                    <?php include 'quicklinks.php';?>
			<!-- QC Page
						<li><a href="qc.php">QC Info</a>
	                      <ul class="rd-navbar-dropdown">
	                        <li><a href="404.php">There is a new page. What do you want Eric Armstrong??</a>
	                        </li>
	                      </ul>
	                    </li>
			-->

                    <li><a href="startercat.php">Catalog</a>
                      <ul class="rd-navbar-megamenu">
						<li>
                          <p class="rd-megamenu-header">WSDOT</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 01 - 48 inch Type 1 Precast Manhole.pdf">48" Type 1 Precast Manhole</a></li>
							<li><a href="pdf/Page 02 - 48 inch Type 3 Precast Manhole.pdf">48" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 03 - 54 inch Type 1 Precast Manhole.pdf">54" Type 1 Precast Manhole</a></li>
							<li><a href="pdf/Page 04 - 54 inch Type 3 Precast Manhole.pdf">54" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 05 - 60 inch Type 3 Precast Manhole.pdf">60" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 06 - 60 inch Type 3 Modified Precast Manhole.pdf">60" Type 3M Precast Manhole</a></li>
							<li><a href="pdf/Page 07 - 60 inch Type 1 Precast Manhole.pdf">60" Type 1 Precast Manhole</a></li>
							<li><a href="pdf/Page 08 - 72 inch Type 3 Precast Manhole.pdf">72" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 09 - 72 inch Type 2 Precast Manhole.pdf">72" Type 2 Precast Manhole</a></li>
							<li><a href="pdf/Page 10 - 84 inch Type 3 Precast Manhole.pdf">84" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 11 - 96 inch Type 3 Precast Manhole.pdf">96" Type 3 Precast Manhole</a></li>
							<li><a href="pdf/Page 12 - 96 inch Type 2 Precast Manhole.pdf">96" Type 2 Precast Manhole</a></li>
							<li><a href="pdf/Page 13 - 48 inch Precast Concrete Dry Well.pdf">48" Precast Concrete Dry Well</a></li>
                          </ul>
						</li>
						<li>
                          <p class="rd-megamenu-header">City of Seattle</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 14 - Seattle Standard Plan 200a - 48 inch Type 204a Maintenance Hole.pdf">48" Type 204a Maintenance Hole</a></li>
							<li><a href="pdf/Page 15 - Seattle Standard Plan 200b - 54 inch Type 204b Maintenance Hole.pdf">54" Type 204b Maintenance Hole</a></li>
							<li><a href="pdf/Page 16 - Seattle Standard Plan 200c - 60 inch Type 204c Maintenance Hole.pdf">60" Type 204c Maintenance Hole</a></li>
							<li><a href="pdf/Page 17 - Seattle Standard Plan 200d - 72 inch Type 204d Maintenance Hole.pdf">72" Type 204d Maintenance Hole</a></li>
							<li><a href="pdf/Page 18 - Seattle Standard Plan 200e - 84 inch Type 204e Maintenance Hole.pdf">84" Type 204e Maintenance Hole</a></li>
							<li><a href="pdf/Page 19 - Seattle Standard Plan 200f - 96 inch Type 204f Maintenance Hole.pdf">96" Type 204f Maintenance Hole</a></li>
							<li><a href="pdf/Page 20 - Seattle Standard Plan 240 - Catch Basin Type 240.pdf">Catch Basin Type 240</a></li>
							<li><a href="pdf/Page 21 - Seattle Standard Plan 241 - Catch Basin Type 241.pdf">Catch Basin Type 241</a></li>
							<li><a href="pdf/Page 22 - Seattle Standard Plan 242 - Catch Basin Type 242.pdf">Catch Basin Type 242</a></li>
                          </ul>
						</li>
						<li>
                          <p class="rd-megamenu-header">City of Tacoma</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 23 - Tacoma Standard Plan dr-03 - Catch Basin Type 1.pdf">Catch Basin Type 1</a></li>
							<li><a href="pdf/Page 24 - Tacoma Standard Plan dr-04 - Catch Basin Type 2.pdf">Catch Basin Type 2</a></li>
                          </ul>
						</li>
						<li>
                          <p class="rd-megamenu-header">Miscellaneous</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 25 - Area Drain.pdf">Area Drain</a></li>
							<li><a href="pdf/Page 26 - Beehive Grate.pdf">Beehive Grate</a></li>
							<li><a href="pdf/Page 27 - Concrete Pipe.pdf">Concrete Pipe</a></li>
							<li><a href="pdf/Page 28 - Distribution Box.pdf">Distribution Box</a></li>
							<li><a href="pdf/Page 29 - Grease Interceptor.pdf">Grease Interceptor</a></li>
							<li><a href="pdf/Page 30 - Meter Box.pdf">Meter Box</a></li>
							<li><a href="pdf/Page 31 - Oil Water Separator.pdf">Oil Water Separator</a></li>
							<li><a href="pdf/Page 32 - Parking Bumper.pdf">Parking Bumper</a></li>
							<li><a href="pdf/Page 33 - Septic Tank.pdf">Septic Tank</a></li>
                          </ul>
						</li>
                      </ul>
                    </li>
                    <li><a href="contact.php">Contact</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
