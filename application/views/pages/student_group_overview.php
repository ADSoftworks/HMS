<div class="panel panel-primary">
  <div class="panel-heading">
      <h3 class="panel-title"><span class="glyphicon glyphicon glyphicon-th-list"></span> Groepen overzicht</h3>
  </div>
  <div class="panel-body">
    
      <!--CONTENT-->
      
      
      <!--<div class="btn-group">-->
        <a href="<?php echo base_url(); ?>index.php/student/logout">
            <button type="button" class="btn btn-primary">
                <span class="glyphicon glyphicon-log-out"></span> Uitloggen
            </button>
        </a>
        <a href="<?php echo base_url(); ?>index.php/student/index/student_settings">
        <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-cog"></span> Instellingen
        </button>
        </a>
<!--        <button type="button" class="btn btn-default">
            
        </button>-->
      <!--</div>-->
      <br/><br/>
      
      <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Word lid van een groep</h3>
  </div>
  <div class="panel-body">
      
      <form method="POST">
      
        <div class="col-lg-6">
            <div class="input-group">
              <input name="param_groupcode" type="text" class="form-control" placeholder="Groepscode" required>
              <span class="input-group-btn">
                <input name="submit_joingroup" class="btn btn-default" type="submit" value="Word lid" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
      
        </form>
        
  </div>
      
      <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Groepen</h3>
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

<strong><h4>Kies een groep</h4></strong>

            <?php
            
            $email = $this->session->userdata("email");
            
            $groups = $this->Group_model->getAllGroupsFromUser($email);
//              die(var_dump($this->Group_model->getAllGroupsFromUser($email)));
            
            if( ! $groups) {
                
                echo "<strong>U maakt geen deel uit van een groep.</strong>";
                
            } else {
            
                foreach($groups as $group) {

                    ?>

                    <a href="<?=base_url()?>/index.php/student/groupprofile/<?=$group['id'];?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?php echo $group["name"]; ?></h4>
                    <p class="list-group-item-text"><?php echo $group["description"]; ?></p>
                    </a>

                    <?php

                }
            
            }
            
            ?>

          </div>
          
    </div>
      
      </div>
</div>
    
      <!--CONTENT END-->
      
      
  </div>
</div>