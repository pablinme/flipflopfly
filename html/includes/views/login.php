<?php render('_header',array('title'=>$title, 'login'=>true, 'head'=>'login with your email and password', 'leftPanel'=>true))?>
	<form class="form-horizontal" id="login" action="/login/" method="post" name="login_form" novalidate>	
			<div class="control-group">
	       		<label class="control-label">Email</label>
				<div class="controls">
		    		<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input class="input" name="email" autocomplete="off" class='email' id="email" type="email" required="required" pattern="[^ @]*@[^ @]*" >
					</div>
				</div>	
			</div>		
			<div class="control-group">
	       		<label class="control-label">Password</label>
				<div class="controls">
		    		<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input class="input" type="password" id="password" name="password" autocomplete="off" required='required'>
					</div>
				</div>
			</div>
			<div class="control-group">
			<label class="control-label" for="input01"></label>
			<div class="controls">
				<button class="btn btn-success" type="submit" value="Login" onclick="formhashl(this.form, this.form.password);">Log In</button>
				</br></br>
				<a href="/recover/">Forgotten your password?</a>
			</div>
		</div>					
	</form>
<?php render('_footer')?>
