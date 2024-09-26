<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\template;

class TemplateJobs
{
    public function __construct(private string $postType)
    {
        add_filter('template_include', [$this, 'jobTemplate']);
    }

    public function jobTemplate(mixed $template): mixed
    {
        if (is_post_type_archive($this->postType)) {
            $theme_files     = [
                sprintf('archive-%s.php', $this->postType),
                sprintf('%s/template/archive-%s.php', $this->postType, $this->postType)
            ];
            $exists_in_theme = locate_template($theme_files, false);
            
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__DIR__) . sprintf('/template/archive-%s.php', $this->postType);
            }
        } else if (is_singular($this->postType)) {
            $theme_files     = [
                sprintf('single-%s.php', $this->postType),
                sprintf('%s/template/single-%s.php', $this->postType, $this->postType)
            ];
            $exists_in_theme = locate_template($theme_files, false);
            
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__DIR__) . sprintf('templates/single-%s.php', $this->postType);
            }
        }
        return $template;
    }
}