<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Gebruikers Profiel</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?php echo base_url() ?>index.php/admin">
      <button type="button" class="btn btn-primary">
        Terug
      </button>
      </a>
      <br/><br/>
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Profiel</div>
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
                    Wachtwoord (Encrypted)
                </th>
                <th>
                    Gebruikers Groep
                </th>
                <th>
                    Aanpassen
                </th>
                <th>
                    Verwijderen
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
                            echo "Docent";
                            break;
                        
                    }
                    
                    ?>
                </td>
                <td>
                    <a href="<?php echo base_url() ?>index.php/admin/edituser/<?php echo $user["id"]; ?>">
                    <button type="button" class="btn btn-primary">
                    Aanpassen
                  </button>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url() ?>index.php/admin/deleteuser/<?php echo $user["id"]; ?>">
                    <button type="button" class="btn btn-primary">
                    Verwijderen
                  </button>
                    </a>
                </td>
            </tr>
            
        </table>
        
        <!--</div>-->
      </div>

  </div>
</div>