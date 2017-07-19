<?php
add_action( 'rest_api_init', 'emojized_routes');

function emojized_routes()
	{ register_rest_route( 'emojized/v1', '/count/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => 'emojized_post_id',
			'args' => array(
				'id' => array(
					'validate_callback' => function($param, $request, $key)
					{
						return is_numeric( $param );
					}

				),
			),
		) );
}

function emojized_post_id($data)
{
	$id = $data['id'];

	$count = get_post_meta($id, 'count', true);
	$count++;
	update_post_meta($id, 'count', $count);

	return $count;
}
?>