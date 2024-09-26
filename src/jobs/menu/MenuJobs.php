<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\menu;

class MenuJobs
{
    public static function getMenu(): array
    {
        $args           = self::getArgs();
        $args['labels'] = self::getLabels();

        return $args;
    }

    private static function getLabels(): array
    {
        return [
            'name'               => __('Jobs posting', 'jobs_posting'),
            'singular_name'      => __('Job posting', 'jobs_posting'),
            'add_new'            => __('Add', 'jobs_posting'),
            'edit_item'          => __('Edit', 'jobs_posting'),
            'new_item'           => __('New job', 'jobs_posting'),
            'view_item'          => __('View', 'jobs_posting'),
            'search_items'       => __('Search', 'jobs_posting'),
            'not_found'          => __('No posting found', 'jobs_posting'),
            'not_found_in_trash' => __('No job posting in the trash', 'jobs_posting'),
            'menu_name'          => __('Jobs posting', 'jobs_posting'),
        ];
    }

    private static function getArgs(): array 
    {
        return [
            'labels'              => [],
            'hierarchical'        => true,
            'description'         => __('Jobs posting list on your website', 'jobs_posting'),
            'supports'            => ['title', 'thumbnail'],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-businessman',
            'show_in_nav_menus'   => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => ['slug'=> __('jobs', 'jobs_posting')],
            'capability_type'     => 'post'
        ];
    }
}
