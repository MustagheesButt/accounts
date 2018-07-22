<div class="container">
    <div class="row justify-content-center">
    	<div class="col-md-8">
    		<p>Sign in to continue</p>
    	</div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="">
                	<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
					    <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
					  </li>
					</ul>
                </div>

                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
						<div class="card-body">
		                    <form method="POST" action="<?= base_url() ?>login">

		                        <div class="form-group row">
		                            <label for="emailOrUsername" class="col-sm-4 col-form-label text-md-right">E-Mail Address Or Username</label>

		                            <div class="col-md-6">
		                                <input id="emailOrUsername" type="text" class="form-control <?= form_error('emailOrUsername') == '' ? '' : 'is-invalid' ?>" name="emailOrUsername" value="<?= set_value('emailOrUsername'); ?>" required autofocus>

		                                <span class="invalid-feedback">
	                                        <strong><?= form_error('emailOrUsername') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

		                            <div class="col-md-6">
		                                <input id="password2" type="password" class="form-control <?= form_error('password') == '' ? '' : 'is-invalid' ?>" name="password" required>

		                                <span class="invalid-feedback">
	                                        <strong><?= form_error('password') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <input type="hidden" name="continue" value="<?= (set_value('continue') ? set_value('continue') : $this->input->get('continue')) ?>" />

		                        <div class="form-group row mb-0">
		                            <div class="col-md-8 offset-md-4">
		                                <button type="submit" class="btn btn-primary">
		                                    Login
		                                </button>

		                                <a class="btn btn-link" href="<?= base_url() ?>password_reset">
		                                    Forgot Your Password?
		                                </a>
		                            </div>
		                        </div>
		                    </form>
		                </div>
					</div>

					<div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
						<div class="card-body">
		                    <form method="POST" action="<?= base_url() ?>register#register">

		                        <div class="form-group row">
		                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

		                            <div class="col-md-6">
		                                <input id="first_name" type="text" class="form-control <?= form_error('first_name') ? 'is-invalid' : '' ?>" name="first_name" value="<?= set_value('first_name'); ?>" required autofocus>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('first_name') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">Middle Name <small class="optional">optional</small></label>

		                            <div class="col-md-6">
		                                <input id="middle_name" type="text" class="form-control <?= form_error('middle_name') ? 'is-invalid' : '' ?>" name="middle_name" value="<?= set_value('middle_name'); ?>" autofocus>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('middle_name') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

		                            <div class="col-md-6">
		                                <input id="last_name" type="text" class="form-control <?= form_error('last_name') ? 'is-invalid' : '' ?>" name="last_name" value="<?= set_value('last_name'); ?>" required autofocus>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('last_name') ?></strong>
	                                    </span>
		                            </div>
		                        </div>


		                        <div class="form-group row">
		                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

		                            <div class="col-md-6">
		                                <input id="email" type="email" class="form-control" name="email <?= form_error('email') ? 'is-invalid' : '' ?>" value="<?= set_value('email'); ?>" required>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('email') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

		                            <div class="col-md-6">
		                                <input id="password" type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" name="password" required>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('password') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="confirm_password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

		                            <div class="col-md-6">
		                                <input id="confirm_password" type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" name="confirm_password" required>

		                                <span class="invalid-feedback">
	                                        <strong><?= form_error('confirm_password') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="birthdate" class="col-md-4 col-form-label text-md-right">Birthdate</label>

		                            <div class="col-md-6">
		                                <input id="birthdate" type="date" class="form-control" name="birthdate" value="<?= set_value('birthdate'); ?>" required autofocus>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('birthdate') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>

		                            <div class="col-md-6">
		                                <select id="gender" type="text" class="form-control" name="gender" required autofocus>
		                                    <?php
		                                    	$items = ['M' => 'Male', 'F' => 'Female', 'O' => 'Others', 'S' => 'Prefer Not Say'];
		                                    	foreach ($items as $key => $value)
		                                    	{
		                                    		echo "<option value=\"$key\">$value</option>";
		                                    	}
		                                    ?>
		                                </select>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('gender') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Phone Number <small class="optional">optional</small></label>

		                            <div class="col-md-6">
		                                <input id="mobile_number" type="tel" class="form-control" name="mobile_number" value="<?= set_value('mobile_number'); ?>" autofocus>

	                                    <span class="invalid-feedback">
	                                        <strong><?= form_error('mobile_number') ?></strong>
	                                    </span>
		                            </div>
		                        </div>

		                        <input type="hidden" name="continue" value="<?= (set_value('continue') ? set_value('continue') : $this->input->get('continue')) ?>" />

		                        <div class="form-group row mb-0">
		                            <div class="col-md-6 offset-md-4">
		                                <button type="submit" class="btn btn-primary">
		                                    Register
		                                </button>
		                            </div>
		                        </div>
		                    </form>
		                </div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>