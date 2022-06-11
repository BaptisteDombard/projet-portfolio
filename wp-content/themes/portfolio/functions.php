<?php

//chargez les fichiers nécessaire
require_once(__DIR__ . '/Menus/PrimaryMenuWalker.php');
require_once(__DIR__ . '/Menus/PrimaryMenuItem.php');

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

//Récupérer les projects via une requête wordpress
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

// Enregistrer un custom post-type pour les messages de contact
register_post_type('message', [
    'label' => 'Messages de contact',
    'labels' => [
        'name' => 'Messages de contact',
        'singular_name' => 'Message de contact',
    ],
    'description' => 'Les messages envoyés par le formulaire de contact.',
    'public' => false,
    'show_ui' => true,
    'menu_position' => 15,
    'menu_icon' => 'dashicons-buddicons-pm',
    'capabilities' => [
        'create_posts' => false,
        'read_post' => true,
        'read_private_posts' => true,
        'edit_posts' => true,
    ],
    'map_meta_cap' => true,
]);

// Enregistrer les zones de menus

register_nav_menu('primary', 'Navigation principale (haut de page)');
register_nav_menu('footer', 'Navigation de pied de page');

// Fonction pour récupérer les éléments d'un menu sous forme d'un tableau d'objets

function dw_get_menu_items($location)
{
    $items = [];

    // Récupérer le menu Wordpress pour $location
    $locations = get_nav_menu_locations();

    if(! ($locations[$location] ?? false)) {
        return $items;
    }

    $menu = $locations[$location];

    // Récupérer tous les éléments du menu récupéré
    $posts = wp_get_nav_menu_items($menu);

    // Formater chaque élément dans une instance de classe personnalisée
    // Boucler sur chaque $post
    foreach($posts as $post) {
        // Transformer le WP_Post en une instance de notre classe personnalisée
        $item = new PrimaryMenuItem($post);

        // Ajouter au tableau d'éléments de niveau 0.
        if(! $item->isSubItem()) {
            $items[] = $item;
            continue;
        }

        // Ajouter $item comme "enfant" de l'item parent.
        foreach($items as $parent) {
            if(! $parent->isParentFor($item)) continue;

            $parent->addSubItem($item);
        }
    }

    // Retourner un tableau d'éléments du menu formatés
    return $items;
}

//fonction permetant d'inclure des partial dans la vue et d'y injecter des variables locales

function dw_include(string $partial, array $variables = [])
{
    extract($variables);

    include(__DIR__ . '/partials/' . $partial . '.php');
}

//gérer le formulaire
function dw_get_contact_field_value($field)
{
    if(! isset($_SESSION['contact_form_feedback'])) {
        return '';
    }

    return $_SESSION['contact_form_feedback']['data'][$field] ?? '';
}

function dw_get_contact_field_error($field)
{
    if(! isset($_SESSION['contact_form_feedback'])) {
        return '';
    }

    if(! ($_SESSION['contact_form_feedback']['errors'][$field] ?? null)) {
        return '';
    }

    return '<p>Ce champ ne respecte pas : ' . $_SESSION['contact_form_feedback']['errors'][$field] . '</p>';
}

// Fonction qui charge les assets compilés et retourne leure chemin absolu

function dw_mix($path)
{
    $path = '/' . ltrim($path, '/');

    if(! realpath(__DIR__ .'/public' . $path)) {
        return;
    }

    if(! ($manifest = realpath(__DIR__ .'/public/mix-manifest.json'))) {
        return get_stylesheet_directory_uri() . '/public' . $path;
    }

    // Ouvrir le fichier mix-manifest.json
    $manifest = json_decode(file_get_contents($manifest), true);

    // Regarder si on a une clef qui correspond au fichier chargé dans $path
    if(! array_key_exists($path, $manifest)) {
        return get_stylesheet_directory_uri() . '/public' . $path;
    }

    // Récupérer & retourner le chemin versionné
    return get_stylesheet_directory_uri() . '/public' . $manifest[$path];
}

// Restreindre la requête de recherche "par défaut"
function dw_restrict_search_query($query) {
    if ($query->is_search && ! is_admin() && ! is_a($query, DW_CustomSearchQuery::class)) {
        $query->set('post_type', ['post']);
    }

    if(is_archive() && isset($_GET['filter-country'])) {
        $query->set('tax_query', [
            [
                'taxonomy' => 'country',
                'field' => 'slug',
                'terms' => explode(',', $_GET['filter-country']),
            ]
        ]);
    }

    return $query;
}

add_filter('pre_get_posts','dw_restrict_search_query');