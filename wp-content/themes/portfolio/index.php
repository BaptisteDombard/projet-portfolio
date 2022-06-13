<?php get_header(); ?>

<main class="main">
    <h2 class="main__title">Bonjour,</h2>
    <p class="main__subexcerpt">Je m’appelle Baptiste Dombard</p>
    <p class="main__excerpt">Je suis un web déveloper curieux, toujours de bonne humeur
        et ravi d’écouter vos demandes et suggestions.
        Alors, n’hésitez pas à faire appel à moi pour toutes vos requêtes
        en terme de création de site web.</p>
    <p class="main__formexcerpt">Vous pouvez me contacter via mon <a href="<?= get_permalink(get_page_by_path('contact'))?>" class="main__formlink">formulaire</a>.</p>
    <?= wp_get_attachment_image(21, 'medium_large','false',['class'=>'main__img','alt'=>'Image de Baptiste Dombard'])?>
</main>
