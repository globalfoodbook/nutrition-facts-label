<style media="screen">
  #gfb-nutrition-label-update-button {
    display: block;
    width: 140px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-color:transparent;
    border-radius: 5px;
    color: white;
    font-size:13.5px;
    font-weight: bold;
    cursor: pointer;
  }
</style>
<div class='wrap'>
  <p>NB: You need to be an administrator to use this feature. Please backup your database before starting this process.</p>
  <div class='gfb-nutrition-label-section' <?php echo "test"; ?> >
    <form name='gfb-nutrition-label-form' method='post' action='#'>
      <input id='gfb-nutrition-label-update-button' type='submit' name='Submit' value='Update All Recipes' style='' />
    </form>
  </div>
</div>
<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (is_admin()) {
      $args=array(
        'post_type' => 'recipe',
        'post_status' => 'publish'
      );
      $my_query = new WP_Query($args);
      if( $my_query->have_posts() ) {
        while ($my_query->have_posts()) : $my_query->the_post();
          $post_id = get_the_ID();
          $ingredients = get_post_meta($post_id, 'RECIPE_META_ingredients', true);
          $nutrition_facts =  process_request($ingredients);
          if (!add_post_meta($post_id, META_KEY, $nutrition_facts, true)) {
             update_post_meta ($post_id, META_KEY, $nutrition_facts);
          } ?>
            <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Update complete <?php the_title_attribute(); ?>"><?php the_title(); ?></a> Update Complete!</p>
        <?php
        endwhile;
      }
      wp_reset_query();
    }
  }
?>
