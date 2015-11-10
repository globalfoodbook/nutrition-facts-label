<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["ingredients"])) {
    $ingredients = $_POST["ingredients"];
    $nutrition = process_request($ingredients);
  }
}

function process_request($ingredients){
  $url = NUT_API.urlencode(options($ingredients));

  $context = stream_context_create(array('http'=>array('method'=>"GET")));
  $json = file_get_contents($url, 0, $context);
  return json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
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
  <div class='gfb-nutrition-label-section'>
    <div class='section1'>
      <form name="gfb-nutrition-label-form" method='post' action='#'>
         <h4>Ingredients:</h4>
         <p><textarea id="gfb-nutrition-label-textarea" name='ingredients' rows='12' cols='33'><?php echo $ingredients; ?></textarea></p>
         <p><input type='button' name='Submit' value='Generate Label' style="display: block; width: 140px; background: #4E9CAF; padding: 10px; text-align: center; border-color:transparent; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;" onclick="gfbnutritionlabel.submitForm()"/></p>
      </form>
    </div>
    <div class='section2'>
       <h4>Nutrition Facts Label:</h4>
       <?php require_once 'nutrition_label.php'; ?>
       <p><a id="gfb-nutrition-label-button" onclick="gfbnutritionlabel.generateImage()" style="display: block; width: 70px; background: #4E9CAF; padding: 10px; text-align: center; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;">Download</a></p>
    </div>
    <?php if (false) { ?>
    <div class='section3'>
       <h4>Embedded Code:</h4>
      <textarea id="gfb-nut-textarea" rows='12' cols='33' readonly>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script type="text/javascript" src="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/javascript/nutritionLabel-min.js"></script>
      <link rel="stylesheet" href="http://raw.githubusercontent.com/globalfoodbook/nutrition-facts-label/develop/includes/assets/css/nutritionLabel-min.css" type="text/css" media="all">
      </textarea>
    </div>
    <?php }?>
  </div>
</div>

<?php require_once 'nutrition_ui.php'; ?>
