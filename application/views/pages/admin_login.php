<link href="<?php echo base_url(); ?>assets/css/student_login.css" rel="stylesheet" />



<div class="panel panel-default" id="login-panel">
  <div class="panel-heading">
    <h3 class="panel-title">Admin login</h3>
  </div>
  <div class="panel-body">
          
      <form method="POST">
      
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
          
  </div>
</div>