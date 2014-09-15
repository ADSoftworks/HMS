<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Group settings</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?=base_url();?>index.php/docent">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
      </button>
      </a>
      
      <!--<a href="<?=base_url();?>index.php/docent/deletegroup/<?=$group["id"];?>">-->
      <button id="delete_group" type="button" class="btn btn-danger">
          <span class="glyphicon glyphicon-remove"></span> Delete group
      </button>
      <!--</a>-->
          
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