<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon glyphicon-cog"></span> Settings</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?php echo base_url(); ?>index.php/student">
      <button type="button" class="btn btn-primary">
        <span class="glyphicon glyphicon-arrow-left"></span> Back
      </button>
      </a>
      <br/><br/>
      
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Change password</h3>
        </div>
        <div class="panel-body">
          
            <form method="POST">
            
            <div class="col-lg-5">
            <div class="input-group">
              <span class="input-group-addon">*</span>
              <input name="param_oldpassword" type="password" class="form-control" placeholder="Old password" required>
            </div>
            </div>
            <br/><br/><br/>
            <div class="col-lg-5">
            <div class="input-group">
              <input name="param_newpassword" type="password" class="form-control" placeholder="New password" required>
              <span class="input-group-btn">
                <input name="submit_changepassword" class="btn btn-default" type="submit" value="Change password">
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
            
          </form>
            
        </div>
      </div>
      
        </div>
      </div>
      
  </div>
</div>