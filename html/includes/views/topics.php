<!-- All Topics -->
<?php if($header) render('_header_reg',array('title'=>$title, 'head'=>$head, 'username'=>$username, 'breadcrumbs'=>$breadcrumbs, 'sidebar'=>$sidebar, 'alertShow'=>false)) ?>
	<?php if($numTopics > 0) { foreach($topics as $p):?>
		<div class="topic">
			<div class="date"><?php echo $p->date?></div>
			<h2><a href="<?php echo $p->url?>"><?php echo $p->subject ?></a> <label class="label muted"> posted by <?php echo $p->posterName?></label> </h2>
		</div>
		<?php if ($p->del_url != ''):?>
			<a class="btn btn-danger" onclick="location.href='<?php echo $p->del_url?>';">
				<i class="icon-trash icon-large"></i> Delete Post</a>
		<?php endif;?>
	<?php endforeach;?>
	
	<ul class="pager">
	<?php if ($pagination['prev']):?>
		<li class="previous">
			<a href="?page=<?php echo $page-1?>">Newer</a>
		</li>
	<?php endif;?>
	<?php if ($pagination['next']):?>
		<li class="next">
			<a href="?page=<?php echo $page+1?>">Older</a>
		</li>
	<?php endif; } else { echo('we did not find any topics'); } ?>
	</ul>
	<!-- Add Topic -->
	<?php render('add_topic',array('category'=>$category)) ?>
<?php if($footer) render('_footer_reg')?>
