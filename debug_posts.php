<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

$post_types = get_post_types(array('public' => true));
print_r($post_types);

$args = array(
    'post_type' => 'any',
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC'
);
$posts = get_posts($args);
foreach ($posts as $post) {
    echo "ID: " . $post->ID . " | Type: " . $post->post_type . " | Slug: " . $post->post_name . "\n";
}
