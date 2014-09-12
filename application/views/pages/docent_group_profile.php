<!--TINYMCE-->

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>

<!--TINYMCE END-->

<div class="panel panel-primary">
  
  <div class="panel-heading">
    <h3 class="panel-title">Group profile: <?=$group["name"];?></h3>
  </div>
    
  <div class="panel-body">

      <a href="<?=base_url();?>index.php/docent">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
      </button>
      </a>
      
      <a href="<?=base_url();?>index.php/docent/groupsettings/<?=$group["id"];?>">
      <button type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-cog"></span> Group settings
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
          <h3 class="panel-title">Group members</h3>
        </div>
        <div class="panel-body">
            
            <?php if($members): ?>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Email address</th>
                    <th>Remove from group</th>
                </tr>
                <?php foreach($members as $member): ?>
                <tr>
                    <td>
                        <?php $user = $this->User_model->getUserById($member); ?>
                        <?=$user["firstname"];?> <?=$user["lastname"];?>
                    </td>
                    <td>
                        <?=$user["email"];?>
                    </td>
                    <td>
                        <a href="<?=base_url();?>index.php/docent/deletestudentfromgroup/<?=$group["id"];?>/<?=$user["id"];?>">
                        <button type="button" class="btn btn-primary">Remove from group</button>
                        </a>
                    </td>
                    
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
            
            There are no students a part of this group.
            
            <?php endif; ?>
            
        </div>
      </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Create assignment</h3>
        </div>
        <div class="panel-body">
          
            <form method="POST">
                
                <div class="input-group col-md-6">
                    <span class="input-group-addon">Abc</span>
                    <input name="param_title" type="text" class="form-control" placeholder="Assignment title" required>
                </div>

                <br/>

                <div class="input-group col-md-6">
                    <textarea name="param_description"
                              style="height:200px;resize:vertical;" 
                              type="text" 
                              class="form-control" 
                              placeholder="Assignment description"
                              required>Assignment description</textarea>
                </div>

                <br/>

                <div class="btn-group">
                    <input name="submit_create_assignment" type="submit" 
                           class="btn btn-primary" value="Create assignment" />
                  </div>
            
            </form>
            
        </div>
    </div>
    
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Active assignments for this group.</h3>
        </div>
        <div class="panel-body">
          
            <div class="col-lg-6">
            
             <?php
            
//            die(var_dump($group));
             
            $assignments = $this->Assignment_model->getAllAssignmentsFromGroupById($group["id"]);
             
            if( ! $assignments) {
                
                echo "<strong>There are no assignments for this group.</strong>";
                
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