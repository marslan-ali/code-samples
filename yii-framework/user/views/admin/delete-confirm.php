<div>
    <div>
<?php echo CHtml::beginForm(array('/user/admin/delete/'),'post'); ?>
<h3>Are you sure want to delete?</h3>

<?php echo CHtml::hiddenField('id',$id) ;?>
<?php echo CHtml::submitButton('Yes', array( 'class' => 'btn btn-primary')); ?>
<?php echo CHtml::endForm(); ?>
</div>
    <div>
<?php echo CHtml::beginForm(array('/user/admin/'),'post'); ?>
<?php echo CHtml::submitButton('No', array('class'=>'btn btn-warning')); ?>
<?php echo CHtml::endForm(); ?>
</div>
</div>