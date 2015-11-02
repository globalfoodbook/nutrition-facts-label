<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["ingredients"])) {
    $ingredients = $_POST["ingredients"];
    $nutrition = process_request($ingredients);
  //   $nutrition = json_encode(json_decode('{
  //   "PolyFat": 6.883,
  //   "MonoFat": 10.281,
  //   "valueCalories": 1804,
  //   "valueFatCalories": 185.82,
  //   "valueTotalFat": 26.476,
  //   "valueSatFat": 11.5,
  //   "valueTransFat": 0.106,
  //   "valueCholesterol": 335,
  //   "valueSodium": 11399,
  //   "valueTotalCarb": 301.90000000000003,
  //   "valueFibers": 41.7,
  //   "valueSugars": 13.620000000000001,
  //   "valueProteins": 110,
  //   "valueVitaminA": 11760,
  //   "valueVitaminC": 44.7,
  //   "valueCalcium": 1465,
  //   "valueIron": 53.279999999999994,
  //   "valuePotassium": 3770
  // }'));
  }
}

function process_request($ingredients){
  $api = "http://nuts.globalfoodbook.net/v1/nutrition?ingredients=";
  $url = $api.urlencode(options($ingredients));

  $context = stream_context_create(array('http'=>array('method'=>"GET")));
  $json = file_get_contents($url, 0, $context);
  $response = json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
  return $response;
  // return $json;
}

function options($ingredients){
  return implode(",", explode("\n", trim($ingredients)));
}
?>
<style media="screen">
  .gfb-nutrition-label-section{
    padding-top: 30px;
  }
  #nutrition-label-outer {
    background-color: white;
    width: auto !important;
  }
  .gfb-nutrition-label-section .section2 {
    padding-left: 40px
  }
  .gfb-nutrition-label-section .section1, .gfb-nutrition-label-section .section2 {
    vertical-align: top;
    display: inline-block !important;
    overflow: hidden;
  }
</style>
<div class='wrap'>
  <h1><?php echo __( 'Nutrition Facts Label by <a href="http://globalfoodbook.com" target="_blank">Global Food Book</a>', 'menu-gfb-nutrition-label' ) ?> </h1>
  <div class='gfb-nutrition-label-section'>
    <div class='section1'>
      <form method='post' action='<?php echo admin_url( 'admin.php' ); ?>?page=gfb-nutrition-label-settings'>
         <h4>Ingredients:</h4>
         <p><textarea name='ingredients' rows='12' cols='33'><?php echo $ingredients; ?></textarea></p>
         <p><input type='submit' name='Submit' value='Generate Label' /></p>
      </form>
    </div>
    <div class='section2'>
       <h4>Nutrition Facts Label:</h4>
      <div id="nutrition-label-outer">
        <div id="nutrition-label"> </div>
      </div>
       <p><a id="gfb-nutrition-label-button" onclick='gfbnutritionlabel.generateImage()' style="display: block; width: 70px; background: #4E9CAF; padding: 10px; text-align: center; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;">Download</a></p>
    </div>
    <div class='section3'>
       <h4>Embedded Code:</h4>
      <textarea id="gfb-nut-textarea" rows='12' cols='33' readonly>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script type="text/javascript" src="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/javascript/nutritionLabel-min.js"></script>
      <link rel="stylesheet" href="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/css/nutritionLabel-min.css" type="text/css" media="all">
      </textarea>
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery( document ).ready(function() {
  var settings = {
    	"showServingUnitQuantity":true,
    	"showPolyFat":true,
    	"showMonoFat":true,
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
