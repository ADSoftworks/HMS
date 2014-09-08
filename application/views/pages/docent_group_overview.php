<div class="panel panel-primary">
  <div class="panel-heading">
      <h3 class="panel-title"><span class="glyphicon glyphicon glyphicon-th-list"></span> Group overview</h3>
  </div>
  <div class="panel-body">
    
      <!--CONTENT-->
      
      
      <!--<div class="btn-group">-->
        <a href="<?=base_url();?>index.php/docent/logout">
            <button type="button" class="btn btn-primary">
                <span class="glyphicon glyphicon-log-out"></span> Logout
            </button>
        </a>
        <a href="<?=base_url();?>index.php/docent/index/docent_settings">
        <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-cog"></span> Settings
        </button>
        </a>
<!--        <button type="button" class="btn btn-default">
            
        </button>-->
      <!--</div>-->
      <br/><br/>
      
      
      <div class="panel panel-primary">
          
            <div class="panel-heading">
              <h3 class="panel-title">Create group</h3>
            </div>
            <div class="panel-body">
              
                <form method="POST">
                
                    <div class="col-lg-6">

                        <div class="input-group">
                        <span class="input-group-addon">Abc</span>
                        <input name="param_groep_name" type="text" class="form-control" 
                               placeholder="Groep naam" required>
                        </div>
                        <br/>
                        <div class="input-group">
                            <span class="input-group-addon">Abc</span>
                            <textarea name="param_groep_description" class="form-control" 
                                      placeholder="Korte beschrijving" required></textarea>
                        </div>
                        <br/>
                        <input name="submit_groep" type="submit" class="btn btn-primary" value="Create group" />

                    </div>
                    
                </form>
               
                
            </div>
          </div>
      
      <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Groups</h3>
  </div>
  <div class="panel-body">  
      
      <div class="col-lg-6">
      
        <div class="list-group">
<!--            
                TEMPLATE

                <a href="#" class="list-group-item">
              <h4 class="list-group-item-heading">AO2A - Rekenen</h4>
              <p class="list-group-item-text">Groep rekenen taalblokken</p>
            </a>

            TEMPLATE
-->

            <strong><h4>Choose a group to work with</h4></strong>

            <?php
            
            $groups = $this->Group_model->getAllAuthoredGroupsFromUser();
            
            if( ! $groups) {
                
                echo "<strong>You are not a part of a group.</strong>";
                
            } else {
            
                
                foreach($groups as $group) {

                    ?>

                    <a href="<?=base_url();?>index.php/docent/groupprofile/<?=$group["id"];?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?=$group["name"];?> - <span class="label label-primary"><?=$group["code"];?></span></h4>
                    <p class="list-group-item-text"><?=$group["description"];?></p>
                    </a>

                    <?php

                }
            
            }
            
            ?>

          </div>
          
    </div
    
    </div>
</div>
      
      <!--CONTENT END-->
      
      
  </div>
</div>