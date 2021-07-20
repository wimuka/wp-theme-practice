<?php

//
function university_files()
{
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'university_files');

//
function university_features()
{
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'university_features');

//
function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('program') and is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('post_per_page', -1);
    }

    if (
        !is_admin()                         //*only run code if we're on front end of website (not in admin)
        and is_post_type_archive('event')   //* AND only if we're on event's archive page
        and $query->is_main_query()         //* AND only if it's a main query (to avoid changing custom queries)
    ) {
        $today = date('Ymd');
        //* set query parameters inside object so they're sorted as we want
        $query->set('meta_key', 'event_date');  //* 1 arg - name of query param to be changed, 2nd arg - value to be used
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date', //* only if key is specified key 
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric' //* ensures only num are compared
            )
        ));
    }
}
add_action('pre_get_posts', 'university_adjust_queries');
