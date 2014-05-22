<?php
return array(
    'posts' => 'posts/posts',
    'post/<id:[a-z0-9\-]+>.html' => 'posts/posts/show',
    'post/<hashtag:[a-z0-9\-_]>' => 'posts/posts/tag'
);
?>