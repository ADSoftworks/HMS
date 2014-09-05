<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/student_forgotpassword.css" rel="stylesheet" />

<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Wachtwoord vergeten</h3>
  </div>
  <div class="panel-body">

      <p>
          Na het invullen van je email versturen we een email met je wachtwoord.
      </p>
      
      <form method="POST">
      
        <div class="col-lg-6">
            <div class="input-group">
              <input name="param_email" type="email" class="form-control" placeholder="Email adres" required>
              <span class="input-group-btn">
                <input name="submit_forgotpassword" class="btn btn-default" type="submit" value="Verstuur wachtwoord">
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        
        <p>
            <!--<a href="?c=studentlogin&m=index&a=student_login"><< Terug naar login scherm</a>-->            
            <a href="<?php echo base_url(); ?>index.php/docentlogin"><< Terug naar login scherm</a>            
        </p>
      
        </form>
        
  </div>
</div>