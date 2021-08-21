<?php render('_header',array('title'=>$title, 'home'=>$home, 'head'=>$head))?>	
	<div class="row-fluid">
		<blockquote><p> Welcome to the best way to exchange favors with travelers around the world. </p></blockquote>
		<div class="span3 offset6"><p><a class="btn btn-warning" href="/about/">learn more &raquo;</a></p> </div>
		<img src="/assets/img/top.jpg" class="img-polaroid">	
	</div><!--/row-->
	</br>
	<!-- Categories -->
	<?php render('categories'); ?>

<?php render('_footer')?>
