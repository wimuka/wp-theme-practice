<?php
get_header();

while (have_posts()) {
    the_post();
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>DON'T FORGET TO REPLACE ME LATER</p>
            </div>
        </div>
    </div>

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
        ?>
                <div class="event-summary">
                    <a class="event-summary__date t-center" href="#">
                        <span class="event-summary__month">
                            <?php
                            $eventDate = new DateTime(get_field('event_date')); //* create object that contains info from custom field
                            //* info comes from get_field func that's provided by ACF plugin 
                            echo $eventDate->format('M')
                            ?>
                        </span>
                        <span class="event-summary__day">
                            <?php echo $eventDate->format('d') ?>
                        </span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                        <p>
                            <?php
                            if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                echo wp_trim_words(get_the_content(), 18);
                            }
                            ?>
                            <a href="<?php the_permalink() ?>" class="nu gray">Learn more
                            </a>
                        </p>
                    </div>
                </div>
        <?php }
        }
        ?>
    </div>


<?php
}
get_footer();
?>