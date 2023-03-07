<?php /** Template Name: Read notification */ ?>

<?php

$user_id = get_current_user_id();

$args = array(
    'post_type' => 'feedback', 
    'author' => $user_id,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);

$todos = get_posts($args);

foreach($todos as $todo)
    echo update_field('read_feedback', 1, $todo->ID);
