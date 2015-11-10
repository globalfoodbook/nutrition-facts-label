<?php
add_action( 'add_meta_boxes', 'add_nutrition_label_meta_box' );

function add_nutrition_label_meta_box() {
  add_meta_box( 'gfb-meta-box-', 'Nutrition Facts Label Generator', 'gfb_nutrition_label_meta_box', 'recipe', 'normal', 'high' );
}
function gfb_nutrition_label_meta_box(){
  gfb_nutrition_label_add_to_head();
  require_once 'form.php';
}

?>
