<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />

<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Log in</h3>
  </div>
  <div class="panel-body">
      
      <form method="POST">
          
          <div class="input-group input-group">
            <span class="input-group-addon">@</span>
            <input name="param_email" type="email" class="form-control" placeholder="Email address" required>
          </div>
          
          <br/>
          
        <div class="col-lg-6">
            <div class="input-group" id="password">
              <input name="param_password" type="password" class="form-control" placeholder="Password" required>
              <span class="input-group-btn">
                  <input name="submit_login" class="btn btn-default" type="submit" value="Login" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
      </form>
        </div><!-- /.row -->
          
      
          <p id="orclickhere">
              <!--<a href="?c=studentlogin&m=index&a=student_register">-->
              <a href="<?=base_url();?>index.php/login/index/student_register">
                  Or click here to register.
              </a>
              <br/>
              <!--<a href="?c=studentlogin&m=index&a=student_forgotpassword">-->
              <a href="<?=base_url();?>index.php/login/index/student_forgotpassword">
                  Click here if you've forgotten your password.
              </a>
          </p>
          
  </div>
<!--</div>-->