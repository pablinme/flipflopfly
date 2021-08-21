<?php render('_header_reg',array('title'=>$title, 'head'=>$head, 'username'=>$username, 'breadcrumbs'=>$breadcrumbs, 'time'=>$time, 'sidebar'=>$sidebar, 'alertShow'=>false))?>
	
	<!-- Categories -->
	<?php render('categories'); ?>    

<?php render('_footer_reg')?>
