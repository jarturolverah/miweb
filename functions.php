<?php
function chef_blog_alisson_setup() {
    register_nav_menus(array('menu-principal' => __('Menú Principal', 'chef-blog-alisson')));
    add_theme_support('post-thumbnails'); // Soporte para imágenes destacadas
}
add_action('after_setup_theme', 'chef_blog_alisson_setup');

function chef_blog_alisson_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'chef_blog_alisson_styles');
