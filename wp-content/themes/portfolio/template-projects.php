<?php /* Template Name: Projects page template */ ?>
<?php get_header(); ?>
<main class="main__project project">
    <h2 class="project__title">Mes projets</h2>
    <section class="main__articlecontainer">
        <?php if (($projects= portfolio_get_project(4))->have_posts()):while ($projects->have_posts()):$projects->the_post();?>
            <?php dw_include('project', ['modifier', 'index']); ?>
        <?php endwhile; endif;?>
    </section>
</main>