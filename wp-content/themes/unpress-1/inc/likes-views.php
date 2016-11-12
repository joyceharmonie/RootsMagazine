<?php global $ft_option; ?>

<div class="post-popularity">
    
    <?php if($ft_option['single_views'] != 0 ) { ?>
    <i class="fa fa-eye"></i> <?php echo fave_getPostViews(get_the_ID()); ?> |
    <?php } ?>

    <?php if($ft_option['single_likes'] != 0 ) { ?>
    <?php if( function_exists('totalLikes') ) echo totalLikes(get_the_ID()); ?>
    <?php } ?>

</div>