<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Admin panel</h3>
  </div>
  <div class="panel-body">
    
  
      <!--CONTENT-->
      
    <a href="<?php echo base_url(); ?>index.php/admin/logout">
      <button class="btn btn-primary">
          Logout
      </button>
    </a>
      <br/><br/>
      
      <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Fetch a profile by email</h3>
  </div>
  <div class="panel-body">
    
      <p>Fetch a user profile through their email address.</p>
      
      <form method="POST">
      
        <div class="col-lg-6">
        <div class="input-group">
          <input name="param_email" type="text" class="form-control" placeholder="Email adres" required/>
          <span class="input-group-btn">
            <input name="submit_search" class="btn btn-default" type="submit" 
                   value="Profiel ophalen" />
          </span>
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
      
  
    </form>
      
  </div>
</div>
      
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">All active users</div>
  <div class="panel-body">
    <p>An overview of all active users.</p>
  </div>

  <!-- Table -->
  <table class="table">
    
      <?php 
      
      $users = $this->User_model->getAllUsers();
      
      if( ! $users) {
      
          echo "<tr><td>Geen actieve gebruikers.</td></tr>";
          
      } else {
          
      ?>
      
      <tr>
          
          <th>
              ID
          </th>
          <th>
              Email address
          </th>
          <th>
              Name
          </th>
          <th>
              User group
          </th>
          <th>
              Edit
          </th>
          <th>
              Delete
          </th>
          
      </tr>
      
      <?php foreach($users as $user) { ?>
      
      <tr>
          
          <td>
              <?php echo $user["id"]; ?>
          </td>
          
          <td>
              <?php echo $user["email"]; ?>
          </td>
          
          <td>
              <?=$user["firstname"] . " " . $user["lastname"];?>
          </td>
          
          <td>
              <?php
              switch($user["group_id"]) {
                  
                  case 0:
                      echo "Student";
                      break;
                  
                  case 1:
                      echo "Teacher";
                      break;
                  
              }
              ?>
          </td>
          
          <td>
              <a href="<?=base_url();?>index.php/admin/edituser/<?=$user["id"];?>">
                  <button class="btn btn-primary">Edit</button>
              </a>
          </td>
          
          <td>
              <a href="<?=base_url();?>index.php/admin/deleteuser/<?=$user["id"];?>">
                  <button class="btn btn-primary">Delete</button>
              </a>
          </td>
          
      </tr>
      
      <?php } ?>
      
      <?php } ?>
      
  </table>
</div>
      
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">All active groups</div>
        <div class="panel-body">
          <p>An overview of all active groups.</p>
        </div>

        <!-- Table -->
        <table class="table">
          
            <?php 
            
            $groups = $this->Group_model->getAllGroups();
            
            if( ! $groups) {
                
                echo "<tr><td>No active groups</td></tr>";
                
            } else {
            
            ?>
            
            <tr>
                
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Description
                </th>
                <th>
                    Teacher ID
                </th>
                <th>
                    Student IDs
                </th>
                <th>
                    Group Code
                </th>
                <th>
                    Delete
                </th>
                
            </tr>
            
            <?php foreach($groups as $group) { ?>
            
            <tr>
                
                <td>
                <?=$group["id"];?>
                </td>
                <td>
                <?=$group["name"];?>
                </td>
                <td>
                <?=$group["description"];?>
                </td>
                <td>
                <?=$group["docent_id"];?>
                </td>
                <td>
                <?=$group["student_ids"];?>
                </td>
                <td>
                <?=$group["code"];?>
                </td>
                <td>
                    <div class="btn-group">
                        <a href='<?=base_url()?>index.php/admin/deletegroup/<?=$group["id"];?>'>
                            <button type="button" class="btn btn-primary">
                              Delete
                            </button>
                        </a>
                  </div>
                </td>
                
            </tr>
            
            <?php } ?>
            
        <?php } ?>
            
        </table>
      </div>
      
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Create docent</h3>
        </div>
        <div class="panel-body">
          
            <form method="POST">
            
            Enter an email address and password for the new teacher account.
            <br/><br/>
            <div class="col-lg-6">
            <input name="param_firstname" type="text" class="form-control" placeholder="Firstname" required />
            <br/>
            <input name="param_lastname" type="text" class="form-control" placeholder="Lastname" required />
            <br/>
            <input name="param_email" type="email" class="form-control" placeholder="Email adres" required>
            <br/>
            <input name="param_password" type="text" class="form-control" placeholder="Wachtwoord" required>
              <br/>
              <!--<span class="input-group-btn">-->
                <input name="createdocent_submit" class="btn btn-primary" type="submit" value="Aanmaken" />
              <!--</span>-->
            </div>
          </form>
          </div><!-- /.col-lg-6 -->
            
          
        </div>
      </div>
      
<!--      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Filesize limit</h3>
        </div>
        <div class="panel-body">
          
            <div class="col-lg-6">
            
                <p>This is to set a limit on the size of a file.<br/>
                if a file is bigger than this limit in MB's it will be rejected<br/>
                (2056 MB (2 Gigabyte) by default)</p>
                <form method="POST">
                <div class="input-group ">
                    <span class="input-group-addon">MB</span>
                    <input name="param_filesizelimit" type="number" class="form-control" placeholder="Filesize limit" value="<?=$filesizelimit;?>" >
                  </div>
                <br/>
                <input name="submit_filesizelimit" type="submit" class="form-control btn btn-primary" value="Set limit" />
                </form>
            </div>
            
        </div>
      </div>-->
      
      <!--CONTENT END-->
      
      
  </div>
</div>