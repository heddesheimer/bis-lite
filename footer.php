<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
  <div class="center">
  <div>
  <?php dynamic_sidebar('sidebar-footer-1') ?>
  </div>

  <div>
  <?php dynamic_sidebar('sidebar-footer-2') ?>
  </div>

  <div>
  <?php dynamic_sidebar('sidebar-footer-3') ?>
  </div>

  <div>
  <?php dynamic_sidebar('sidebar-footer-4') ?>
  </div>
  </div>
  
  <div class="center">
  <p>&copy; Copyright 2012 - BisLite Inc. All rights reserved. Some free icons used here are created by Brankic1979.com.<img class="logo" src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.png" alt="logo" /></p>
  <p>Client Logos are copyright and trademark of the respective owners / companies.</p> 
  
  </div>
  
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>