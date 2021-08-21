<div class="span2">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<div id="userStats" class="clearfix">
				<div class="pic">
					<a href="#"><img src="/assets/img/avatar.jpg" width="60" height="60" /></a>
				</div>
				
				<div class="data">
					<h1><small><?php echo $sidebar->userInfo->name.' '.$sidebar->userInfo->lastname ?></small></h1>
					<h3><small><?php echo $sidebar->userInfo->username ?></small></h3>
					<h4><small><?php echo $sidebar->userInfo->country ?></small></h4>
					
					<div class="sep"></div>
					<ul class="numbers clearfix">
						<li class="nobrdr"><small>Join Date <?php echo $sidebar->userInfo->date ?></small></li>
					</ul>
				</div>
			</div>
		</ul>
	</div>
	<?php if($sidebar->numTopics > 0) { ?>
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header"><?php echo $sidebar->titleTopics ?></li>
					<?php foreach($sidebar->latestTopics as $p):?>
					    <li>
						<small><a href="<?php echo $p->url?>"><?php echo $p->subject ?></a><small class="muted"> posted by <?php echo $p->posterName?></small></small>
						</li>
					<?php endforeach;?>
			</ul>
		</div><!--/.well -->
	<?php } ?>
	
	<!-- Rating -->
	<?php if($sidebar->numRates > 0) { ?>
		<div class="well sidebar-nav">
			<ul class="nav nav-list"> 
				<li class="nav-header"><?php echo $sidebar->titleRates ?></li>
					<?php foreach($sidebar->latestRates as $p):?>
					  	<?php
						  	$id = $p->id;
						  	$v = $p->total;
					
						  	echo'<li>
						  	  	<div id="rating_'.$id.'" class="ratings">';
						  	  	for($k = 1; $k < 6; $k++)
						  	  	{
							  	  	if($v >= $k)$class="star_".$k."  ratings_stars_lock ratings_vote";
							  	  	else $class = "star_".$k." ratings_stars_lock ratings_blank";
							  	  	echo '<div class="'.$class.'"></div>';
							  	}
							  	echo' <div><small> rated by '.$p->raterName. ' </small></div>
							  	</div>
							  	</li>';
						?>
					<?php endforeach;?>
			</ul>
		</div><!--/.well -->
	<?php } ?>
</div><!--/sidebar left-->
