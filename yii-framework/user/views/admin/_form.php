<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>neet - Register </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.css" />
    <!-- Le styles -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/neet.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.css" rel="stylesheet">


<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap-responsive.css" rel="stylesheet">




    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->theme->baseUrl; ?>/../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>


         <div class="typo_top">

         <div class="signin_sec">

         <h2>Registration</h2>


         </div>

        <div class="signin_inner">
 
<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
            <?php //echo CHtml::errorSummary(array($model,$profile)); ?>
            
            <?php echo CHtml::activeTextField($model,'username',array('placeholder'=>'Username', 'class'=>'span3')); ?>
            <?php echo CHtml::error($model,'username'); ?>
            <?php echo CHtml::activePasswordField($model,'password',array('placeholder'=>'password', 'class'=>'span3')); ?>
            <?php echo CHtml::error($model,'password'); ?>
            <?php echo CHtml::activeTextField($model,'email',array('placeholder'=>'email', 'class'=>'span3')); ?>
            <?php echo CHtml::error($model,'email'); ?>
            <?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
            <?php echo CHtml::error($model,'superuser'); ?>
            <?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus')); ?>
            <?php echo CHtml::error($model,'status'); ?>

              <?php
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
	?>
	
		
		<?php
		if ($field->widgetEdit($profile)) {
			echo $field->widgetEdit($profile);
		} elseif ($field->range) {
			echo CHtml::activeDropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50,'placeholder'=>$field->varname));
		} else {
			echo CHtml::activeTextField($profile,$field->varname,array('maxlength'=>(($field->field_size)?$field->field_size:255),'placeholder'=>$field->varname));
		}
		 ?>
		<?php echo CHtml::error($profile,$field->varname); ?>
	
			<?php
			}
		}
?>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'medium blue button radius')); ?>
<?php echo CHtml::endForm(); ?>

       <hr>
       <p><span class="pull-right">Already a member? <a href="signin.htm">Sign in</a></span></p>

        </div>

        </div>

<!--       <div class="sec_3">
    <div class="container">





     <div class="row">
    <div class="span4">
  <ul class="thumbnails">


        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_7.jpg" alt="">
          </a>
        </li>
        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_6.jpg" alt="">
          </a>
        </li>
      </ul>
    </div>
    <div class="span4">
<ul class="thumbnails">


        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_5.jpg" alt="">
          </a>
        </li>
        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_4.jpg" alt="">
          </a>
        </li>
      </ul>    </div>
    <div class="span4">
<ul class="thumbnails">


        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_3.jpg" alt="">
          </a>
        </li>
        <li class="span2">
          <a href="#" class="thumbnail">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/img/thumb_si_2.jpg" alt="">
          </a>
        </li>
      </ul>    </div>
  </div>










       <div class="page-header">
    <h2 style="color:grey; font-weight:200;">THE PEOPLE BEHIND THIS PROJECT <small>and their playground. </small></h2>
  </div>

 </div>


       Main hero unit for a primary marketing message or call to action 

    </div>-->


  <div class="footer_sec">


      <footer>

      <div class="container">
        <p>&copy; 2012 Neet - Minimalist Template<span class="pull-right">Already a member? <a href="signin.htm">Sign in &raquo;</a></span> </p>


       </div>
      </footer>



          </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

      <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/bootstrap.js" type="text/javascript"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>

     <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.gallery.js" type="text/javascript"></script>
 <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/modernizr.custom.53451.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function() {
        $('#dg-container').gallery();
      });
    </script/>

  </body>
</html>