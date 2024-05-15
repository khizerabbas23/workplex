<?php

defined('ABSPATH') || exit;

class Worplex_Login_Register_Markup
{

    public function __construct() {
        add_action('wp_footer', array($this, 'signin_popup_form'), 35);
    }

    public function signin_popup_form() {
        if (!is_user_logged_in()) {
            ?>
            <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
				<div class="modal-dialog login-pop-form" role="document">
					<div class="modal-content" id="loginmodal">
						<div class="modal-headers">
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							  <span class="ti-close"></span>
							</button>
						</div>
					
						<div class="modal-body p-5 popup-loginsec-con">
							<div class="text-center mb-4">
								<h2 class="m-0 ft-regular">Login</h2>
							</div>
							
							<form method="post" class="worplex-user-form">				
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
											<a href="#" class="theme-cl frgt-pass">Lost Your Password?</a>
										</div>	
									</div>
								</div>
								
								<div class="form-group">
                                    <div class="form-security-fields" style="display: none;"></div>
                                    <input type="hidden" name="action" value="worplex_user_login_action">
									<button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium">Login</button>
								</div>
								
								<div class="form-group text-center mb-0">
									<p class="extra">Not a member? <a href="#" class="text-dark login-to-regconv"> Register</a></p>
								</div>
							</form>
						</div>
					
                        <div class="modal-body p-5 popup-signupsec-con" style="display: none;">
                            <div class="text-center mb-4">
                                <h2 class="m-0 ft-regular">Register</h2>
                            </div>
                            
                            <form method="post" class="worplex-user-form">				
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name*" required>
                                </div>			
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name*" required>
                                </div>			
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username*" required>
                                </div>			
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="user_email" class="form-control" placeholder="Email*" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="user_pass" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_pass" class="form-control" placeholder="Password" required>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-security-fields" style="display: none;"></div>
                                    <input type="hidden" name="action" value="worplex_user_register_action">
                                    <button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium">Register</button>
                                </div>
                                
                                <div class="form-group text-center mb-0">
                                    <p class="extra">Already have an account? <a href="#" class="text-dark reg-to-loginconv"> Login</a></p>
                                </div>
                            </form>
                        </div>
                        
                        <div class="modal-body p-5 popup-frgt-pass" style="display: none;">
                            <div class="text-center mb-4">
                                <h2 class="m-0 ft-regular">Lost Your Password</h2>
                            </div>
                            
                            <form method="POST" class="worplex-user-form">				
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email*" required>
                                </div>
								<div class="form-group">
                                    <div class="form-security-fields" style="display: none;"></div>
                                     <input type="hidden" name="action" value="worplex_user_forget_password_action">
									<button type="submit" class="btn btn-md full-width theme-bg text-light fs-md ft-medium" name="submit">Submit</button>
								</div>

                            </form>
                        </div>
					</div>
				</div>
			</div>
            <?php
        }
    }
}

new Worplex_Login_Register_Markup;
