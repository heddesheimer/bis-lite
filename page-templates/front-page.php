<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content"> 
		<div id="content" role="main">

    <div id="hero">
    <div>
    <?php if ( function_exists( 'meteor_slideshow' ) ) { 
      meteor_slideshow('home-slides'); 
    } ?>
    </div>
    </div>
    
    <div id="teaser">
    <?php get_featured_links(true) ?>
    <div class="clear"></div>
    </div>
    
    <div id="home_content">
    <div id="news">
    <h3>Latest Works</h3>
    <?php get_latest_works() ?>
    </div>

    <div>
    <div id="testimonials">
    <h4 class="title">Testimonials</h4>
    <?php get_testimonials() ?>
    </div>
    
    <div id="clients">
    <h4 class="title">Our Clients</h4>
    <?php get_clients() ?>
    </div>
    </div>
    
    <div id="download">
    <p>This is a clean and modern, four column website PSD template. You can code it into a Wordpress website, HTML5 responsive website for your personal or client works. So ahead and download this wonderful PSD template!
    </p>
    <a class="buttonlink" href="#">Download PSD</a>
    <div class="clearfix"></div>
    </div>
    
    </div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>