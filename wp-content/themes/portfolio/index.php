<?php get_header(); ?>

<main class="main">
<h2 class="main__title"></h2>
<h2 class="main__title">Mes projets</h2>
<?php if (($projects= portfolio_get_project(3))->have_posts()):while ($projects->have_posts()):$projects->the_post();?>
    <?php dw_include('project', ['modifier', 'index']); ?>
<?php endwhile; endif;?>
</main>
