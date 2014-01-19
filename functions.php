<?php
add_action('after_setup_theme', 'setup');
// add_action('after_setup_theme', 'cleanup', 9999);
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

function load_custom_wp_admin_style() {
  wp_register_style( 
    'admin_css', 
    get_stylesheet_directory_uri() . '/admin.css' );
  wp_enqueue_style( 'admin_css' );
}

function my_pre_get_posts( $query ) {
    if ( ! $query->is_main_query() || is_admin() )
        return;

    $option_ary = get_option('theme_options');
    if (is_array($option_ary['special_categories']))
    {
      $exclude = array_values($option_ary['special_categories']);
      $query->set( 'category__not_in', $exclude );
    }

}

function exclude_categories($cat)
{
  $option_ary = get_option('theme_options');
  if (is_array($option_ary['special_categories']))
  {
    $exclude = array_values($option_ary['special_categories']);
    if (!is_admin())
    {
      $cat['exclude'] = $exclude;
    }
  }
  
  // print_r($cat);
  return $cat;
}

function get_clients()
{
  $option_ary = get_option('theme_options');
  $categories = $option_ary['special_categories'];
  
  $clients = get_posts( array(
    'cat' => $categories['Clients'],
    'numberposts' => 6
  ));
  
  foreach($clients as $c)
  {
    echo '<div class="client-box">';
    if (has_post_thumbnail($c->ID, 'client-thumbnail'))
    {
      $image_id = get_post_thumbnail_id($c->ID);
      $image_thumb = wp_get_attachment_image_src($image_id, 'client-thumbnail', true);
      echo '<img class="alignnone" src="'.$image_thumb[0].'" alt="'.$c->post_title.'" />';
    }
    echo '</div>';
  }
}

function get_testimonials()
{
  $option_ary = get_option('theme_options');
  $categories = $option_ary['special_categories'];

  $testimonials = get_posts( array(
    'cat' => $categories['Testimonials'],
    'numberposts' => -1
  ));
  
  echo '<ul>';
  foreach($testimonials as $t)
  {
    echo '<li>';
    echo apply_filters('the_content', $t->post_content);
    echo '</li>'; 
  }
  echo '</ul>';
}

function get_latest_works()
{
  $option_ary = get_option('theme_options');
  $categories = $option_ary['special_categories'];

  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'cat' => $categories['Works'],
  );
  
  $works = new WP_Query($args);
  
  ?>
	<div id="home_carousel">
  <ul>
  <?php
  
  if ($works->have_posts())
  {
    while ($works->have_posts())
    {
      $works->the_post();
      if (has_post_thumbnail())
      {
        ?>
        <li>
        <a href="<?php the_permalink() ?>">
        <?php the_post_thumbnail('home-latest-posts'); ?>
        </a>
        </li>
        <?php
      }
    }
    wp_reset_postdata();
  }
  ?>
  </ul>
  </div>
  <a class="jcarousel-nav jcarousel-prev" href="#">prev</a>
  <a class="jcarousel-nav jcarousel-next" href="#">next</a>  
  <?php  
}

/*
function cleanup()
{
  remove_theme_support('custom-header');
  remove_theme_support('custom-background');

}
*/

function setup()
{
  add_action('admin_menu', 'admin_menu');
  add_action('admin_menu', 'cleanup_admin', 9999);
  add_action( 'pre_get_posts', 'my_pre_get_posts' );
  add_filter('get_terms_args', 'exclude_categories');
  add_action( 'wp_enqueue_scripts', 'my_scripts_styles' );
  add_action( 'wp_enqueue_scripts', 'my_dequeue_styles', 11 );

  add_image_size('client-thumbnail', 150, 80, false);
  add_image_size('home-latest-posts', 220, 160, true);

  add_action('wp_print_scripts', 'insert_scripts');

	register_sidebar( array(
		'name' => __( 'Footer Sidebar1', 'twentytwelve' ),
		'id' => 'sidebar-footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Sidebar2', 'twentytwelve' ),
		'id' => 'sidebar-footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Sidebar3', 'twentytwelve' ),
		'id' => 'sidebar-footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Sidebar4', 'twentytwelve' ),
		'id' => 'sidebar-footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
  
}

function insert_scripts()
{
  wp_register_script('quotes', get_stylesheet_directory_uri() . '/js/jquery.quovolver.js');
  wp_register_script('jcarousel', get_stylesheet_directory_uri() . '/js/jquery.jcarousel.min.js', array('jquery'));
  wp_register_script('custom', get_stylesheet_directory_uri() . '/js/custom.js');
  wp_enqueue_script('jquery');
  wp_enqueue_script('quotes');
  wp_enqueue_script('jcarousel');
  wp_enqueue_script('custom');
  
}


function admin_menu()
{
  add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'theme-options', 'my_theme_options');
}




function cleanup_admin()
{
  // remove_submenu_page('themes.php', 'theme_options');
  remove_submenu_page('themes.php', 'custom-background');
  remove_submenu_page('themes.php', 'custom-header');
  unregister_sidebar('sidebar-2');
  unregister_sidebar('sidebar-3');
}

