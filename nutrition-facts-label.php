<?php
/**
 * @package Nutrition Facts Label Plugin by Global Food Book
 * @version 1.5
 */
/*
Plugin Name: Nutrition Facts Label Plugin
Plugin URI: http://wordpress.org/extend/plugins/nutrition-facts-label/
Description: This plugin is an extract from <a href='http://globalfoodbook.com' target='_blank'>globalfoodbook.com</a>. This plugin generates a nutrition label, providing nutritive insight on ingredients or a recipe's contents.
Author: Ikenna N. Okpala
Version: 1.5
Author URI: http://ikennaokpala.com/
*/

// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    die('You do not have sufficient permissions to access this page');
}
require_once 'process.php';

// Enqueue script and styles
if ( !function_exists( 'gfb_nutrition_label_add_to_head' ) ):
  function gfb_nutrition_label_add_to_head() {
    wp_register_style( 'add-gfb-nutrition-label-sub-css', plugin_dir_url( __FILE__ ) . 'includes/assets/css/nutritionLabel.css','','', 'screen' );

    wp_register_script( 'add-gfb-nutrition-label-sub-js', plugin_dir_url( __FILE__ ) . 'includes/assets/javascript/nutritionLabel.js', '', null, array('jquery'));
    wp_register_script( 'add-gfb-html2canvas-sub-js', plugin_dir_url( __FILE__ ) . 'includes/assets/javascript/html2canvas.js', '', null, '');
    wp_register_script( 'add-gfb-custom-nutrition-label-sub-js', plugin_dir_url( __FILE__ ) . 'includes/assets/javascript/gfb_nutrition_label.js', '', null, '');

    wp_enqueue_style( 'add-gfb-nutrition-label-sub-css' );
    wp_enqueue_script( 'add-gfb-nutrition-label-sub-js' );
    wp_enqueue_script( 'add-gfb-html2canvas-sub-js' );
    wp_enqueue_script( 'add-gfb-custom-nutrition-label-sub-js' );
  }
endif;

add_action('admin_head', 'gfb_nutrition_label_add_to_head');
add_action( 'wp_enqueue_scripts', 'gfb_nutrition_label_add_to_head' );

function gfb_nutrition_label_add_jquery_ui_to_head(){
  wp_register_style( 'add-gfb-nutrition-label-jui-css', plugin_dir_url(__FILE__) . 'includes/assets/css/jquery-ui-1.7.2.custom.css','','', 'screen');
  wp_register_script( 'add-gfb-jui-progress-bar-js',plugin_dir_url( __FILE__ ) . 'includes/assets/javascript/jquery.ui.progressbar.min.js', '', null, array('jquery-ui-core'));

  wp_enqueue_style( 'add-gfb-nutrition-label-jui-css' );
  wp_enqueue_script( 'add-gfb-jui-progress-bar-js' );
}

add_action( 'admin_enqueue_scripts', 'gfb_nutrition_label_add_jquery_ui_to_head' );

// Hook for adding admin menus
add_action('admin_menu', 'nutrition_facts_label_pages');

// action function for above hook
function nutrition_facts_label_pages() {
  // Add a new top-level menu:
  add_menu_page(__('Nutrition Facts Label by Global Food Book','menu-gfb-nutrition-label'), __('Nutrition Label','menu-gfb-nutrition-label'), 'manage_options', 'gfb-nutrition-label-settings', 'nutrition_facts_label_form_view' );

  if(is_admin()) {
    add_submenu_page( 'gfb-nutrition-label-settings', 'Update Recipes', 'Update Recipes', 'manage_options', 'gfb-nutrition-label-settings-1', 'nutrition_facts_label_update_recipes');
  }
}

// nutrition_facts_label_form_view() displays the page content for the custom Nutrition Label menu
function nutrition_facts_label_form_view() { ?>
  <h1 id="nutritiona-facts-label-main-title">
    <?php
      echo __('Nutrition Facts Label Generator', 'menu-gfb-nutrition-label');
      echo beta_img();
    ?>
  </h1>
  <?php
    require_once 'form.php';
}

function nutrition_facts_label_update_recipes() { ?>
  <h1 id="nutritiona-facts-label-main-title">
  <?php
    echo __('Update Recipes', 'menu-gfb-nutrition-label-1');
    echo beta_img();
  ?>
  </h1>
  <?php
    require_once 'update_recipes.php';
}

function nutrition_facts_label_generator_sc(){
  gfb_nutrition_label_add_to_head();
  require_once 'form.php';
}

function embed_nutrition_label_sc(){
   gfb_nutrition_label_add_to_head();
   global $post;?>
   <div class="print-only" style="width: 50%; display: block; float: right; position: relative;">
    	<div id="gfb-nutritional-embed-label" class="nutritional">
        <div id="nutrition-label-outer">
          <div id="nutrition-label"> </div>
        </div>
    		<?php
          $ingredients = implode(PHP_EOL, get_post_meta($post->ID, 'RECIPE_META_ingredients')[0]);
          $nutrition = get_post_meta($post->ID, META_KEY)[0];
        ?>
    	</div>
      <p id="gfb-nutrition-label-msg" style="font-weight: bold;">THE NUTRITION FACTS HERE ARE INDICATIVE.</p>
    </div>
<?php
  require_once 'front_end.php';
}

function beta_img(){
  return "<img src=".plugin_dir_url( __FILE__ ) .'includes/assets/images/beta.png'." />";
}

add_shortcode('nutrition_facts_label_generator', 'nutrition_facts_label_generator_sc');
add_shortcode('embed_nutrition_label', 'embed_nutrition_label_sc');

require_once 'meta_box.php';
?>
