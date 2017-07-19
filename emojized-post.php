<?php
add_action( 'init', 'emojized_post_type' );
function emojized_post_type()
{
	register_post_type( 'emojize',
		array(
			'labels' => array(
				'name' => __( 'Emojized' ),
				'singular_name' => __( 'Emojize' ),
				'add_new' => __('New Emoji', 'emojized'),
				'add_new_item' => __('Add new Emoji', 'emojized'),
			),
			'public' => false,
			'has_archive' => false,
			'show_ui' => true,
			'exclude_from_search' => true,
			'supports' => array ('title', 'custom-fields'),
			'menu_icon' => 'dashicons-smiley'
		)
	);
}

function emojized_enqueue_script()
{
	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'emojized', plugins_url('js/emojized.js', __FILE__), false );

}

add_action( 'wp_enqueue_scripts', 'emojized_enqueue_script' );

add_action( 'wp_head', 'jquery_site_url');

function jquery_site_url()
{
	echo '<script type="text/javascript">
  			 var site_url = "' . get_bloginfo('url') .'";
		  </script>';
}

add_shortcode('emojized', 'render_emojize');

function render_emojize($atts)
{
	ob_start();
	$count = get_post_meta($atts['id'], 'count', true);
	echo '<span class="emojized-area" style="font-size:30px;" ><span style="cursor:pointer;" data-id="' . $atts['id'] . '" class="emojized">' . get_post_meta($atts['id'], 'emoji', true) .'</span>';
	if ($count!='' && $atts['count']=='true') echo ' <span class="emojized-count-' . $atts['id'] . '">'.$count.'</span>';
	echo '</span>';
	return ob_get_clean();
}

// Admin columns sections
function emojized_emoji_columns_head($defaults)
{
	$defaults['emoji'] = 'Emoji';
	return $defaults;
}

function emoji_columns_content($column_name, $post_ID)
{
	if ($column_name == 'emoji')
	{
		$post_emojized = get_post_meta($post_ID, 'emoji', true);
		if ($post_emojized)
		{
			echo $post_emojized;
		}
	}
}

function emojized_count_emoji_columns_head($defaults)
{
	$defaults['count'] = __('Count');
	return $defaults;
}

function emoji_count_columns_content($column_name, $post_ID)
{
	if ($column_name == 'count')
	{
		$post_emojized = get_post_meta($post_ID, 'count', true);
		$post_emojized_i = get_post_meta($post_ID, 'initial_count', true);
		if ($post_emojized)
		{
			echo $post_emojized-$post_emojized_i;
		}
	}
}

add_filter('manage_emojize_posts_columns', 'emojized_emoji_columns_head');
add_action('manage_emojize_posts_custom_column', 'emoji_columns_content', 10, 2);

add_filter('manage_emojize_posts_columns', 'emojized_count_emoji_columns_head');
add_action('manage_emojize_posts_custom_column', 'emoji_count_columns_content', 10, 2);

add_filter( 'manage_edit-emojize_sortable_columns', 'sortable_emojize_column' );
function sortable_emojize_column( $columns )
{
	$columns['count'] = 'count';
	return $columns;
}

function your_columns_head($defaults)
{
	$defaults = array ('count' => 'Count', 'emoji' => 'Emoji', 'title' => 'Titel', 'date' => 'Datum');

	return $defaults;
}

add_filter('manage_emojize_posts_columns', 'your_columns_head');

?>