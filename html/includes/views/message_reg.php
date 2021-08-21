<?php render('_header_reg',array('title'=>$title, 'head'=>$head, 'username'=>$username, 'sidebar'=>$sidebar, 'alertShow'=>false)) ?>
	<p><?php echo $body?></p>
<?php render('_footer_reg')?>