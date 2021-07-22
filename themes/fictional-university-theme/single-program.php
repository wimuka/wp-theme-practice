<?php
get_header();

while (have_posts()) {
    the_post();
    pageBanner();
?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> All Programs
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <?php
        $relatedProfessors = new WP_Query( //* class that WP provides (blueprint), created var contains all that info
            array(
                'posts_per_page' => -1, //* -1 allows to pull all associated posts (professors)
                'post_type' => 'professor', //* specify custom post type that we're trying to load
                'orderby' => 'title',  //* sort things by the value of a piece of metadata
                'order' => 'ASC',
                'meta_query' => array( //* add conditions to be checked for (separate array for each filter)
                    array(
                        'key' => 'related_programs', //* if array of related programs
                        'compare' => 'LIKE', //* contains
                        'value' => '"' . get_the_ID() . '"', //* id # of current program post 
                    )
                )
            )
        );

        if ($relatedProfessors->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>'; //concat string to function

            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) { //* look inside object(var) and call specific method
                $relatedProfessors->the_post(); //* gets specific data ready for each post (each time loop repeats itself)
        ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink() ?>">
                        <img src="<?php the_post_thumbnail_url('professorLandscape'); ?>" alt="" class="professor-card__image">
                        <span class="professor-card__name">
                            <?php the_title(); ?>
                        </span>
                        </img>
                    </a>
                </li>
        <?php }
            echo '</ul>';
        }

        wp_reset_postdata();
        ?>

        <?php
        $today = date('Ymd'); //* php function to get today's date
        $homepageEvents = new WP_Query( //* class that WP provides (blueprint), created var contains all that info
            array(
                'posts_per_page' => 2, //* limits to 2 posts per page
                'post_type' => 'event', //* specify custom post type that we're trying to load
                'orderby' => 'meta_value',  //* sort things by the value of a piece of metadata
                'meta_key' => 'event_date', //* requred - allows to specify custom field to get metadata from
                'order' => 'ASC',
                'meta_query' => array( //* add conditions to be checked for (separate array for each filter)
                    array(
                        'key' => 'event_date', //* only if key is specified key 
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric' //* ensures only num are compared
                    ),
                    array(
                        'key' => 'related_programs', //* if array of related programs
                        'compare' => 'LIKE', //* contains
                        'value' => '"' . get_the_ID() . '"' //* id # of current program post 
                    )
                )
            )
        );

        if ($homepageEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2>Upcoming ' . get_the_title() . ' Events</h2>'; //concat string to function

            while ($homepageEvents->have_posts()) { //* look inside object(var) and call specific method
                $homepageEvents->the_post(); //* gets specific data ready for each post (each time loop repeats itself)
                get_template_part('template-parts/content-event');
            }
        }
        ?>
    </div>


<?php
}
get_footer();
?>