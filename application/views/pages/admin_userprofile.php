<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">User profile</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?php echo base_url() ?>index.php/admin">
      <button type="button" class="btn btn-primary">
        Go back
      </button>
      </a>
      <br/><br/>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Profile</div>
        <!--<div class="panel-body">-->

        <!-- Table -->
        <table class="table">
          
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Email
                </th>
                <th>
                    Password (Encrypted)
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
            
            <tr>
                <td>
                    <?php echo $user["id"]; ?>
                </td>
                <td>
                    <?php echo $user["email"]; ?>
                </td>
                <td>
                    <?=$user["password"];?>
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
                    <a href="<?php echo base_url() ?>index.php/admin/edituser/<?php echo $user["id"]; ?>">
                    <button type="button" class="btn btn-primary">
                    Edit
                  </button>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url() ?>index.php/admin/deleteuser/<?php echo $user["id"]; ?>">
                    <button type="button" class="btn btn-primary">
                    Delete
                  </button>
                    </a>
                </td>
            </tr>
            
        </table>
        
        <!--</div>-->
      </div>

  </div>
</div>