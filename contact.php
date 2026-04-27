<?php
	include 'header.php';

	$tab = isset($_POST['tab']) ? $_POST['tab'] : '';
	if(isset($_POST['submit'])){
		if($tab == '1'){
			$to = 'mclassy@gmail.com';		
		}
		elseif($tab == '2'){
			$to = 'marytorrey2015@gmail.com';
		}
		#$to = 'marytorrey2015@gmail.com';
		$from = $_POST['email']; // this is the sender's Email address
		$name = $_POST['name'];
		$subject = "A message from the website";
		$subject2 = "Copy of your submission to Shope Concrete";
		$message = $name . " wrote the following:" . "\n\n" . $_POST['message'];
		$message2 = "Here is a copy of your message " . $name . "\n\n" . $_POST['message'];

		$headers = "From:" . $from;
		$headers2 = "From:" . $to;
		mail($to,$subject,$message,$headers);
		mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
		//echo "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
		$URL="https://www.shopeconcrete.com/thanks.php";
		echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';// to redirect to another page.
		// You cannot use header and echo together. It's one or the other.
    }
?>
<!-- Script for the google map -->
	 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsPo6Nvmhihyjkh_Lm5h4WpYtDNS7Ycfk&callback=initMap&libraries=&v=weekly"
      defer>
		 $("#button").on("click", function(){
        	var ref_this = $("ul.tabs li a.active");
        		alert(ref_this.data("id"));
		 });
	</script>
    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
		
	  function getTab(){
		  return $("ul.tabs li a.active");
	  }
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: 47.191530, lng: -122.271840 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 17,
          center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: uluru,
          map: map,
        });
      }
    </script>
      <section class="section-md bg-default">
        <div class="container">
          <!-- Bootstrap tabs-->
          <div class="tabs-custom tabs-horizontal" id="tabs-1" style="height: 117px; padding-top: 200px; padding-bottom: 100px">
            <!-- Nav tabs-->
            <ul class="nav nav-custom nav-custom-tabs">
              <li><a class="nav-link active" href="#tabs-1-1" data-toggle="tab">
				  <div class="button button-primary"><?php print_r($tab) ?> Support Desk | Sales | Engineering</div></a></li>
              <li><a class="nav-link" href="#tabs-1-2" data-toggle="tab">
				  <div class="button button-primary"><?php print_r($tab) ?> Accounting | Finance </div></a></li>
            </ul>
          </div>
          <div class="tab-content text-left">
            <div class="tab-pane fade show active" id="tabs-1-1">
			<?php $tab = '1';?>
              <p>
			  <section class="bg-default">
				<div class="container">
				  <div class="row row-50">
					<div class="col-md-5 col-lg-4">
					  <h4 class="heading-decorated">Contact Details</h4>
					</div>
					<div class="col-md-7 col-lg-8">
					  <h4 class="heading-decorated">Get in Touch with Support | Sales | Engineering</h4>	  
					</div>
				  </div>
				</div>
			  </section>
			  </p>   
			</div>
            <div class="tab-pane fade" id="tabs-1-2">
				<?php $tab = '2';?>
              <p>
				<section class="bg-default">
				<div class="container">
				  <div class="row row-50">
					<div class="col-md-5 col-lg-4">
					  <h4 class="heading-decorated">Contact Details</h4>
					</div>
					<div class="col-md-7 col-lg-8">
					  <h4 class="heading-decorated">Get in Touch with Accounting | Finance</h4>					  
					</div>
				  </div>
				</div>
			  </section>
			  </p>    
			 </div>
		  <!--Start of Map and Form -->
          <div class="text-left">
            <div class="tab-pane fade show active">
              <p>
			  <section class="bg-default">
				<div class="container">
				  <div class="row row-50">
					<div class="col-md-5 col-lg-4">
					  <ul class="list-sm contact-info">
						<li>
						  <dl class="list-terms-inline">
							<dt>Address</dt>
							<dd>1618 E. Main Ave.Puyallup, WA 98372</dd>
						  </dl>
						</li>
						<li>
						  <dl class="list-terms-inline">
							<dt>Phones</dt>
							<dd>
							  <ul class="list-semicolon">
								<li><a href="tel:+12538481551">(253) 848-1551</a></li>
								<li><a href="tel:+18004227560">(800) 422-7560</a></li>
							  </ul>
							</dd>
						  </dl>
						</li>
						<li>
						  <dl class="list-terms-inline">
							<dt>We are open</dt>
							<dd>Mn-Fr: 7 am-4 pm</dd>
						  </dl>
						  <dl class="list-terms-inline">				
							  <dd>
							  <!--Google Map-->
								<section class="section">
								  <div id="map"></div>	
							  </section>
							</dd>
						  </dl>
						</li>
					  </ul>
					</div>
					<div class="col-md-7 col-lg-8">
					  <!-- RD Mailform-->
					<!-- <form class="rd-mailform rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" method="post" action="">
						<div class="form-wrap form-wrap_icon linear-icon-man">
						  <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
						  <label class="form-label" for="contact-name">Your name</label>
						</div>
						<div class="form-wrap form-wrap_icon linear-icon-envelope">
						  <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
						  <label class="form-label" for="contact-email">Your e-mail</label>
						</div>
						<div class="form-wrap form-wrap_icon linear-icon-feather">
						  <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
						  <label class="form-label" for="contact-message">Your message</label>
						</div>
						<div class="form-wrap form-validation-left">-->
						  <!--Google captcha-->
						  <!--<div class="recaptcha" id="captcha1" data-sitekey="6LfZlSETAAAAAC5VW4R4tQP8Am_to4bM3dddxkEt" data-auto-size=""></div>
						</div>
						<button class="button button-primary" type="submit" name="submit" value="Submit">send</button>
					  </form>-->
						<form class="rd-mailform rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" action="" method="post">
							<div class="form-wrap form-wrap_icon linear-icon-man">
							  <input class="form-input" type="text" name="name" data-constraints="@Required">
							  <label class="form-label" for="name">Your name</label>
						    </div>
							<div class="form-wrap form-wrap_icon linear-icon-envelope">
						  		<input class="form-input" type="email" name="email" data-constraints="@Email @Required">
						  		<label class="form-label" for="email">Your e-mail</label>
							</div>
							<div class="form-wrap form-wrap_icon linear-icon-feather">
						  		<textarea class="form-input" name="message" data-constraints="@Required"></textarea>
						  		<label class="form-label" for="message">Your message</label>
							</div>
		
							<input class="button button-primary" id ="button" type="submit" name="submit" value="Send">
						</form>
						<!--<form class="rd-mailform rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" method="post" action="../Not used/bat/rd-mailform.php">
							<div class="form-wrap form-wrap_icon linear-icon-man">
							  <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
							  <label class="form-label" for="contact-name">Your name</label>
							</div>
							<div class="form-wrap form-wrap_icon linear-icon-envelope">
							  <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
							  <label class="form-label" for="contact-email">Your e-mail</label>
							</div>
							<div class="form-wrap form-wrap_icon linear-icon-feather">
							  <textarea class="form-input" id="contact-message" name="message" data-constraints="@Required"></textarea>
							  <label class="form-label" for="contact-message">Your message</label>
							</div>
							<div class="form-wrap form-validation-left">
							  
							</div>
							<button class="button button-primary" type="submit">send</button>
             		   </form>-->
						
					</div>
				  </div>
				</div>
			  </section>
			  </p>   
			</div>
          </div>
<!--End of Map and Form -->
          </div>
        </div>
      </section>

<?php
	include 'footer.php';
?>