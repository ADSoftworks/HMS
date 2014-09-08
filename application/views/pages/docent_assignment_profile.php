<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Assignment profile</h3>
  </div>
  <div class="panel-body">
      <?php // die(var_dump($assignment)); ?>
      <a href="<?=base_url();?>index.php/docent/groupprofile/<?=$assignment["group_id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
      </button>
      </a>
      
      <!--<a href="<?=base_url();?>index.php/docent/deleteassignment/<?=$assignment["id"];?>">-->
      <button id="delete_assignment" type="button" class="btn btn-danger">
          <span class="glyphicon glyphicon-remove"></span> Delete assignment
      </button>
      <!--</a>-->
      <br/><br/>
      
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Assignment data</h3>
        </div>
        <div class="panel-body">
              <p class="lead"><?=$assignment["title"];?></p>
              <?=$assignment["description"];?>
        </div>
    </div>
      
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Turned in results.</h3>
        </div>
        <div class="panel-body">
            
            <?php if($homework): ?>
            
            <table class="table">
                
                <tr>
                
                    <th>
                        Email
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Download
                    </th>
                    <th>
                        Acties
                    </th>
                
                </tr>
                <?php foreach($homework as $h): ?>
                <?php // die(var_dump($h["id"])); ?>
                <tr>
                <td>
                    <?=$h["email"];?>
                </td>
                <td>
                    <?php if($h["status"] == "approved"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Approved!</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($h["status"] == "pending"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Pending</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($h["status"] == "rejected"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Rejected</span>
                    </div>
                  </div>

                <?php endif; ?>
                </td>
                <td>
                    <a href="<?=base_url()?>/assets/uploads/<?=$h["file_source"];?>" target="_blank"><button class="btn btn-primary">View homework</button></a>
                </td>
                <td>
                    <a href="<?=base_url();?>index.php/docent/approvehomework/<?=$h["id"];?>">Approve</a> |
                    <a href="<?=base_url();?>index.php/docent/rejecthomework/<?=$h["id"];?>">Reject</a> |
                    <!--<?=base_url();?>index.php/docent/deletehomework/<?=$h["id"];?>-->
                    <a id="delete_homework" href="#deletehomework">Delete</a>
                </td>
                </tr>
                <?php endforeach; ?>
                
            </table>
            
            <?php else: ?>
            
            There is no turned in homework.
            
            <?php endif; ?>
            
        </div>
      </div>
      
    </div>
      
      

      
  </div>
</div>

<?php // die(var_dump($assignment["id"])); ?>

<script>

var btn = document.getElementById("delete_assignment");
var link = document.getElementById("delete_homework");

window.onload = function() {
    
    btn.onclick = function() {
        
        if(confirm("Are you sure you want to delete this group?")) {
            
            window.location = "<?=base_url();?>index.php/docent/deleteassignment/<?=$assignment["id"];?>";
            
        }
        
    };
    
    <?php if(isset($h)): ?>
    link.onclick = function() {
    
        if(confirm("Are you sure you want to delete this homework?")) {
         
           window.location = "<?=base_url();?>index.php/docent/deletehomework/<?=$h["id"];?>";
            
        }
    
    };
    <?php endif; ?>
    
};

</script>