<?php
function university_post_types()
{
    //Event Post Type
    register_post_type(
        'event', //* arg 1 - name of custom post type that we want to create                      
        array(  //* arg 2 - array of diff options that describe custom post type
            'supports' => array('title', 'editor', 'excerpt'), //*adds custom features
            'rewrite' => array('slug' => 'events'), //* change default slug (keyword) to custom one
            'has_archive' => true, //* add archive support
            'public' => true, //* this makes post type visible to esitors & viewers
            'menu_icon' => 'dashicons-calendar-alt', //*to add custom icon
            'show_in_rest' => true, //* Ensures that custom types use new Block Editor screen 
            'labels' => array( //* to add custom labels 
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event'

            )
        )
    );
    //Program Post Type
    register_post_type(
        'program', //* arg 1 - name of custom post type that we want to create                      
        array(  //* arg 2 - array of diff options that describe custom post type
            'supports' => array('title', 'editor'), //*adds custom features
            'rewrite' => array('slug' => 'programs'), //* change default slug (keyword) to custom one
            'has_archive' => true, //* add archive support
            'public' => true, //* this makes post type visible to esitors & viewers
            'menu_icon' => 'dashicons-awards', //*to add custom icon
            'show_in_rest' => true, //* Ensures that custom types use new Block Editor screen 
            'labels' => array( //* to add custom labels 
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
                'singular_name' => 'Program'

            )
        )
    );
}
add_action('init', 'university_post_types');
