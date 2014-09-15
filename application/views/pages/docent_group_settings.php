<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Group settings</h3>
  </div>
  <div class="panel-body">
    
      <a class="btn btn-primary" href="<?=base_url();?>index.php/docent/groupprofile/<?=$group["id"];?>">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
      </a>
      
      <!--<a href="<?=base_url();?>index.php/docent/deletegroup/<?=$group["id"];?>">-->
      <button id="delete_group" type="button" class="btn btn-danger">
          <span class="glyphicon glyphicon-remove"></span> Delete group
      </button>
      <!--</a>-->
      <br/><br/>
      <div class="panel panel-primary">
          
            <div class="panel-heading">
              <h3 class="panel-title">Edit group</h3>
            </div>
            <div class="panel-body">
              
                <form method="POST">
                
                    <div class="col-lg-6">

                        <div class="input-group">
                        <span class="input-group-addon">Abc</span>
                        <input name="param_group_name" type="text" class="form-control" 
                               placeholder="Group name" value="<?=$group["name"];?>" required>
                        </div>
                        <br/>
                        <div class="input-group">
                            <span class="input-group-addon">Abc</span>
                            <textarea name="param_group_description" class="form-control" 
                                      placeholder="Short description" required><?=$group['description'];?></textarea>
                        </div>
                        <br/>
                        <input name="submit_editgroup" type="submit" class="btn btn-primary" value="Edit group" />

                    </div>
                    
                </form>
               
                
            </div>
          </div>
          
  </div>
</div>

<script>
 
    var btn = document.getElementById("delete_group");
 
    window.onload = function() {
        
        btn.onclick = function() {
          
            if(confirm("Are you sure you want to delete this group?")) {
                
                window.location = "<?=base_url();?>index.php/docent/deletegroup/<?=$group["id"];?>";
                
            }
            
        };
        
    };
 
</script>