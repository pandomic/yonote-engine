<?php Yii::import('admin.modules.loadmeter.LoadMeterModule'); ?>

<div class="cpu-chart hidden-sm hidden-xs" data-percent="<?php echo $average; ?>">
    <div class="cpu-chart-percent text-muted"><?php echo $average; ?></div>
    <div class="text-center"><?php echo Yii::t('LoadMeterModule.widget','label.load.average'); ?></div>
</div>


<div class="loading-chart hidden-sm hidden-xs">
    <div class="clearfix">
        <div class="progress pull-left">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $memory; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $memory; ?>%;"></div>
        </div>
        <div class="pull-right text-muted clearfix">
            <?php echo $memory; ?>%
        </div>
    </div>
    <div class="text-center"><?php echo Yii::t('LoadMeterModule.widget','label.load.memory'); ?></div>
</div>

<div class="loading-chart hidden-sm hidden-xs">
    <div class="clearfix">
        <div class="progress pull-left">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $disk; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $disk; ?>%;"></div>
        </div>
        <div class="pull-right text-muted ">
            <?php echo $disk; ?>%
        </div>
    </div>
    <div class="text-center"><?php echo Yii::t('LoadMeterModule.widget','label.load.disk'); ?></div>
</div>

<script>
$(function() {
    $('.cpu-chart').easyPieChart({
        animate: false,
        lineWidth: 13,
        lineCap: 'square',
        barColor: '#5cb85c',
        trackColor: '#2e3641',
        scaleColor: '#2e3641',
        size: '140'
    });
});
</script>