<?php if ( bdr_is_auteur_post() ) { ?>
    <?php get_template_part('templates/content', 'auteur');
} else { ?>
    <?php get_template_part('templates/content', 'single');
} ?>

