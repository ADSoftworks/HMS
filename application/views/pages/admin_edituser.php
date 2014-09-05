    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-warning-sign"></span> 
        <strong>LET OP!</strong><br/>
        Het wachtwoord word versleuteld weergeven, <br/>
        laat het wachtwoord voor wat het is als u het niet wilt veranderen,<br/>
        zo niet voer het dan NIET versleuteld; maar normaal in.
    </div>
     <!--<br/><br/><br/><br/><br/><br/>-->
<form method="POST">
    
    <?php
    $user = $this->User_model->getUserById($param_id);
    ?>
    
    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Edit user: <?php echo $user["email"]; ?></h3>
  </div>
  <div class="panel-body">
    
      <a href="<?php echo base_url() ?>index.php/admin"
      <button type="button" class="btn btn-primary">
        Terug
      </button>
  </a>
     <br/><br/> 
    <strong>
        ID:
    </strong>
    
    <div class="input-group col-lg-6">
        <span class="input-group-addon">#</span>
        <input name="param_id" type="number" class="form-control" placeholder="ID" value="<?php echo $user["id"]; ?>" readonly>
      </div>
    <br/>
    <strong>
        Email:
    </strong>
    <div class="input-group col-lg-6">
  <span class="input-group-addon">@</span>
  <input name="param_email" type="email" class="form-control" placeholder="Email" value="<?php echo $user["email"] ?>" required>
</div>
    <br/>
    <strong>
        Password:
    </strong><!--
--><div class="input-group col-lg-6">
  <span class="input-group-addon">*</span>
  <input name="param_password" type="text" class="form-control" placeholder="Password" value="<?php echo $user["password"] ?>">
</div>
    <br/>
        <strong>
        Gebruikers groep:
    </strong>
<div class="input-group col-lg-6">
<!--  <span class="input-group-addon">#</span>
  <input name="param_group_id" type="number" class="form-control" 
         placeholder="Gebruikers groep" 
         value="<?php echo $user["group_id"]; ?>" required>-->
    
    <select name="param_group_id" class="form-control">
        <option value="0" <?php if($user["group_id"] == 0) echo "selected='selected'"; ?>>Student</option>
        <option value="1" <?php if($user["group_id"] == 1) echo "selected='selected'"; ?>>Docent</option>
    </select>
    
</div>
    <br/>
    <input name="submit_edit" type="submit" class="btn btn-primary" 
           value="Aanpassen" />
    
</form>

  </div>
</div>