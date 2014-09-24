<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />

<div class="panel panel-primary" id="login-panel">
    <div class="panel-heading">
        <h3 class="panel-title">Teacher Signup Login</h3>
    </div>
    <div class="panel-body">

        <p>
            Please sign in with the passcode you received from your administrator.
        </p>

        <div class="col-lg-6">
        <form method="POST">
            <div class="input-group" id="password">
                <input name="login_password" type="text" class="form-control" placeholder="Passcode" required>
                <span class="input-group-btn">
                <input name="login_submit" class="btn btn-primary" type="submit" value="Continue" />
                </span>
            </div><!-- /input-group -->
        </form>
        </div>

    </div>
</div>