<?php
get_header();
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">

        <h1 class="page-banner__title">
            Past Events
        </h1>

        <div class="page-banner__intro">
            <p>
                A recap of our past events.
            </p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php

    //* Custom query that will load any event posts where the event date < today's date

    $today = date('Ymd');
    $pastEvents = new WP_Query( //* class that WP provides (blueprint)
        array(
            'paged' => get_query_var('paged', 1), //* tells custom query which page # of results it should be on (pagination related)
            'post_type' => 'event', //* specify custom post type that we're trying to load
            'meta_key' => 'event_date', //* requred - allows to specify custom field to get metadata from
            'orderby' => 'meta_value',  //* sort things by the value of a piece of metadata
            'order' => 'ASC',
            'meta_query' => array( //* add conditions to be checked for (separate array for each filter)
                array(
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => $today,
                    'type' => 'numeric'
                )
            )
        )
    );

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post(); ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                    <?php
                    $eventDate = new DateTime(get_field('event_date'));
                    echo $eventDate->format('M')
                    ?>
                </span>
                <span class="event-summary__day">
                    <?php echo $eventDate->format('d') ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>
    <?php
    }

    //* show pagination if there's more than events (pagination related)
    echo paginate_links(array( //* to provide access to custom query's data
        'total' => $pastEvents->max_num_pages
    ));
    ?>
</div>
<?php
get_footer();
?>