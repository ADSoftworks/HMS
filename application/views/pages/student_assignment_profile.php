<?php // die(var_dump($homework)); ?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Opdracht profiel</h3>
  </div>
  <div class="panel-body">
    
      <a href="<?=base_url();?>index.php/student/groupprofile/<?=$assignment["group_id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Terug
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
                      <span>Voldoende!</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($homework["status"] == "pending"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Wachten op goedkeuring</span>
                    </div>
                  </div>

                <?php endif; ?>

                <?php if($homework["status"] == "rejected"): ?>

                <div class="progress">
                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                      <span>Onvoldoende</span>
                    </div>
                  </div>

                <?php endif; ?>

            
            </div>
      </div>
      
            <?php endif; ?>
      
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Opdracht</h3>
        </div>
        <div class="panel-body">
              <p class="lead"><?=$assignment["title"];?></p>
              <?=$assignment["description"];?>
        </div>
    </div>
      
   <?php if( ! $homework): ?>
      
      <?php // if(): ?>
      
    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Opdracht inleveren</h3>
        </div>
        <div class="panel-body">
          
            Selecteer een bestand om te uploaden.<br/><br/>
            
            <form method="POST" enctype="multipart/form-data">
                <input name="homework" class="btn-primary" type="file" title="Huiswerk uploaden" required />
                <br/><br/>
                <input name="submit_homework" class='btn btn-primary' type="submit" value="Huiswerk inleveren" />
            </form>
            
        </div>
      </div>
      
      <?php else: ?>
      
        <a href="<?=base_url()?>/assets/uploads/<?=$homework["file_source"];?>" target="_blank">
        <button class="btn btn-primary">Bekijk huiswerk</button>
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