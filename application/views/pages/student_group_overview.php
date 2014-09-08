<div class="panel panel-primary">
  <div class="panel-heading">
      <h3 class="panel-title"><span class="glyphicon glyphicon glyphicon-th-list"></span> Group overview</h3>
  </div>
  <div class="panel-body">
    
      <!--CONTENT-->
      
      
      <!--<div class="btn-group">-->
        <a href="<?php echo base_url(); ?>index.php/student/logout">
            <button type="button" class="btn btn-primary">
                <span class="glyphicon glyphicon-log-out"></span> Logout
            </button>
        </a>
        <a href="<?php echo base_url(); ?>index.php/student/index/student_settings">
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
    <h3 class="panel-title">Become a member of a group</h3>
  </div>
  <div class="panel-body">
      
      <form method="POST">
      
        <div class="col-lg-6">
            <div class="input-group">
              <input name="param_groupcode" type="text" class="form-control" placeholder="Groupcode" required>
              <span class="input-group-btn">
                <input name="submit_joingroup" class="btn btn-default" type="submit" value="Join" />
              </span>
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
      
        </form>
        
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

<strong><h4>Choose a group</h4></strong>

            <?php
            
            $email = $this->session->userdata("email");
            
            $groups = $this->Group_model->getAllGroupsFromUser($email);
//              die(var_dump($this->Group_model->getAllGroupsFromUser($email)));
            
            if( ! $groups) {
                
                echo "<strong>You are not a part of any group.</strong>";
                
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