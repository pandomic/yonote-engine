<?php
class TestModule extends CWebModule
{
    public function init(){
        $this->controllerPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'components/controllers';
        parent::init();
    }
}
?>