<?php render('_header',array('title'=>$title, 'recover'=>true, 'head'=>'Invalid Key!', 'leftPanel'=>true))?>
	<p>The key that you entered was invalid. Either you did not copy the entire key from the email, </p>
	<p> or you are trying to use the key after it has expired (3 days after request), or you have already used the key in which case it is deactivated.</p>
	<br /><br />
	<p> <a href="/login/">Return to the login page. </a></p>
<?php render('_footer')?>
