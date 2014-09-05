<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />

<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Docenten log in</h3>
  </div>
  <div class="panel-body">
    
      <!--<div class="col-lg-6">-->
      
      <form method="POST">
          <div class="input-group input-group">
            <span class="input-group-addon">@</span>
            <input name="param_email" type="email" class="form-control" placeholder="Email adres" required>
          </div>
          
          <!--</div>-->
          
          <br/>
          
        <div class="col-lg-6">
            <div class="input-group" id="password">
              <input name="param_password" type="password" class="form-control" placeholder="Wachtwoord" required>
              <span class="input-group-btn">
                  <input name="submit_login" class="btn btn-default" type="submit" value="Log in" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
          
      </form>
      
          <p id="orclickhere">
              <!--<a href="?c=docentlogin&m=index&a=docent_forgotpassword">-->
              <a href="<?php echo base_url() ?>index.php/docentlogin/index/docent_forgotpassword">
                  Klik hier als je je wachtwoord bent vergeten.
              </a>
          </p>
          
  </div>
</div>