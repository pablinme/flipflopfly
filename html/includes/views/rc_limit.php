<?php render('_header',array('title'=>$title, 'recover'=>true, 'head'=>'warning!', 'leftPanel'=>true))?>
	<fieldset>
		<p>You have answered the security question wrong too many times. You will be locked out for 15 minutes, after which you can try again.</p>
		<br /><br /><a href="/login/">Return to the login page.</a></p>
	</fieldset>
<?php render('_footer')?>
