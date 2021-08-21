<?php
	if(sizeof($breadcrumbs) > 0)
	{ ?>
		<ul class="breadcrumb">
		<?php
		$last = end($breadcrumbs);
		foreach($breadcrumbs as $p):?>
			<?php if($p !== $last) { ?>
				<li><a href="<?php echo $p->url ?>"><?php echo $p->name ?></a> <span class="divider">/</span></li>
			<?php } ?>
			<?php if($p == $last) { ?>
				<li class="active"><?php echo $p->name ?></li>
			<?php } ?>
		<?php endforeach; ?>
	</ul>
<?php } ?>		