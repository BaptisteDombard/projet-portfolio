<?php get_header(); ?>

<main class="main">
<h2 class="main__title">Mes projets</h2>
<?php if (($projects= portfolio_get_project(3))->have_posts()):while ($projects->have_posts()):$projects->the_post();?>
    <article class="main__article project">
        <h3 class="project__title"><?php get_the_title()?></h3>
        <figure class="project__fig">
            <?= get_the_post_thumbnail(null, 'medium', ['class' => 'project__thumbnail'])?>
        </figure>
        <div class="project__content">
            <?php the_content();?>
        </div>
    </article>
<?php endwhile; endif;?>
</main>

<?php get_footer(); ?>