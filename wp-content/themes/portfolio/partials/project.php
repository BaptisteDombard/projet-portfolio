<article class="main__article project">
    <h3 class="project__title"><?php get_the_title()?></h3>
    <figure class="project__fig">
        <?= get_the_post_thumbnail(null, 'medium', ['class' => 'project__thumbnail'])?>
    </figure>
    <div class="project__content">
        <?php the_content();?>
        <a href="<?= get_the_permalink()?>" class="project__link">Lire plus sur "<?= get_the_title()?>"</a>
    </div>
</article>
