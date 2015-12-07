 <?php $serving = get_post_meta($post->ID, 'RECIPE_META_servings', true);?>
<script type="text/javascript">
jQuery( document ).ready(function() {
  <?php if(!empty($nutrition)) {?>
    var response = <?php echo $nutrition; ?>;
    gfbnutritionlabel.setup(response, <?php echo json_encode(options($ingredients)); ?>, <?php echo (empty($serving) ? 1 : $serving)?>)

  <?php } else if (!empty($post) && $post->post_type == 'recipe') { ?>
    var response = <?php echo json_encode(get_post_meta($post->ID, META_KEY, true)); ?>;
    if (response.length > 0){
      gfbnutritionlabel.setup(response, <?php echo json_encode(options($ingredients)); ?>, <?php echo (empty($serving) ? 1 : $serving)?>)
    } else {
      gfbnutritionlabel.basic();
    }

  <?php } else { ?>
    gfbnutritionlabel.basic();
  <?php } ?>
});
</script>
