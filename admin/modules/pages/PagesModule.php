<?php
class PagesModule extends CWebModule
{
    public function init()
    {
        $this->defaultController = 'pages';
        $this->setImport(array(
            'pages.components.*',
            'pages.models.*'
        ));
    }
}
?>