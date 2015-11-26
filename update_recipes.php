<?php
// This code was adapted from the Regenerate Thumbnails plugin https://wordpress.org/plugins/regenerate-thumbnails/
function esc_quotes( $string ) {
	return str_replace( '"', '\"', $string );
}
?>
<div id="message" class="updated fade" style="display:none"></div>

	<div class="wrap gfb-nutrition-label">
		<?php
		// When the button is clicked
		if(!empty($_POST['gfb-nutrition-label-update']) || !empty($_REQUEST['ids'])) {
			if(empty($_GET['ids'])){
				/*$args = array(
					'post_type' => 'recipe',
					'post_status' => 'publish'
				);
				$query = new WP_Query($args);
				$num_pages = $query->max_num_pages;
				$post_ids = wp_list_pluck( $query->posts, 'ID' );*/
			global $wpdb;
			$sql = "SELECT ID FROM $wpdb->posts WHERE post_type = 'recipe' AND post_status = 'publish' ORDER BY post_date DESC";
			$post_ids = wp_list_pluck($wpdb->get_results($sql), 'ID');
		} else {
			$post_ids = explode(',', preg_replace( '/^,/', '', $_GET['ids']));
		}
		$ids = implode( ',', $post_ids);

		echo '	<p>' . __( "Please be patient while your recipes are updated. This can take a while if your server is slow or if network is busy. Do not navigate away from this page until this script is done or the recipes will not be updated. You will be notified via this page on completion.", 'gfb-nutrition-label-update' ) . '</p>';

		$count = count( $post_ids );

		$text_goback = ( ! empty( $_GET['goback'] ) ) ? sprintf( __( 'To go back to the previous page, <a href="%s">click here</a>.', 'gfb-nutrition-label-update' ), 'javascript:history.go(-1)' ) : '';
		$text_failures = sprintf(__( 'All done! %1$s recipe(s) successfully updated in %2$s seconds and there were %3$s failure(s). Try again, <a href="%4$s">click here</a>. %5$s', 'gfb-nutrition-label-update' ), "' + recipes_update_successes + '", "' + recipes_update_totaltime + '", "' + recipes_update_errors + '", esc_url( wp_nonce_url( admin_url( 'admin.php?page=gfb-nutrition-label-settings-1&goback=1' ), 'gfb-nutrition-label-update' ) . '&ids=' ) . "' + recipes_update_failedlist + '", $text_goback );
		$text_nofailures = sprintf(__( 'All done! %1$s recipe(s) successfully updated in %2$s seconds and there were 0 failures. %3$s', 'gfb-nutrition-label-update' ), "' + recipes_update_successes + '", "' + recipes_update_totaltime + '", $text_goback );
	?>

		<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'gfb-nutrition-label-update' ) ?></em></p></noscript>

		<div id="gfb-nutrition-update-bar" style="position:relative;height:25px;">
			<div id="gfb-nutrition-update-bar-percent" style="position:absolute;left:50%;top:50%;width:300px;margin-left:-150px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
		</div>
		<div id="gfb-nutrition-update-stop-div" >
			<p>click below to if you want to stop or abort this process.</p>
			<p><input type="button" class="button hide-if-no-js" name="gfb-nutrition-update-stop" id="gfb-nutrition-update-stop" value="<?php _e( 'Abort', 'gfb-nutrition-label-update' ) ?>" /></p>
		</div>

		<h3 class="title"><?php _e( 'Debugging Information', 'gfb-nutrition-label-update' ) ?></h3>

		<p>
			<?php printf( __( 'Total: %s', 'gfb-nutrition-label-update' ), $count ); ?><br />
			<?php printf( __( 'Successful: %s', 'gfb-nutrition-label-update' ), '<span id="gfb-nutrition-update-debug-successcount">0</span>' ); ?><br />
			<?php printf( __( 'Unsuccessful: %s', 'gfb-nutrition-label-update' ), '<span id="gfb-nutrition-update-debug-failurecount">0</span>' ); ?>
		</p>

		<ol id="gfb-nutrition-update-debuglist">
			<li style="display:none"></li>
		</ol>

		<script type="text/javascript">
		// <![CDATA[
			jQuery(document).ready(function($){
				var i,
				recipes_update_recipes = [<?php echo $ids; ?>],
				recipes_update_total = recipes_update_recipes.length,
				recipes_update_count = 1,
				recipes_update_percent = 0,
				recipes_update_successes = 0,
				recipes_update_errors = 0,
				recipes_update_failedlist = '',
				recipes_update_resulttext = '',
				recipes_update_timestart = new Date().getTime(),
				recipes_update_timeend = 0,
				recipes_update_totaltime = 0,
				recipes_update_continue = true,
				site_url = "<?php echo site_url(); ?>"

				// Create the progress bar
				$("#gfb-nutrition-update-bar").progressbar();
				$("#gfb-nutrition-update-bar-percent").html( "0%" );

				// Stop button
				$("#gfb-nutrition-update-stop").click(function() {
					recipes_update_continue = false;
					$('#gfb-nutrition-update-stop').val("<?php echo esc_quotes( __( 'Stopping...', 'gfb-nutrition-label-update' ) ); ?>");
				});

				// Clear out the empty list element that's there for HTML validation purposes
				$("#gfb-nutrition-update-debuglist li").remove();

				// Called after each update. Update debug information and the progress bar.
				function GFBNutritionLabelStatus( id, success, response ) {
					$("#gfb-nutrition-update-bar").progressbar( "value", ( recipes_update_count / recipes_update_total ) * 100 );
					$("#gfb-nutrition-update-bar-percent").html( Math.round( ( recipes_update_count / recipes_update_total ) * 1000 ) / 10 + "%" );
					recipes_update_count = recipes_update_count + 1;

					if ( success ) {
						recipes_update_successes = recipes_update_successes + 1;
						$("#gfb-nutrition-update-debug-successcount").html(recipes_update_successes);
						color = 'green';
					} else {
						recipes_update_errors = recipes_update_errors + 1;
						recipes_update_failedlist = recipes_update_failedlist + ',' + id;
						$("#gfb-nutrition-update-debug-failurecount").html(recipes_update_errors);
						color = 'red';
					}
					$("#gfb-nutrition-update-debuglist").append("<li> <a href='" + response.url + "' target='_blank'>"+response.post_title+"</a> <span style=color:"+color+";font-weight:bold;>"+response.message+"</span></li>");
				}

				// Called when all nutrition data for recipes updated. Shows the results and cleans up.
				function GFBNutritionLabelFinal() {
					recipes_update_timeend = new Date().getTime();
					recipes_update_totaltime = Math.round( ( recipes_update_timeend - recipes_update_timestart ) / 1000 );

					// $('#gfb-nutrition-update-stop').hide();
					$('#gfb-nutrition-update-stop-div').hide();

					if ( recipes_update_errors > 0 ) {
						recipes_update_resulttext = '<?php echo $text_failures; ?>';
					} else {
						recipes_update_resulttext = '<?php echo $text_nofailures; ?>';
					}

					$("#message").html("<p><strong>" + recipes_update_resulttext + "</strong></p>");
					$("#message").show();
				}

				// Update a specified recipe via AJAX
				function UpdateNutritionFacts( id ) {
					$.ajax({
						type: 'POST',
						url: "<?php echo C_URL;?>",
						data: { action: "update_recipes_request", id: id },
						success: function(response) {
							response = compose(id, response)
							if ( response.success ) {
								GFBNutritionLabelStatus(id, true, response);
							}
							else {
								GFBNutritionLabelStatus(id, false, response);
							}

							if(recipes_update_recipes.length && recipes_update_continue) {
								UpdateNutritionFacts(recipes_update_recipes.shift());
							}
							else {
								GFBNutritionLabelFinal();
							}
						},
						error: function(response) {
							GFBNutritionLabelStatus(id, false, compose(id, response));

							if(recipes_update_recipes.length && recipes_update_continue) {
								UpdateNutritionFacts(recipes_update_recipes.shift());
							}
							else {
								GFBNutritionLabelFinal();
							}
						}
					});
				}

				function compose(id, response) {
					try {
						response = JSON.parse(response);
						// console.log("response", response);
						// console.log("status", response.success);
					} catch(e) {
						// console.log("New object: ", response);
						if(!(typeof response.status === "undefined")) {
							status     = response.status +" "+ response.statusText
						}
						response = new Object;
						response.success = false;
						response.error = true
						response.url = site_url+"?p="+id
						response.post_title = "<?php printf(esc_js(__( 'Request terminated: (ID %s). Could be server error/downtime, network problems or error with your ingredients listing.', 'gfb-nutrition-label-update')), '" + id + "'); ?>";
						response.message = (status == null) ? 'Update unsuccessful.' : 'Update unsuccessful. '+status;
				}
					return response;
				}
				UpdateNutritionFacts( recipes_update_recipes.shift() );
			});
		// ]]>
		</script>
<?php } else { ?>
	<form method="post" action="">
<?php wp_nonce_field('gfb-nutrition-label-update') ?>

	<p><?php printf( __( "Use this tool to add or update nutrition facts label data for all published recipes on your blog. This is useful as we contimue to improve our algorithms.", 'gfb-nutrition-label-update' ), admin_url( 'admin.php' ) ); ?></p>

	<p><?php _e( 'To begin, click the button below.', 'gfb-nutrition-label-update '); ?></p>

	<p><input type="submit" class="button hide-if-no-js" name="gfb-nutrition-label-update" id="gfb-nutrition-label-update" value="<?php _e( 'Go', 'gfb-nutrition-label-update' ) ?>" /></p>

	<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'gfb-nutrition-label-update' ) ?></em></p></noscript>

	</form>
<?php } // End if button ?>
</div>
