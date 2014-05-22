<?php
class PostsModule extends CWebModule
{
    public function init()
    {
        $this->defaultController = 'posts';
        $this->setImport(array(
            'posts.components.*',
            'application.modules.posts.models.*'
        ));
    }
}
?>