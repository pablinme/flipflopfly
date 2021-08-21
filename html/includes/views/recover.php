<?php render('_header',array('title'=>$title, 'recover'=>true, 'head'=>'Password Reset', 'leftPanel'=>true))?>
	<label class="control-label">please enter your username or email</label>
	<form class="form-horizontal" action="/recover/" method="post">
		<div class="control-group">
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input class="input" data-validate-length-range="4" autocomplete="off" id="username" name="username" placeholder="" min="5" maxlength="10" pattern="[a-zA-Z0-9]{5,}" type="text">  
				</div>
		    	<div class="input-prepend">
					<span class="add-on"><i class="icon-envelope"></i></span>
					<input class="input" name="email" class='email' id="email" type="email" autocomplete="off" pattern="[^ @]*@[^ @]*" >
				</div>
			</div>	
		</div>
		<input type="hidden" name="subStep" value="1" />
		<?php if ($error == true) { ?><span class="error">You must enter either your username or email to continue.</span><?php } ?>
		<div class="control-group">
			<label class="control-label" for="input01"></label>
			<div class="controls">
				<button class="btn btn-success" type="submit" value="Submit">continue</button>
			</div>
		</div>	
		<div class="clear"></div>
	</form>			
<?php render('_footer')?>
