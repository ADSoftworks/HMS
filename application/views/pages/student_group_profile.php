<!--TINYMCE-->

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>

<!--TINYMCE END-->

<div class="panel panel-primary">
  
  <div class="panel-heading">
    <h3 class="panel-title">Groep profiel: <?=$group["name"];?></h3>
  </div>
    
  <div class="panel-body">

      <a href="<?=base_url();?>index.php/student">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Terug
      </button>
      </a>
      
      <!--
      
      Do students get group settings?
      I don't think they do.. 
      
      .__.
      
      -->
      
<!--      <a href="<?=base_url();?>index.php/docent/groupsettings/<?=$group["id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-cog"></span> Groep instellingen
      </button>
      </a>-->
      
      <br/><br/>
    
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Actieve opdrachten voor deze groep</h3>
        </div>
        <div class="panel-body">
          
            <div class="col-lg-6">
            
             <?php
            
//            die(var_dump($group));
             
            /*
             * @TODO: make line below work and make it so that you can quickly see the status of an assignment.
             */
//            $homework = $this->Homework_model->getHomeworkFromGroupIdAndUserId();
            $assignments = $this->Assignment_model->getAllAssignmentsFromGroupById($group["id"]);
             
            if( ! $assignments) {
                
                echo "<strong>Er zijn geen opdrachten in deze groep.</strong>";
                
            } else {
            
                
                foreach($assignments as $assignment) {

                    ?>

                    <a href="<?=base_url();?>index.php/student/assignmentprofile/<?=$assignment["id"];?>" class="list-group-item">
                    <h4 class="list-group-item-heading lead"><?=$assignment["title"];?></h4>
                    <p class="list-group-item-text"><?=$assignment["description"];?></p>
                    
                    <?php 
                    
                    $me = $this->User_model->getIdByEmail($this->session->userdata("email"));
                    $homework = $this->Homework_model->getHomeworkByAssignmentIdAndUserId($assignment["id"], $me);
                            
                    ?>
                    
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
                    </a>

                    <?php

                }
            
            }
            
            ?>
            </div>
        </div>
      </div>
      
    </div>
    <!--panel body end-->
      
</div>