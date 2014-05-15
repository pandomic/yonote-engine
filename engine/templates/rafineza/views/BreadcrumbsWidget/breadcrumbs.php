<?php
/**
 * Breadcrumbs widget template.
 * 
 * $links - array of registered breadcrumbs links.
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