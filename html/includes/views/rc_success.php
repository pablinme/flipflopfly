<?php render('_header',array('title'=>$title, 'recover'=>true, 'head'=>'please check your email', 'leftPanel'=>true))?>
	<fieldset>
		<p>An email has been sent to you with instructions on how to reset your password. 
		<br /><br />
		<a href="/login/">Return to the login page.</a></p>
	</fieldset>
<?php render('_footer')?>