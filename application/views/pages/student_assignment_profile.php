<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Assignment profile</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?=base_url();?>index.php/student/groupprofile/<?=$assignment["group_id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
      </button>
      </a>
      
<!--      <a href="<?=base_url();?>index.php/docent/deleteassignment/<?=$assignment["id"];?>">
      <button type="button" class="btn btn-danger">
          <span class="glyphicon glyphicon-remove"></span> Verwijder opdracht
      </button>
      </a>-->
      <br/><br/>
      
            <?php if($homework): ?> 
      
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Status</h3>
        </div>
        <div class="panel-body">
            
            
                <?php if($homework["status"] == "approved"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Approved!</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($homework["status"] == "pending"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Pending</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($homework["status"] == "rejected"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Rejected</span>
                    </div>
                  </div>

                <?php endif; ?>

            
            </div>
      </div>
      
            <?php endif; ?>
      
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Assignment</h3>
        </div>
        <div class="panel-body">
              <p class="lead"><?=$assignment["title"];?></p>
              <?=$assignment["description"];?>
        </div>
    </div>
      
   <?php if( ! $homework): ?>
      
      <?php // if(): what the fuck happened here?>
      
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Upload homework.</h3>
        </div>
        <div class="panel-body">
          
            Select a file to hand in..<br/><br/>
            
            <form method="POST" enctype="multipart/form-data">
                <input id="work" name="homework" class="btn-primary" type="file" title="Select a file to hand in" required />
                <br/><br/>
                <input id='upload-button' name="submit_homework" class='btn btn-primary' type="submit" value="Upload" />
            </form>
            
        </div>
      </div>
      
      <?php else: ?>
      
        <a href="<?=base_url()?>/assets/uploads/<?=$homework["file_source"];?>" target="_blank">
        <button class="btn btn-primary">View homework</button>
        </a>
      
      <?php endif;#endif; ?>

    </div>
  </div>
</div>

<!--

I FUCKING LOVE LIBRARIES OH MY GOD YOU SAVED ME SO MUCH TIME WITH THIS <333333333

-->
<script src="<?=base_url();?>/assets/js/lib/jquery.js"></script>
<script src="<?=base_url();?>/assets/js/lib/file-upload.js"></script>
<script>
$('input[type=file]').bootstrapFileInput();
$('.file-inputs').bootstrapFileInput();
</script>
<!--<script src='<?=base_url();?>assets/dart/build/web/upload_handling.dart.js'></script>
<script type='application/dart' src='<?=base_url();?>assets/dart/build/web/packages/browser/dart.js'></script>-->
<script>
$(document).ready(function() {

    var work = document.getElementById("work");

    $("#upload-button").click(function() {
        
        if(typeof work.value !== undefined && work.value !== null && work.value != "") {
        
            $("#upload-button").fadeOut(100); 
       
        }
        
    });
    
});
</script>