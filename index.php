<?php
include('header.php');
?>

<!-- Start of Body Content -->
<section>
  <div class="swiper-container swiper-slider swiper-slider_fullheight bg-gray-dark"
       data-simulate-touch="false"
       data-loop="true"
       data-autoplay="5500">
    <div class="swiper-wrapper">

      <?php
      $slides = [
          ["BigAndHardPipe.JPG", "Precast Concrete Pipe", "Made from reinforced concrete pipe, the go-to choice in drainage and sanitary sewer systems.", "catalog1.php"],
          ["LargeManholeSide.JPG", "Manholes", "Your #1 local provider of manholes throughout Puget Sound.", "catalog3.php"],
          ["CatchBasinRisers.JPG", "Catch Basins", "A cast iron lid on a large masonry basin located throughout our city.", "catalog2.php"]
      ];

      foreach ($slides as $slide) :
      ?>
        <div class="swiper-slide" data-slide-bg="images/<?= $slide[0] ?>">
          <div class="swiper-slide-caption text-center">
            <div class="container">
              <div class="row justify-content-lg-center">
                <div class="col-lg-10">
                  <h1 class="heading-decorated" data-caption-animate="fadeInUpSmall" data-caption-delay="100">
                    <?= $slide[1] ?>
                  </h1>
                  <h4 class="text-boxed" data-caption-animate="fadeInUpSmall" data-caption-delay="300">
                    <?= $slide[2] ?>
                  </h4>
                  <!-- Optional Button -->
                  <!--
                  <a class="button button-primary"
                     data-caption-animate="fadeInUpSmall"
                     data-caption-delay="350"
                     href="<?= $slide[3] ?>">
                     View Product
                  </a>
                  -->
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<?php include('footer.php'); ?>
