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

      <a href="<?=base_url();?>index.php/docent">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Terug
      </button>
      </a>
      
      <a href="<?=base_url();?>index.php/docent/groupsettings/<?=$group["id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-cog"></span> Groep instellingen
      </button>
      </a>
      
      <br/><br/>
    
<!--      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Verwijder student uit groep</h3>
        </div>
        <div class="panel-body">
          
            <form method="POST">
            
            <div class="input-group col-lg-6">
                <span class="input-group-addon">@</span>
                <input name="param_email" type="text" class="form-control" placeholder="Email adres">
              </div>
            
          <br/>
          
          <div class="btn-group">
            <input name="removestudent_submit" type="submit" class="btn btn-primary" value="Verwijder student uit groep" />
        </div>
          
          </form>
        
        </div>  
          
      </div>-->
      
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Groep leden</h3>
        </div>
        <div class="panel-body">
            
            <?php if($members): ?>
            <table class="table">
                <tr>
                    <th>Email</th>
                    <th>Verwijder uit groep</th>
                </tr>
                <?php foreach($members as $member): ?>
                <tr>
                    <td>
                        <?php $user = $this->User_model->getUserById($member); ?>
                        <?=$user["email"];?>
                    </td>
                    <td>
                        <a href="<?=base_url();?>index.php/docent/deletestudentfromgroup/<?=$group["id"];?>/<?=$user["id"];?>">
                        <button type="button" class="btn btn-primary">Verwijder uit groep</button>
                        </a>
                    </td>
                    
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            
            Er zijn geen studenten lid van deze groep.
            
            <?php endif; ?>
            
        </div>
      </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Opdracht aanmaken</h3>
        </div>
        <div class="panel-body">
          
            <form method="POST">
                
                <div class="input-group col-md-6">
                    <span class="input-group-addon">Abc</span>
                    <input name="param_title" type="text" class="form-control" placeholder="Opdracht titel" required>
                </div>

                <br/>

                <div class="input-group col-md-6">
                    <textarea name="param_description"
                              style="height:200px;resize:vertical;" 
                              type="text" 
                              class="form-control" 
                              placeholder="Opdracht beschrijving"
                              required>Opdracht beschrijving</textarea>
                </div>

                <br/>

                <div class="btn-group">
                    <input name="submit_create_assignment" type="submit" 
                           class="btn btn-primary" value="Maak opdracht aan" />
                  </div>
            
            </form>
            
        </div>
    </div>
    
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Actieve opdrachten voor deze groep</h3>
        </div>
        <div class="panel-body">
          
            <div class="col-lg-6">
            
             <?php
            
//            die(var_dump($group));
             
            $assignments = $this->Assignment_model->getAllAssignmentsFromGroupById($group["id"]);
             
            if( ! $assignments) {
                
                echo "<strong>Er zijn geen opdrachten in deze groep.</strong>";
                
            } else {
            
                
                foreach($assignments as $assignment) {

                    ?>

                    <a href="<?=base_url();?>index.php/docent/assignmentprofile/<?=$assignment["id"];?>" class="list-group-item">
                    <h4 class="list-group-item-heading lead"><?=$assignment["title"];?></h4>
                    <p class="list-group-item-text"><?=$assignment["description"];?></p>
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