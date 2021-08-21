<?php if($header) render('_header_reg',array('title'=>$title, 'head'=>$head, 'username'=>$username, 'sidebar'=>$sidebar, 'alertShow'=>false))?>
	<?php if($numComments > 0) { foreach($comments as $c):?>
		<div class="comment">
			<div class="date"><?php echo $c->modified?></div>
			<label class="label muted"> <?php echo $c->commenterName?> : </label>
			<?php echo $c->body?>
			
			<?php if ($c->del_url != ''):?>
				<a id='del_comment' class="btn btn-mini btn-danger" onclick="delComment(<?= $c->id; ?>)">
					<i class="icon-trash button"></i></a>
			<?php endif;?>
			</div>			
	<?php endforeach; } else { echo('this post has no comments !'); }?>
<?php if($footer) render('_footer_reg')?>
