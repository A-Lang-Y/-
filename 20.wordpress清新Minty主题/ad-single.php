<?php
$ad = !( minty_is_wap() || minty_is_mobile() ) ? get_option( 'minty_ad_single' ) : get_option( 'minty_mobile_ad_single' );
if (!empty($ad)) :
?>

<div class="ga" itemscope itemtype="http://schema.org/WPAdBlock"><?php echo stripslashes($ad); ?></div>

<?php endif; ?>