<?php $serving = get_post_meta($post->ID, 'RECIPE_META_servings', true);?>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    <?php if (!empty($post) && $post->post_type == 'recipe') { ?>
    var response = <?php echo json_encode(get_post_meta($post->ID, META_KEY, true)); ?>;
    if (response.length > 0){
      gfbnutritionlabel.setup(response, <?php echo json_encode(options($ingredients)); ?>, <?php echo (empty($serving) ? 1 : $serving)?>)
    }
    <?php }  ?>
  });
</script>
