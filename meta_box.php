<?php
add_action( 'add_meta_boxes', 'add_nutrition_label_meta_box' );

function add_nutrition_label_meta_box() {
  $title = "Nutrition Facts Label Generator ". beta_img();
  add_meta_box( 'gfb-meta-box-', $title, 'gfb_nutrition_label_meta_box', 'recipe', 'normal', 'high' );
}
function gfb_nutrition_label_meta_box(){?>
  <style>
    .gfb-nutrition-label-section {
      padding-top: 0!important;
    }
  </style>
  <?php
    $hidden = "style='display:none'";
    gfb_nutrition_label_add_to_head();
    require_once 'form.php';
}
?>
