<?php
/**
* Plugin Name: Jobs posting
* Plugin URI: https://martin-ayotte.net
* Description: Jobs posting plugin for your website that will also publish into Google Jobs
* Version: 1.0
* Author: mac1qc
* Author URI: https://martin-ayotte.net
*/

declare(strict_types=1);

use Mac1qc\WordpressJobsPosting\jobs\JobsPosting;

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'src/jobs/JobsPosting.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/menu/MenuJobs.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/admin/AdminJobs.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/template/TemplateJobs.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/component/ContentJob.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/component/enum/SalaryRecurrency.php';
require_once plugin_dir_path(__FILE__) . 'src/jobs/component/enum/JobType.php';

function run_my_plugin(): void
{
    new JobsPosting();
}

run_my_plugin();