<h1>Login</h1>

<?php 
$userdata = $this->session->all_userdata();
$message = isset($message) ? $message : '';
echo render_message($userdata, $message);
?>

<form method="post" action="<?php echo site_url('security/do_login') ?>" id="login-form" class="clear">
	<fieldset>
		<div class="control-group">
			<label class="control-label" for="email">Email Address *</label>
			<div class="controls">
				<input class="input-xlarge" type="text" name="email" id="email" value="" maxlength="50" placeholder="Email Address">
			</div>
		</div>						

		<div class="control-group">
			<label class="control-label" for="password">Password *</label>
			<div class="controls">
				<input class="input-xlarge" type="password" name="password" id="password" value="" maxlength="50" placeholder="Password">
				<br><a href="<?php echo site_url('security/forgotten_password') ?>">Forgotten Password?</a>
			</div>
		</div>			
	</fieldset>
	
	<div class="form-actions">
		<input type="submit" name="submit" id="submit" value="Login" class="btn btn-primary">
	</div>
</form>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>$.fn.validate || document.write('<script src="assets/js/jquery.validate.min.js"><\/script>')</script>
<script>
jQuery(function($) {
	// form validation (http://docs.jquery.com/Plugins/Validation)
	$("#login-form").validate({
		rules:{
			email:{required:true, email:true, maxlength:100}
			, password:{required:true}
		},
		messages:{
			email:{required:"Enter your email address", email:"Enter a valid email address"}
			, password:{required:"Enter your password"}
		}
	});
});
</script>