<?php
class ModulesWidget extends CWidget
{
    public function init()
    {
        $models = Module::model()->findAll('installed=1');
        $this->render('widget',array(
            'models' => $models
        ));
    }
}
?>