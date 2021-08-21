<?php render('_header',array('title'=>$title, 'recover'=>true,'head'=>'Welcome back '.Recover::getUserName($securityUser=='' ? $_POST['userID'] : $securityUser), 'leftPanel'=>true))?>
	<fieldset>
		<p>In the fields below, please enter your new password.</p>
	</fieldset>
	
	<form class="form-horizontal" id="recover"  action="/recover/" name="recovery_form" method="post" novalidate>	
		<div class="control-group">
	        	<label class="control-label">Password</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="input-xlarge" type="password" id="password1" name="password1" required='required'>
					</div>
				</div>
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Confirm Password</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="input-xlarge" type="password" name="password" data-validate-linked='password1' required='required'>
					</div>
				</div>
			</div>		
						
		<input type="hidden" name="subStep" value="3" />
		<input type="hidden" name="userID" value="<?= $securityUser=='' ? $_POST['userID'] : $securityUser; ?>" />
		<input type="hidden" name="key" value="<?= $_GET['email']=='' ? $_POST['key'] : $_GET['email']; ?>" />
		<?php if ($error == true) { ?><span class="error">The new passwords must match and must not be empty.</span></br><?php } ?>
		
		<div class="control-group">
			<label class="control-label" for="input01"></label>
			<div class="controls">
				<button class="btn btn-success" type="submit" value="Submit" onclick="formhashnew(this.form, this.form.password, this.form.password1);">continue</button>
			</div>
		</div>	
		<div class="clear"></div>
	</form>
<?php render('_footer')?>
