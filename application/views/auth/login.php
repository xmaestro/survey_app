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
		<?php echo form_open('auth/login'); ?>
			
				<h2>Login</h2>
				<hr class="colorgraph">
				<div class="form-group">
                    <input value="<?php echo set_value('email'); ?>" type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address">
				</div>
				<div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
				</div>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<a href="<?php echo base_url(); ?>auth/register" class="btn btn-lg btn-primary btn-block">Register</a>
					</div>
				</div>
			
		</form>
	</div>
</div>

</div>