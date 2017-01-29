<div class="container">

<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<?php
		if(validation_errors() != false || $this->session->flashdata('auth_error')) { 

			?>
			<div class="alert alert-danger">
			<?php echo $this->session->flashdata('auth_error'); ?>
			<?php echo validation_errors(); ?>
			</div>
			<?php
			 
		}?>
		<?php echo form_open('auth/register'); ?>
			
				<h2>Register</h2>
				<hr class="colorgraph">
				<div class="form-group">
                    <input value="<?php echo set_value('user_fname'); ?>" type="user_fname" name="user_fname" id="user_fname" class="form-control input-lg" placeholder="First Name">
				</div>
				<div class="form-group">
                    <input value="<?php echo set_value('user_lname'); ?>" type="user_lname" name="user_lname" id="user_lname" class="form-control input-lg" placeholder="Last Name">
				</div>
				<div class="form-group">
                    <input value="<?php echo set_value('email'); ?>" type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address">
				</div>
				<div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
				</div>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Register">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<a href="<?php echo base_url(); ?>auth/login" class="btn btn-lg btn-primary btn-block">Login</a>
					</div>
				</div>

		</form>
	</div>
</div>

</div>