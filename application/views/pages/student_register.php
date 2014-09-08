<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />

<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Register</h3>
  </div>
  <div class="panel-body">
    
      <form method="POST">
          <div class="input-group input-group">
            <span class="input-group-addon">@</span>
            <input name="param_email" type="email" class="form-control" placeholder="Email address" required/>
          </div>
          
          <br/>
          
          <div class="input-group input-group">
            <input name="param_password" type="password" class="form-control" placeholder="Password" required/>
          </div>
          
          <br/>
          
        <div class="col-lg-6">
            <div class="input-group" id="password">
              <input name="param_password_confirmation" type="password" class="form-control" placeholder="Password again" required/>
              <span class="input-group-btn">
                  <input name="submit_register" class="btn btn-default" type="submit" value="Register" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
          
      </form>
          <p id="orclickhere">
              <!--<a href="?c=studentlogin&m=index&a=student_login">-->
              <a href="<?=base_url()?>index.php/login">
                  Or click here to login.
              </a>
          </p>
      
  </div>
</div>