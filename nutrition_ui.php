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
  <?php if(!empty($nutrition)) {?>
    var response = <?php echo $nutrition; ?>
    // console.log("Merged: ",jQuery.extend( settings, response ))
    jQuery('#nutrition-label').nutritionLabel(jQuery.extend( settings, response ));

  <?php } else { ?>
    jQuery('#nutrition-label').nutritionLabel()
  <?php } ?>
  code = jQuery.trim(jQuery('#gfb-nut-textarea').text()+jQuery('#nutrition-label').clone().html());
  jQuery('#gfb-nut-textarea').val(code);
  // jQuery('#nutrition-label').clone().appendTo('#gfb-nut-textarea');
});
</script>
