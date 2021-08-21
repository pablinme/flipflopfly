<!-- All Posts -->
<?php if($header) render('_header_reg',array('title'=>$title, 'head'=>$head, 'username'=>$username, 'breadcrumbs'=>$breadcrumbs, 'sidebar'=>$sidebar, 'alertShow'=>false)) ?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan="2"><?php echo $topic ?></th>
			</tr>
		</thead>   
	<?php if($numPosts > 0) { foreach($posts as $p):?>
		<tbody>
			<tr>
				<td>
					<div class="date"><?php echo $p->date?></div>
					<label class="label muted"> posted by <?php echo $p->posterName?></label>
				</td>
				<td> <?php echo $p->content ?> </td>
			</tr>
		</tbody>
	<?php endforeach;?>
	</table>
	
	<ul class="pager">
	<?php if ($pagination['prev']):?>
		<li class="previous">
			<a href="?page=<?php echo $page-1?>">older</a>
		</li>
	<?php endif;?>
	<?php if ($pagination['next']):?>
		<li class="next">
			<a href="?page=<?php echo $page+1?>">newer</a>
		</li>
	<?php endif; } else { echo('we did not find any posts'); echo '</table>';} ?>
	</ul>
	<!-- Add Topic -->
	<?php render('add_post',array('topic'=>$topicID)) ?>
<?php if($footer) render('_footer_reg')?>
