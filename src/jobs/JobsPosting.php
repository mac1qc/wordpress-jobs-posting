<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs;

use Mac1qc\WordpressJobsPosting\jobs\admin\AdminJobs;
use Mac1qc\WordpressJobsPosting\jobs\menu\MenuJobs;
use Mac1qc\WordpressJobsPosting\jobs\template\TemplateJobs;

class JobsPosting
{
    private const POST_TYPE = 'jobs_posting';

    public function __construct()
    {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        add_action('init', [$this, 'baseInit']);
        add_action('admin_init', [$this, 'adminInit']);

        add_theme_support('post-thumbnails');
    }

    public function baseInit(): void
    {
        register_post_type(self::POST_TYPE, MenuJobs::getMenu());

        new TemplateJobs(self::POST_TYPE);
    }

    public function adminInit(): void
    {
        new AdminJobs(self::POST_TYPE);
    }
}
