
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Change Password</title>
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

<!--=====================================================================-->
<body>
    <div class="typo_top">
<?php //$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
//$this->breadcrumbs=array(
//	UserModule::t("Login") => array('/user/login'),
//	UserModule::t("Restore"),
//);
//?>

<div class="signin_inner">
    <?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change Password"),
);
?>
    <div class="signin_sec">
<h3><?php echo UserModule::t("Change Password"); ?></h3>
</div>
<hr>

<div class="form">
    <?php
    $myform=$this->beginWidget('CActiveForm', array(
	'id'=>'recovery-form',
	'enableAjaxValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php echo CHtml::beginForm(); ?>

	
	

<!--	<div class="row">-->
	<?php //echo CHtml::activeLabelEx($form,'Password'); ?>
<?php echo $myform->labelEx($form,'Password'); ?>
	<?php //echo CHtml::activePasswordField($form,'password'); ?>
<?php echo $myform->passwordField($form,'password') ?>
                <?php echo $myform->error($form,'password') ?>
	
<!--	</div>-->

<!--	<div class="row">-->
	<?php //echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
<?php echo $myform->labelEx($form,'verifyPassword'); ?>
	<?php //echo CHtml::activePasswordField($form,'verifyPassword'); ?>
<?php echo $myform->passwordField($form,'verifyPassword') ?>
                <?php echo $myform->error($form,'verifyPassword') ?>
<!--	</div>-->


<!--	<div class="row submit">-->
	<?php echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'medium red button radius')); ?>
<!--	</div>-->

<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
</div> <!--form -->

</div>
        </div>
<!--=====================================================-->
<div class="footer_sec">


      <footer>

      <div class="container">
        <p><span class="pull-right">Already a member? <?php  echo CHtml::link('Sign in', array('/user/login'));?> </span> </p>


       </div>
      </footer>
          </div>
</body>
</html>