function my_theme_options()
{
  if (
    (isset($_POST['action'])) && 
    ($_POST['action'] == 'save_options')
    )
  {
    if (check_admin_referer('save_options'))
    {
      //print_r($_POST);
      $option_ary['home_boxes'] = $_POST['home_boxes'];
      // $option_ary['social_links'] = $_POST['social_links'];
      $option_ary['special_categories'] = $_POST['special_categories'];
      update_option('theme_options', $option_ary);
      echo('options saved');
    }
  } else {
    $option_ary = get_option('theme_options');
  }
  
  
  ?>
  <style type="text/css">
  .wrap table input[type="text"] {
    width: 300px;
  }
  </style>
  <div class="wrap">
  <h2>Options</h2>
  <form method="post" action="themes.php?page=theme-options">
  <input type="hidden" name="action" value="save_options" />
  <?php wp_nonce_field('save_options') ?>
  <table>
  
  <?php
  for ($k = 1; $k <= 4; $k++)
  {
  ?>
    <tr><td>
    <label>Home Box<?php echo $k ?>:</label>
    </td><td>
    <select 
      id="home_boxes[<?php echo $k ?>]" 
      name="home_boxes[<?php echo $k ?>]">
      <?php
      $pages = get_pages(); 
      foreach ( $pages as $pagg ) {
      	$option = '<option value="' . $pagg->ID . '"';
        if ($pagg->ID == (int)$option_ary['home_boxes'][$k])
        {
          $option .= ' selected="selected" ';
        }
        $option .= '>';
    	$option .= $pagg->post_name;
    	$option .= '</option>';
    	echo $option;
      }
      ?>
    </select>
    </td></tr>
  <?php    
  }

  $social_links = array();

  $special_categories = &$option_ary['special_categories'];
  if (empty($special_categories['Works']))
  {
    $special_categories['Works'] = 0;
  }
  if (empty($special_categories['Testimonials']))
  {
    $special_categories['Testimonials'] = 0;
  }
  if (empty($special_categories['Clients']))
  {
    $special_categories['Clients'] = 0;
  }
  
  foreach ($special_categories as $title => $value)
  {
  ?>
    <tr><td>
    <label><?php echo $title ?></label>
    </td><td>
    <select 
      id="special_categories[<?php echo $title ?>]" 
      name="special_categories[<?php echo $title ?>]">
      <?php
      $cat = get_categories(); 
      echo '<option value="0">Please select</option>';
      foreach ( $cat as $c ) {
      	$option = '<option value="' . $c->term_id . '"';
        if ($c->term_id == $value)
        {
          $option .= ' selected="selected" ';
        }
        $option .= '>';
    	$option .= $c->cat_name;
    	$option .= '</option>';
    	echo $option;
      }
      ?>
    </select>
    </td></tr>
  <?php
  }
  ?>
  
  <tr><td>&nbsp</td><td>
  <input type="submit" name="submit" value="save">
  </td></tr>
  
  
  </table>
  
  </form>
  </div>
  <?php
}


function get_featured_links($full_page = false)
{
  $option_ary = get_option('theme_options');
  if ($full_page)
  {
  ?>
      <div id="home_categories">
      <?php
      for ($k = 1; $k <= 4; $k++)
      {
        $page_id = $option_ary['home_boxes'][$k];
        $page = get_page($page_id);
        ?>
        <div id="tab_<?php echo $k ?>" <?php if ($k==4) echo ' class="last" '; ?>>
        <h2><a href="<?php echo get_permalink($page->ID) ?>"><?php echo $page->post_title ?></a></h2>
        <?php
        if(has_post_thumbnail($page->ID, 'home-thumbnail'))
        {
          $image_id = get_post_thumbnail_id($page->ID);
          $image_thumb = wp_get_attachment_image_src($image_id, 'home-thumbnail', true);
          echo '<img class="alignleft" src="'.$image_thumb[0].'" alt="'.$page->post_title.'" />';
        }
        echo do_shortcode($page->post_excerpt);
        ?>
        <p><a href="<?php echo get_permalink($page->ID) ?>">Read More</a></p>
        </div>
        <?php 
      }
      ?>

      </div><!-- home_categories -->
      <?php
 }
}

function my_scripts_styles()
{
  global $wp_styles;
	wp_enqueue_style( 'ie_css', get_stylesheet_directory_uri() . '/ie.css');
	$wp_styles->add_data( 'ie_css', 'conditional', 'lt IE 9' );

  wp_dequeue_style('twentytwelve-fonts');
  
  wp_register_script('superfish', get_stylesheet_directory_uri() . '/js/superfish.js');
  wp_register_script('hoverintent', get_stylesheet_directory_uri() . '/js/hoverIntent.js');
  wp_enqueue_script('hoverintent');
  wp_enqueue_script('superfish');
  
}


function my_dequeue_styles() {
  wp_dequeue_style( 'twentytwelve-ie' );
}


?>