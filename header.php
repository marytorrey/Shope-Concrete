<?php
//Gets the current URL and finds which page is the main page and returns back the title tag
    //Site Title ####Fix Substring below when you go live to 24 #### -->

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPage = basename($path);
if ($currentPage === '' || $currentPage === false) { $currentPage = 'index.php'; }

function getTitle($currentPage){
    switch ($currentPage) {
        case 'index.php':
            echo 'Shope Concrete LLC';
            break;
        case 'about.php':
            echo 'Shope - About Us';
            break;
        case 'contact.php':
            echo 'Contact Us';
            break;
        case 'employment.php':
            echo 'Career Opportunities';
            break;
        case 'privacy.php':
            echo 'Privacy Policy';
            break;
        case 'startercat.php':
            echo 'E-Catalog';
            break;
        case 'catalog1.php':
            echo 'Concrete Pipe';
            break;
        case 'catalog2.php':
            echo 'Catch Basins';
            break;
        case 'catalog3.php':
            echo 'Manholes';
            break;
        case 'catalog4.php':
            echo 'Maintenance Holes';
            break;
        case 'qc.php':
            echo 'Quality Control';
            break;
        default:
            echo 'Shope Concrete';
            break;
    }
}

?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title><?php getTitle($currentPage);?></title>
    <link rel="canonical" href="https://shopeconcrete.com<?= htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>">
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
						<p class="rd-megamenu-header">WSDOT<br> Catch Basins</p>
                          <ul class="rd-megamenu-list">
                            <li><a href="pdf/Page 14 - 48 inch Type 2 Precast Catch Basin.pdf">48" Type 2 Precast Catch Basin</a></li>
                            <li><a href="pdf/Page 15 - 54 inch Type 2 Precast Catch Basin.pdf">54" Type 2 Precast Catch Basin</a></li>
                            <li><a href="pdf/Page 16 - 60 inch Type 2 Precast Catch Basin.pdf">60" Type 2 Precast Catch Basin</a></li>
							<li><a href="pdf/Page 17 - 72 inch Type 2 Precast Catch Basin.pdf">72" Type 2 Precast Catch Basin</a></li>
							<li><a href="pdf/Page 18 - 72 inch Type 2 Precast Catch Basin With Baffle.pdf">72" Type 2 Precast Catch Basin - Baffle</a></li>
							<li><a href="pdf/Page 19 - 84 inch Type 2 Precast Catch Basin.pdf">84" Type 2 Precast Catch Basin</a></li>
							<li><a href="pdf/Page 20 - 96 inch Type 2 Precast Catch Basin.pdf">96" Type 2 Precast Catch Basin</a></li>
							<li><a href="pdf/Page 21 - 84 inch Type 2 Precast Manhole.pdf">84" Type 2 Precast Manhole</a></li>
                          </ul>
						</li>
						<li>
						  <p class="rd-megamenu-header">Seattle</p>
                          <ul class="rd-megamenu-list">
                            <li><a href="pdf/Page 25 - 48 inch Type 240 ABCD Precast Catch Basin.pdf">48" Type 240 ABCD</a></li>
                            <li><a href="pdf/Page 26 - 48 inch Type 204a Maintenance Hole.pdf">48" Type 204a</a></li>
                            <li><a href="pdf/Catalog/Page 41 - 48 inch Type 204b Maintenance Hole.pdf">48" Type 204b</a></li>
                            <li><a href="pdf/Page 27 - 48 inch Type 204a Maintenance Hole-Modified.pdf">48" Type 204a</a></li>
							<li><a href="pdf/Page 28 - 48 inch Type 204b Maintenance Hole.pdf">54" Type 204b</a></li>
							<li><a href="pdf/Page 29 - 54 inch Type 270 Flow Control Structure.pdf">54" Type 270 Flow Control</a></li>
							<li><a href="pdf/Page 30 - 54 inch Type 204.5a Maintenance Hole.pdf">54" Type 204.5a Maintenace Hole</a></li>
							<li><a href="pdf/Page 31 - 54 inch Type 204.5b Maintenance Hole.pdf">54" Type 204.5b</a></li>
							<li><a href="pdf/Page 32 - 60 inch Type 205a Maintenance Hole.pdf">60" Type 205a</a></li>
							<li><a href="pdf/Page 33 - 60 inch Type 205b Maintenance Hole.pdf">60" Type 205b</a></li>
							<li><a href="pdf/Page 34 - 72 inch Type 206a Maintenance Hole.pdf">72" Type 206a</a></li>
							<li><a href="pdf/Page 35 - 72 inch Type 206b Maintenance Hole.pdf">72" Type 206b</a></li>
							<li><a href="pdf/Page 36 - 84 inch Type 207a Maintenance Hole.pdf">84" Type 207a</a></li>
							<li><a href="pdf/Page 37 - 84 inch Type 207b Maintenance Hole.pdf">84" Type 207b</a></li>
							<li><a href="pdf/Page 38 - 96 inch Type 208a Maintenance Hole.pdf">96" Type 208a</a></li>
							<li><a href="pdf/Page 39 - 96 inch Type 208b Maintenance Hole.pdf">96" Type 208b</a></li>
                          </ul>
                        </li>
                        <li>
						  <p class="rd-megamenu-header">Catch Basins</p>
                          <ul class="rd-megamenu-list">
                            <li><a href="pdf/Page 45 - Catch Basin Risers - Type 1 Risers.pdf">Risers Type 1</a></li>
                            <li><a href="pdf/Page 46 - Type 1.pdf">Type 1</a></li>
							<li><a href="pdf/Page 47 - Type 1 Curb Inlet Top.pdf">Type 1 - Top</a></li>
							<li><a href="pdf/Page 48 - Catch Basin Type 1-L.pdf">Type 1-L</a></li>
							<li><a href="pdf/Page 49 - Type 1-L Curb Inlet Top.pdf">Type 1-L - Top</a></li>
							<li><a href="pdf/Page 50 - Catch Basin Type 1-P.pdf">Type 1-P</a></li>
                            <li><a href="pdf/Page 51 - Type 1 – Optional Ditch Inlet Top.pdf">Type 1 - optional Ditch Inlet Top</a></li>
                            <li><a href="pdf/Page 52 - Conversion Riser For Type 1-L Catch Basin.pdf">Type 1-L Conversion Riser</a></li>
							<li><a href="pdf/Page 53 - Catch Basin Type 241a.pdf">Type 241a</a></li>
							<li><a href="pdf/Page 54 - Catch Basin Type 242.pdf">Type 242</a></li>
							<li><a href="pdf/Page 55 - Type 252 Inlet.pdf">Type 252 Inlet</a></li>
							<li><a href="pdf/Page 56 - Inlet Basin Type 250.pdf">Type 250 Inlet Basin</a></li>
						  </ul>
                        </li>
                        <li>
                          <p class="rd-megamenu-header">Catch Basins</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 57 - Grate Inlet Type 2.pdf">Inlet Type 2</a></li>
							<li><a href="pdf/Page 58 - Grate Inlet Type 2 Top - Modified.pdf">Type 2 - Mod</a></li>
							<li><a href="pdf/Page 59 - Catch Basin Type 15.pdf">Type 15</a></li>
							<li><a href="pdf/Page 60 - Curb Inlet Type 26.pdf">Type 26</a></li>
							<li><a href="pdf/Page 61 - Curb Inlet Type 26M.pdf">Type 26 - Mod</a></li>
							<li><a href="pdf/Page 62 - Catch Basin Type 30.pdf">Type 30</a></li>
							<li><a href="pdf/Page 63 - Catch Basin Type 40.pdf">Type 40</a></li>
							<li><a href="pdf/Page 64 - Drop Inlet Type 1.pdf">Type 1 - Drop Inlet</a></li>
							<li><a href="pdf/Page 65 - Catch Basin Type 9.pdf">Type 9</a></li>
							<li><a href="pdf/Page 66 - Catch Basin Type 50.pdf">Type 50</a></li>
                          </ul>
                        </li>
						<li>
                          <p class="rd-megamenu-header">Concrete Pipe</p>
                          <ul class="rd-megamenu-list">
							<li><a href="pdf/Page 72 - 12in to 24 inch Concrete Pipe Profile.pdf">12" to 24" Pipe</a></li>
							<li><a href="pdf/Page 73 - 12in to 24 inch Concrete Pipe Reinforcement.pdf">12" to 24" Profile</a></li>
							<li><a href="pdf/Page 75 - Pyramid Monument.pdf">Pyramid Monument</a></li>
							<li><a href="pdf/Page 76 - Bell Monument.pdf">Bell Monument</a></li>
                          </ul>
						  <p class="rd-megamenu-header">Tacoma</p>
                          <ul class="rd-megamenu-list">
                            <li><a href="pdf/Page 22 - 48 inch Precast Manhole.pdf">48" Precast Manhole</a></li>
                            <li><a href="pdf/Page 23 - 48 inch Type 3 Precast Manhole.pdf">48" Type 3 Precast Manhole</a></li>
                            <li><a href="pdf/Page 24 - 54 inch Precast Manhole.pdf">54" Precast Manhole</a></li>
                          </ul>
						  <p class="rd-megamenu-header">Accessories</p>
                          <ul class="rd-megamenu-list">
                            <li><a href="pdf/Page 40 - Lane P14938 Safety Step.pdf">Lane P14938 Safety Step</a></li>
                            <li><a href="pdf/Page 41 - Lane Polypropylene Hanging Ladder.pdf">Lane Polypropylene Hanging Ladder</a></li>
                            <li><a href="pdf/Page 42 - Grade Rings.pdf">Grade Rings</a></li>
                            <li><a href="pdf/Page 43 - 30 inch Grade Rings.pdf">30" Grade Rings</a></li>
							<li><a href="pdf/Page 44 - 36 inch Grade Rings.pdf">36" Grade Rings</a></li>
                          </ul>
                        </li>
                      </ul>
                    </li>
					<li><a href="#">Employment</a>
                      <ul class="rd-navbar-dropdown">
                      <li><a href ="frontdesk.php">Assocate Accountant</a></li>
                        <li><a href="driver.php">Class A Driver</a></li>
						<!--<li><a href="drafter.php">CAD Drafter</a></li> -->
						<!--<li><a href="disbatch.php">Assistant Disbatcher</a>
                        </li> -->
						<!--<li><a href ="frontdesk.php">Front Desk / Sales</a></li> -->
						          <li><a href="general.php">General Labor</a></li>
                      </ul>
                    </li>
                    <li><a href="contact.php">Contacts</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>