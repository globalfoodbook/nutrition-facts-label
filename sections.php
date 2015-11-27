<?php
  global $post;
  if(!empty($post) && $post->post_type == 'recipe') {
    $message = "<b>NB:</b> <i>The ingredients here are listed in a readonly text-box. They are sourced from the ingredient list in the recipe information section. Before generating this label make sure you have at least one ingredient and have saved or updated this recipe first before generating this nutrition label.</i>";
    $readonly = 'readonly';
    $ingredients = implode(PHP_EOL,get_post_meta($post->ID, 'RECIPE_META_ingredients')[0]);
  }

  echo $message;
?>
<div>
<div class='section1'>
  <form name="gfb-nutrition-label-form" method='post' action='#'>
     <h4>Ingredients:</h4>
     <p><textarea id="gfb-nutrition-label-textarea" name='ingredients' rows='12' cols='33' <?php echo $readonly?>><?php echo $ingredients; ?></textarea>
     <input id="gfb-nutrition-label-url" type="hidden" value="<?php echo C_URL?>" />
     </p>
     <p><input type='button' name='Submit' value='Generate Label' style="display: block; width: 140px; background: #4E9CAF; padding: 10px; text-align: center; border-color:transparent; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;" onclick="gfbnutritionlabel.submitForm()"/></p>
  </form>
</div>
<div class='section2'>
   <h4>Nutrition Facts Label:</h4>
   <p><div id="nutrition-label-outer">
     <div id="nutrition-label"> </div>
   </div></p>
   <p><a id="gfb-nutrition-label-button" onclick="gfbnutritionlabel.generateImage()" style="display: <?php echo empty($hidden) ? 'block':'none';?>; width: 70px; background: #4E9CAF; padding: 10px; text-align: center; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;">Download</a></p>
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
<?php }
  require_once 'front_end.php';
?>

</div>
