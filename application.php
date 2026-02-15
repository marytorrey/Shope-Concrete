<?php include('header.php');

if(isset($_POST['submit'])){
		//$tab = echo ('<script type="text/javascript">$("ul.tabs li a.active");</script>');
		
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
<section class="bg-gray-dark text-center">
	<section class="section parallax-container" data-parallax-img="images/metalWire.JPG">
	  <div class="parallax-content parallax-header parallax-light">
		<div class="parallax-header__inner">
		  <div class="parallax-header__content">
			<div class="container">
			  <div class="row justify-content-sm-center">
				<div class="col-md-10 col-xl-8">
				  <h2>Apply for Shope Concrete!</h2>
				  <form class="rd-mailform rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" method="post" action="../Not used/bat/rd-mailform.php">
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
							  <label class="form-label" for="contact-message">Your Cover Letter</label>
							</div>
							<div class="form-wrap form-validation-left">
							  
							</div>
					  		<div class="form-wrap form-wrap_icon linear-icon-feather">
							  <label class="form-label" for="contact-message">Your Resume</label>
							  <input class="form-input button-primary" type="file" id="fileinput" style="padding-left: 25%" />
							</div>
							<button class="button button-primary" type="submit">send</button>
             		   </form>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>
</section>

<?php include('footer.php');?>