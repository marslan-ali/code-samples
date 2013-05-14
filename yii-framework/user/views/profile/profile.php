<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">



        <!-- LOAD CSS ASSETS -->


        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.css" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/neet.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap-responsive.css" rel="stylesheet">


        <!-- LOAD GOOGLE WEBFONTS -->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,300,400,600,700' rel='stylesheet' type='text/css'>



        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
       <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
       <![endif]-->



    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>



          <!-- START NAVBAR -->



    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <?php echo CHtml::link('Profile', array('/user/profile'),array('class'=>'brand'));?>
          <div class="nav-collapse">


            <ul class="nav pull-right">
                <li><?php echo CHtml::link('Home', array('/user'));?></li>
              <li><a href="plans.htm">My Photos</a></li>
              <li><a href="tour.htm">Browse Photos</a></li>
              <li><a href="contact.htm">Browse Users</a></li>
              <li><a href="contact.htm">Send Message</a></li>
              <?php if(empty($user)) :?>  
                <li><?php echo CHtml::link('Logout?',array('/user/logout')); ?>
              <?php else: ?>
                <?php    
                    $facebook = new Facebook(array(
                      'appId'  => APP_ID,
                      'secret' => APP_SECRET,
                    ));
                ?>
                <li><?php echo CHtml::link('Facebook Logout?',$facebook->getLogoutUrl(array('next'=>$this->createAbsoluteUrl('/user/logout')))); ?>    
              <?php endif; ?>      
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>




     <!-- END NAVBAR -->


     <!-- START TOP SECTION -->


<!--       <div class="typo_top">
          <hr>-->

       <!-- <div class="container">
                <div class="row">
     <div class="span8">   <h1>Talk to us. we'd like to hear from you.</h1>
        <br>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>


     <p style="padding:30px;"><a href="#" class="large white button radius">Schedule a visit </a></p>

     </div>

      <div class="span4">

     <div style="padding-top:25px;">  <ul class="thumbnails">

        <li class="span4">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_c_1.jpg" alt="">
          </a>
        </li>


      </ul> </div>

     </div>
     </div>
            
     </div> 
     </div>-->

     <!-- END TOP SECTION -->



     <!-- START MAIN SECTION -->

      <div class="sec_3">
      <div class="container">

 <div class="row">
  <div class="span6">

<!--    <div style="font-size: 18px;">
  <i class="icon-envelope-alt"></i> Contact our dream team today.
</div>
<br>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
-->


    <?php if($scope == 'public'): ?>
        <?php $this->renderPartial('//message/default/create',array('model'=>$message)); ?>
    <?php endif; ?>
    

             
    <div class="contact_form">
<!--   <form>
        <input type="text" class="span5" placeholder="Name">
        <input type="text"  class="span5" placeholder="Email">
        <input type="text"  class="span5" placeholder="Name">
        <textarea class="input-xlarge span5" placeholder="Message"   id="textarea" rows="6"></textarea>

<a href="#" class="medium blue button radius">Send </a>
   </form>-->
<!--  profile      -->
<?php //$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
//$this->breadcrumbs=array(
//	UserModule::t("Profile"),
//);
//?>
          <h2><?php echo UserModule::t('Your profile'); ?></h2>
          <hr>
          <?php //echo $this->renderPartial('menu'); ?>
          <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
          <div class="success"> <?php echo Yii::app()->user->getFlash('profileMessage'); ?> </div>
          <?php endif; ?>
          <div class="p_wraper">
          <div class="p_photo">
           <img src="<?php echo Yii::app()->baseUrl."/".$profile->photo; ?>" width="150" height="150" >
          </div>
          <div class="p_sub_wraper">
            <div class="p_about">
              <div class="p_name"> <?php echo CHtml::encode($model->getAttributeLabel('username')); ?> </div>
              <div class="p_detail"> <?php echo CHtml::encode($model->username); ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"> First Name </div>
              <div class="p_detail"> <?php echo $profile->firstname; ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name">Last Name </div>
              <div class="p_detail"> <?php echo $profile->lastname; ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"> Birthday </div>
              <div class="p_detail"> <?php echo $profile->birthday; ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"> Headline </div>
              <div class="p_detail"> <?php echo $profile->headline; ?></div>
            </div>
            <div class="p_about">
              <div class="p_name"> AboutMe </div>
              <div class="p_detail"><?php echo $profile->aboutme; ?> </div>
            </div>
           
           
            <div class="p_about">
              <div class="p_name">Photo Description</div>
              <div class="p_detail"> <?php echo $profile->photo_description; ?> </div>
            </div>
            </div>
            
            <div class="p_about">
              <div class="p_name_1">Video</div>
              <div class="p_detail_1"> 
            <iframe width="100%" height="260" src="<?php echo $profile->videolink; ?>" frameborder="0" allowfullscreen></iframe> </div>
              
            </div>
            <div class="p_about">
              <div class="p_name">Video Description</div>
              <div class="p_detail"> <?php echo $profile->video_description; ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></div>
              <div class="p_detail"><?php echo CHtml::encode($model->email); ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"><?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?></div>
              <div class="p_detail"> <?php echo date("d.m.Y H:i:s",$model->createtime); ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?></div>
              <div class="p_detail"> <?php echo date("d.m.Y H:i:s",$model->lastvisit); ?> </div>
            </div>
            <div class="p_about">
              <div class="p_name"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></div>
              <div class="p_detail"> <?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status));?> </div>
            </div>
          
          </div>
          
          <!-- profile end --> 
          
        </div>
        
        <!--   <ul class="thumbnails">

        <li class="span6">
          <a href="#" class="thumbnail">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_c_2.jpg" alt="">
          </a>
        </li>


      </ul>-->


<!--      <div style="font-size: 18px;">
   Come visit us in the big apple.
</div>    <br>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>-->

      </div>
     <!--
  <div class="span6">


   <div><img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/map.png" alt=""/></div>





      <ul class="thumbnails">
        <li class="span4">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_1.jpg" alt="">
          </a>
        </li>
        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="assets/img/thumb_si_2.jpg" alt="">
          </a>
        </li>
        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_5.jpg" alt="">
          </a>
        </li>


      </ul>

       <div class="well">
      <div style="font-size: 24px;">
       <a href="#">   <i class="icon-facebook-sign"></i> Facebook</a>
        <br>

      </div>
    </div>
     <div class="well">
      <div style="font-size: 24px;">
     <a href="#">   <i class=" icon-twitter-sign"></i> Twitter </a>
        <br>

      </div>
    </div>

      <div class="well">
      <div style="font-size: 24px;">
     <a href="#">   <i class=" icon-google-plus-sign"></i> Google+</a>
        <br>

      </div>
    </div>

      <div class="well">
      <div style="font-size: 24px;">
        <i class=" icon-phone-sign"></i> 1-888-222-3333
        <br>

      </div>
    </div>

         <div class="well">
      <div style="font-size: 24px;">
        <i class="icon-map-marker"></i> 123 Sample St, New York. 12345
        <br>

      </div>
    </div>


    </div>
     -->
</div>
 </div>
      </div>
      </div>

    <!-- END MAIN SECTION -->


   <!-- START FOOTER SECTION -->

    <div class="footer_sec">


      <footer>

      <div class="container">
        <p>&copy; 2012 Neet - Minimalist Template<span class="pull-right">Already a member? <?php echo CHtml::link('Forgot?',array('recovery/recovery')); ?><a href="signin.htm">Sign in &raquo;</a></span> </p>


       </div>
      </footer>

        </div>

        <!-- END FOOTER SECTION -->



  </body>
</html>