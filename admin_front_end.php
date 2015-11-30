 <?php $serving = get_post_meta($post->ID, 'RECIPE_META_servings', true);?>
<script type="text/javascript">
jQuery( document ).ready(function() {
  var settings = {
    	"showServingUnitQuantity":true,
    	"showPolyFat":true,
    	"showMonoFat":true,
      // "showDisclaimer" : true,
      "showCalorieDiet": true,
      "itemName": "",
      "valueServingUnitQuantity": <?php echo (empty($serving) ? 1 : $serving)?>,
      "ingredientList":<?php echo json_encode(options($ingredients)); ?>
    };
  <?php if(!empty($nutrition)) {?>
    var response = <?php echo $nutrition; ?>;

    try {
      jQuery('#nutrition-label').nutritionLabel(jQuery.extend( settings, JSON.parse(response)));
    } catch(error) {
      console.log(error);
    }

  <?php } else if (!empty($post) && $post->post_type == 'recipe') { ?>
    var response = <?php echo json_encode(get_post_meta($post->ID, META_KEY, true)); ?>;
    if (response.length > 0){
      try {
        jQuery('#nutrition-label').nutritionLabel(jQuery.extend( settings, JSON.parse(response)));
      } catch(error) {
        console.log(error);
      }
    } else {
      jQuery('#nutrition-label').nutritionLabel()
    }

  <?php } else { ?>
    jQuery('#nutrition-label').nutritionLabel()
  <?php } ?>
});
</script>
