<?php render('_header',array('title'=>$title, 'register'=>true, 'head'=>'create your account'))?>
	<form class="form-horizontal"  id="register" action="/register/" method="post" name="register_form" novalidate>
		<fieldset>
			<div class="control-group">
	        	<label class="control-label">Username</label>
				<div class="controls">
			    	<div class="input-append">
						<span class="add-on"><i class="icon-user"></i></span>
						<input class="input" id="username" name="username" autocomplete="off" placeholder="" maxlength="10" pattern="[a-zA-Z0-9]{5,}" autocorrect="off" autocapitalize="off" required="required" type="text" onchange="checkUser()">  
						<input type='button' id='username_val' value='username' class="btn btn-info disabled">
					</div>
				</div>
			</div>
			<div id='username_availability_result'></div>  
						
			<div class="control-group">
	        	<label class="control-label">Name</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input class="input"  name="name" autocomplete="off" placeholder="" pattern="[a-z]{3,}" required="required" type="text">
					</div>
				</div>
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Last Name</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input class="input" name="last_name" autocomplete="off" placeholder="" pattern="[a-z]{3,}" required="required" type="text">
					</div>
				</div>
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Gender</label>
				<div class="controls">
			    	<select class="span3 required" name="gender">
						<option value="M">male</option>
						<option value="F">female</option>
					</select>
				</div>
			</div>
		
			<div class="control-group">
	        	<label class="control-label">Country</label>
				<div class="controls">
			    	<select class="span3 required" name="country">
						 <?php foreach ( $countries as $item ) : ?>
						 <option value="<?php echo $item['countryCode']; ?>"><?php echo $item['countryName']; ?></option>
						 <?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Timezone</label>
				<div class="controls">
			    	<select class="span3 required" name="timezone">
						 <?php foreach ( $timezones as $item ) : ?>
						 <option value="<?php echo $item['timeCode']; ?>"><?php echo $item['timeName']; ?></option>
						 <?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="control-group">
	        	<label class="control-label">Email</label>
				<div class="controls">
			    	<div class="input-append">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input class="input" name="email1" class='email' id="email1" required="required" autocomplete="off" type="email" pattern="[^ @]*@[^ @]*" onchange="checkMail()" >
						<input type='button' id='email_val' value='email' class="btn btn-info disabled">
					</div>
				</div>	
			</div>
			<div id='email_availability_result'></div>  
						
			<div class="control-group">
	        	<label class="control-label">Confirm Email</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input class="input" type="email" class='email' name="email" data-validate-linked='email1' autocomplete="off" required='required' pattern="[^ @]*@[^ @]*" >
					</div>
				</div>	
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Password</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="input" type="password" id="password1" name="password1" required='required'>
					</div>
				</div>
			</div>
			
			<div class="control-group">
	        	<label class="control-label">Confirm Password</label>
				<div class="controls">
			    	<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="input" type="password" name="password" data-validate-linked='password1' required='required'>
					</div>
				</div>
			</div>		
				
		</fieldset>
		<div class="control-group">
			<label class="control-label" for="input01"></label>
			<div class="controls">
				<button class="btn btn-success" type="submit" value="register" onclick="formhash(this.form, this.form.password, this.form.password1);">Sign Up</button>
			</div>
		</div>		
	</form>	
<?php render('_footer')?>
