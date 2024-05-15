<?php
/**
 * Template Name: User Login
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>
<div class="gray py-3">
	<div class="container">
		<div class="row">
			<div class="colxl-12 col-lg-12 col-md-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo home_url('/') ?>">Home</a></li>
						<li class="breadcrumb-item"><a>Pages</a></li>
						<li class="breadcrumb-item active" aria-current="page">Login</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<section class="middle">
	<div class="container">
		<div class="row align-items-start justify-content-center">
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
				<form class="border p-3 rounded worplex-user-form" method="post">
					<div class="form-group">
						<label>Username/Email</label>
						<input type="text" name="user_email" class="form-control" placeholder="Username/Email*" required>
					</div>
					
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="user_pass" class="form-control" placeholder="Password*" required>
					</div>
					
					<div class="form-group">
						<div class="d-flex align-items-center justify-content-between">
							<div class="flex-1">
								<input id="remember_me" class="checkbox-custom" name="remember_me" type="checkbox">
								<label for="remember_me" class="checkbox-custom-label">Remember Me</label>
							</div>	
							<div class="eltio_k2">
								<a href="#">Lost Your Password?</a>
							</div>	
						</div>
					</div>
					
					<div class="form-group">
						<div class="form-security-fields" style="display: none;"></div>
						<input type="hidden" name="action" value="worplex_user_login_action">
						<button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
