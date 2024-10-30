<?php

function mbulet_ilu_get_posts( $post_only=false, $is_ajax=false, $args=[] ) {
    $default_args = [
        "post_type" => "post"
    ];
    $parameters = array_merge($args, $default_args); 
    $posts = new \WP_Query( $parameters );
    
    if($post_only) {
        $posts = $posts->posts;
    }
    if($is_ajax) {
        $results = [];
        foreach ($posts as $post) {
            $results[] = ["id" => $post->ID, "text" => $post->post_title];
        }
        return $results;
    }

    return $posts;
}

function mbulet_ilu_update_post($args) {
    $selected_post = new \WP_Query([ 'p' => $args['p'] ]);
    $selected_post = $selected_post->posts[0];
    $selected_post->post_content = $args['post_content'];
    $update_post = wp_update_post($selected_post);
    return $update_post;
}