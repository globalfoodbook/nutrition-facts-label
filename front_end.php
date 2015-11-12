<script type="text/javascript">
jQuery( document ).ready(function() {
  var settings = {
    	"showServingUnitQuantity":true,
    	"showPolyFat":true,
    	"showMonoFat":true,
      // "showDisclaimer" : true,
      "itemName": "",
      "ingredientList":<?php echo json_encode(options($ingredients)); ?>
    };
    <?php if (!empty($post) && $post->post_type == 'recipe') { ?>
    var response = <?php echo json_encode(get_post_meta($post->ID, META_KEY, true)); ?>;
    if (response.length > 0){
      try {
        jQuery('#nutrition-label').nutritionLabel(jQuery.extend( settings, JSON.parse(response)));
      } catch(error) {
        console.log(error);
      }
    }

  <?php }  ?>
});
</script>
