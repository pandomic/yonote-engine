<div class="panel-heading">
    <h3 class="panel-title">Select language</h3>
</div>
<form role="form" class="form-horizontal">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?php echo CHtml::dropDownList('','en',$this->langsList(),array(
                    'class' => 'form-control'
                )); ?>
            </div>
            <div class="col-md-6">
                <?php echo CHtml::dropDownList('','en',$this->langsList(),array(
                    'class' => 'form-control'
                )); ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>