<?php
function emojized_meta_boxes( $post )
{
	add_meta_box(
		'emojized-meta-box',
		__( 'Emojized' ),
		'render_emojized_meta_box',
		'emojize',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'emojized_meta_boxes' );

function render_emojized_meta_box()
{
	global $post;
	wp_nonce_field( plugin_basename( __FILE__ ), 'emojized_nonce' );
	echo '<table>';
	echo '<tr><th>ID</th><th>Emoji</th><th>Count</th><th>Initial Count</th><th>Shortcode</th></tr>';
	echo '<tr><td><h1>ID : '.$post->ID.'</h1></td>';
	echo '<td>';
	$emoji = get_post_meta($post->ID, 'emoji', true);
	echo '<input name="emoji" type="text" style="font-size:64px;height:75px;width:75px;" value="' .esc_attr($emoji). '" /></td>';
	$count = get_post_meta($post->ID, 'count', true);
	echo '<td><input name="count" type="number" style="font-size:64px;height:75px;width:300px;" value="' .esc_attr($count). '" /></td>';
	$initial_count = get_post_meta($post->ID, 'initial_count', true);
	echo '<td><input name="initial_count" type="number" style="font-size:64px;height:75px;width:300px;" value="' .esc_attr($initial_count). '" /></td>';
	echo '<td><h2>[emojized id="' .$post->ID . '" count="true"]</h3></td>';
	echo '</tr></table>';

}

add_action( 'save_post', 'emojized_save_postdata' );

function emojized_save_postdata()
{
	if ( ! isset( $_POST['emojized_nonce'] ) || ! wp_verify_nonce( $_POST['emojized_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	global $post;
	$emoji = sanitize_text_field( $_POST['emoji'] );
	$count = sanitize_text_field( $_POST['count'] );
	$initial_count = sanitize_text_field( $_POST['initial_count'] );

	update_post_meta($post->ID, 'emoji', $emoji);
	update_post_meta($post->ID, 'count', $count);
	update_post_meta($post->ID, 'initial_count', $initial_count);
}

?>