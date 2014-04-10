<ol class="breadcrumb">
    <li><a href="/admin/base"><span class="glyphicon glyphicon-home"></span> Рабочий стол</a></li>
    <?php
    $active = array_pop($links);
    foreach($links as $link):
    ?>
        <li><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></li>
    <?php
    endforeach;
    if ($active!==null):
    ?>
        <li class="active"><?php echo $active['title']; ?></li>
    <?php endif; ?>
</ol>