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
     <input id="gfb-nutrition-label-url" name="url" type="hidden" value="<?php echo C_URL ?>" />
     <input id="gfb-nutrition-label-post-id" name='post_id' type="hidden" value="<?php echo $post->ID ?>" />
     </p>
     <p><input type='button' name='Submit' value='Generate Label' style="display: block; width: 140px; background: #4E9CAF; padding: 10px; text-align: center; border-color:transparent; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;" onclick="gfbnutritionlabel.submitForm()"/></p>
  </form>
</div>
<div class='section2'>
   <h4>Nutrition Facts Label:</h4>
   <p><div id="nutrition-label-outer">
     <div id="nutrition-label"> </div>
   </div></p>
   <p><a id="gfb-nutrition-label-button" onclick="gfbnutritionlabel.generateImage()" style="display:inline; width: 70px; background: #4E9CAF; padding: 10px; text-align: center; border-radius: 5px; color: white; font-weight: bold; cursor: pointer;">Download</a></p>
</div>
<?php require_once 'front_end.php';
?>

</div>
