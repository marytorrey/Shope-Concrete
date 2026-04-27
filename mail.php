<?php
	include 'header.php';
	$tab = '';
	if (!empty($_POST)){
		$name = $_POST['name'];
		$subject = 'An Application from ' . $name . ' from the website';
		$email = $_POST['email'];
		$message = $_POST['message'];
		$contactEmail = 'jobs@shopeconcrete.com';
	
		
		$sentMessage = 'The following message is from ' . $name . ' at ' . $email . ": \r\n " . $message;		
		mail ( $contactEmail, $subject, $sentMessage);
	}	
?>
	<script type="text/javascript">
		window.location = "https://www.shopeconcrete.com/mail.php";
	</script>  
      <section class="section-lg bg-default text-center">
        <div class="container">		
          <div class="countdown countdown-default" data-type="until" data-time="31 Dec 2020 16:00" style="height: 117px; padding-top: 200px; padding-bottom: 100px">
			<h4>Thank you for reaching out.</h4> <br> <h6>You will be contacted shortly by our staff.</h6></div>
			
        </div>
      </section>

		<?php
			include 'footer.php';
		?>