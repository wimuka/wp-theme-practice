<?php
get_header();
pageBanner(array(
    'title' => ' Past Events',
    'subtitle' => 'A recap of our past events.'
));
?>

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
        $pastEvents->the_post();
        get_template_part('template-parts/content-event');
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