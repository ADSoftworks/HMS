<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />

<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Teacher Register</h3>
  </div>
  <div class="panel-body">
    
      <form method="POST">
          <div class="input-group input-group">
            <span class="input-group-addon">@</span>
            <input name="param_email" type="email" class="form-control" placeholder="Email address" required/>
          </div>
          <br/>

              <input name="param_firstname" type="text" class="form-control" placeholder="Firstname" required />
              <br/>
              <input name="param_lastname" type="text" class="form-control" placeholder="Lastname" required />
              
          <br/>
          
            <input name="param_password" type="password" class="form-control" placeholder="Password" required/>
          
          <br/>
          
        <div class="col-lg-6">
            <div class="input-group" id="password">
              <input name="param_password_confirmation" type="password" class="form-control" placeholder="Password again" required/>
              <span class="input-group-btn">
                  <input name="submit_register" class="btn btn-primary" type="submit" value="Register" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
      </form>
        </div><!-- /.row -->
          
          <p id="orclickhere">
              <!--<a href="?c=studentlogin&m=index&a=student_login">-->
              <a href="<?=base_url()?>index.php/login">
                  Or click here to login.
              </a>
          </p>
      
  </div>
<!--</div>-->