<?php
//désactiver l'éditeur gutenberg
add_filter('use_block_editor_for_post', '__return_false');

//Activer les images sur les articles
add_theme_support( 'post-thumbnails' );

// enregistrer un seul custom post type pour "nos voyages"
register_post_type('project', [
    'label' => 'Projets',
    'labels' => [
        'name' => 'Projets',
        'singular_name' => 'Projet'
    ],
    'description' => 'Tous les articles qui décrive un projet',
    'public' => true,
    'menu_position' => 10,
    'menu_icon' => 'dashicons-art',
    'supports' => ['title','editor','thumbnail'],
    'rewrite' => ['slug' => 'projet'],
]);

//Récupérer les trips via une requête wordpress
function portfolio_get_project($count = 20)
{
    // 1. on instancie l'objet WP_query
    $projects = new WP_Query([
        'post_type' => 'project',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $count,
    ]);

    // 2. on retourne l'objet WP_query
    return $projects;
}