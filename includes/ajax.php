<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action("wp_ajax_mbulet_ilu_get_posts", "wp_ajax_mbulet_ilu_get_posts");
add_action("wp_ajax_nopriv_mbulet_ilu_get_posts", "wp_ajax_mbulet_ilu_get_posts");
function wp_ajax_mbulet_ilu_get_posts() {
    $posts = mbulet_ilu_get_posts(true, true, [
        "posts_per_page" => 5,
        "s" => sanitize_text_field( $_GET['search'] )
    ]);
    wp_send_json($posts);
}

add_action("wp_ajax_mbulet_ilu_get_post", "wp_ajax_mbulet_ilu_get_post");
add_action("wp_ajax_nopriv_mbulet_ilu_get_post", "wp_ajax_mbulet_ilu_get_post");
function wp_ajax_mbulet_ilu_get_post() {
    $post = mbulet_ilu_get_posts(true, false, [
        "posts_per_page" => 1,
        'p' => sanitize_text_field( $_GET['post_id'] )
    ]);
    if( count($post) > 0) {
        wp_send_json($post[0]);
    }
    else {
        wp_send_json_error(["message" => "No posts found with ID " . $_GET['post_id']], 404);
    }
}

add_action("wp_ajax_mbulet_ilu_update_post", "wp_ajax_mbulet_ilu_update_post");
add_action("wp_ajax_nopriv_mbulet_ilu_update_post", "wp_ajax_mbulet_ilu_update_post");
function wp_ajax_mbulet_ilu_update_post() {
    $post = mbulet_ilu_update_post([
        'p' => sanitize_text_field( $_POST['post_id'] ),
        'post_content' => wp_kses_post( $_POST['post_content'] )
    ]);

    if(!$post || is_wp_error($post)) {
        wp_send_json([ 'success' => false, 'message' => $post->get_error_message() ]);
    }
    wp_send_json([ 'success' => true, 'message' => "Internal link updated successfully" ]);
}