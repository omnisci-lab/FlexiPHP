<?php if(!defined('VALID_REQUEST')) die(); ?>

<div>
    <p>Đang thử nghiệm</p>
    <p><?php echo 'Peak RAM: ' . round(memory_get_peak_usage() / 1048576, 2) . ' MB'; ?></p>
</div>