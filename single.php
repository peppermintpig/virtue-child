<?php if ( in_category(5) ) { ?>
    <?php get_template_part('templates/content', 'auteur');
} else { ?>
    <?php get_template_part('templates/content', 'single');
} ?>

