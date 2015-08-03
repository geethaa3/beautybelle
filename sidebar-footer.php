<<<<<<< HEAD
<?php

/* 
* Footer widgets 
*/ 

if ( ! is_active_sidebar('sidebar-2')) { 
			return; 
}
?>

<div id="supplementary">
	<div id="footer-widgets" class="footer-widgets widget-area clear" role="complementary"> 
		<?php dynamic_sidebar('sidebar-2'); ?> 
	</div><!-- #footer-sidebar --> 
=======
<?php

/* 
* Footer widgets 
*/ 

// This is a conditional statement that states that the footer widget area will only appear if it is active (i,.e. if there are widgets placed in it), otherwise it will not appear. 
if ( ! is_active_sidebar('sidebar-2')) { 
			return; 
}
?>

<div id="supplementary">
	<div id="footer-widgets" class="footer-widgets widget-area clear" role="complementary"> 
		<?php dynamic_sidebar('sidebar-2'); ?> 
	</div><!-- #footer-sidebar --> 
>>>>>>> origin/master
</div><!-- #supplementary --> 