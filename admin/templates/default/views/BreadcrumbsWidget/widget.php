<?php
/**
 * Breadcrumbs widget template.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */
?>
<ol class="breadcrumb">
    <li><a href="<?php echo $this->controller->createUrl('/base'); ?>"><span class="glyphicon glyphicon-home"></span> <?php echo Yii::t('dashboard','main'); ?></a></li>
    <?php
    $active = array_slice($links,-1,1);
    array_pop($links);
    foreach($links as $title => $link):
    ?>
        <li><a href="<?php echo $link; ?>"><?php echo $title; ?></a></li>
    <?php
    endforeach;
    if (($title = key($active)) != null):
    ?>
        <li class="active"><?php echo $title; ?></li>
    <?php endif; ?>
</ol>