<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\component;

use Mac1qc\WordpressJobsPosting\jobs\component\enum\SalaryRecurrency;

class ContentJob
{
    public function __construct(private int $postId)
    {
    }

    public function getDescription(): string
    {
        return !empty(get_post_meta($this->postId, 'jobDescription', TRUE)) ? wpautop(get_post_meta($this->postId, 'jobDescription', TRUE)) : '';
    }

    public function getRequiredSkills(): string
    {
        return !empty(get_post_meta($this->postId, 'jobSkills', TRUE)) ? wpautop(get_post_meta($this->postId, 'jobSkills', TRUE)) : '';
    }

    public function getPerks(): string
    {
        return !empty(get_post_meta($this->postId, 'perksDescription', TRUE)) ? wpautop(get_post_meta($this->postId, 'perksDescription', TRUE)) : '';
    }

    public function getCompanyName(): string
    {
        return !empty(get_post_meta($this->postId, 'companyName', TRUE)) ? get_post_meta($this->postId, 'companyName', TRUE) : '';
    }

    public function getCompanyDescription(): string
    {
        return !empty(get_post_meta($this->postId, 'companyDescription', TRUE)) ? wpautop(get_post_meta($this->postId, 'companyDescription', TRUE)) : '';
    }

    public function getCompanyAddress(): string
    {
        return !empty(get_post_meta($this->postId, 'companyAddress', TRUE)) ? wpautop(get_post_meta($this->postId, 'companyAddress', TRUE)) : '';
    }

    public function getDisplayEnd(): int
    {
        return !empty(get_post_meta($this->postId, 'jobDisplayEnd', TRUE)) ? (int)get_post_meta($this->postId, 'jobDisplayEnd', TRUE) : 0;
    }

    public function getStartDate(): string
    {
        return !empty(get_post_meta($this->postId, 'jobStartTime', TRUE)) ? wpautop(get_post_meta($this->postId, 'jobStartTime', TRUE)) : '';
    }

    public function getType(): string
    {
        return !empty(get_post_meta($this->postId, 'jobType', TRUE)) ? get_post_meta($this->postId, 'jobType', TRUE) : '';
    }

    public function getReadableType(): string
    {
        return match ($this->getType()) {
            SalaryRecurrency::FULL_TIME->value  => __('Full time', 'jobs_posting'),
            SalaryRecurrency::PART_TIME->value  => __('Part time', 'jobs_posting'),
            SalaryRecurrency::CONTRACTOR->value => __('Contractor', 'jobs_posting'),
            SalaryRecurrency::TEMPORARY->value  => __('Temporary', 'jobs_posting'),
            SalaryRecurrency::INTERN->value     => __('Intern', 'jobs_posting'),
            SalaryRecurrency::VOLUNTEER->value  => __('Volunteer', 'jobs_posting'),
            SalaryRecurrency::PER_DIEM->value   => __('Per diem', 'jobs_posting'),
            default                             => __('Other', 'jobs_posting'),
        };
    }

    public function getWebsite(): string
    {
        return !empty(get_post_meta($this->postId, 'companyWebsite', TRUE)) ? get_post_meta($this->postId, 'companyWebsite', TRUE) : '';
    }

    public function getLogo(): string
    {
        return !empty(esc_url(get_the_post_thumbnail_url(null, 'full'))) ? esc_url(get_the_post_thumbnail_url(null, 'full')) : '';
    }

    public function getStreetAddress(): string
    {
        return !empty(get_post_meta($this->postId, 'whereStreet', TRUE)) ? get_post_meta($this->postId, 'whereStreet', TRUE) : '';
    }

    public function getCity(): string
    {
        return !empty(get_post_meta($this->postId, 'whereCity', TRUE)) ? get_post_meta($this->postId, 'whereCity', TRUE) : '';
    }

    public function getProvince(): string
    {
        return !empty(get_post_meta($this->postId, 'whereProvince', TRUE)) ? get_post_meta($this->postId, 'whereProvince', TRUE) : '';
    }

    public function getPostalCode(): string
    {
        return !empty(get_post_meta($this->postId, 'wherePostalCode', TRUE)) ? get_post_meta($this->postId, 'wherePostalCode', TRUE) : '';
    }

    public function getCountry(): string
    {
        return !empty(get_post_meta($this->postId, 'whereCountry', TRUE)) ? get_post_meta($this->postId, 'whereCountry', TRUE) : '';
    }

    public function isSameAddress(): bool
    {
        return !empty(get_post_meta($this->postId, 'companySameAddress', TRUE)) ? (bool)get_post_meta($this->postId, 'companySameAddress', TRUE) : false;
    }

    public function getPhone(): string
    {
        return !empty(get_post_meta($this->postId, 'companyPhone', TRUE)) ? get_post_meta($this->postId, 'companyPhone', TRUE) : '';
    }

    public function getFax(): string
    {
        return !empty(get_post_meta($this->postId, 'companyFax', TRUE)) ? get_post_meta($this->postId, 'companyFax', TRUE) : '';
    }

    public function getEmail(): string
    {
        return !empty(get_post_meta($this->postId, 'companyEmail', TRUE)) ? get_post_meta($this->postId, 'companyEmail', TRUE) : '';
    }

    public function getMailAddress(): string
    {
        return !empty(get_post_meta($this->postId, 'companyAddressApply', TRUE)) ? get_post_meta($this->postId, 'companyAddressApply', TRUE) : '';
    }

    public function getURLToApply(): string
    {
        return !empty(get_post_meta($this->postId, 'companyURLApply', TRUE)) ? get_post_meta($this->postId, 'companyURLApply', TRUE) : '';
    }

    public function getSalaryCategory(): string
    {
        return !empty(get_post_meta($this->postId, 'salaryJobCategory', TRUE)) ? get_post_meta($this->postId, 'salaryJobCategory', TRUE) : '';
    }

    public function getCurrency(): string
    {
        return !empty(get_post_meta($this->postId, 'salaryCurrency', TRUE)) ? get_post_meta($this->postId, 'salaryCurrency', TRUE) : '';
    }

    public function getSalaryMin(): string
    {
        return !empty(get_post_meta($this->postId, 'salaryMin', TRUE)) ? get_post_meta($this->postId, 'salaryMin', TRUE) : '';
    }

    public function getSalaryMax(): string
    {
        return !empty(get_post_meta($this->postId, 'salaryMax', TRUE)) ? get_post_meta($this->postId, 'salaryMax', TRUE) : '';
    }

    public function getSalaryRecurrency(): string
    {
        return !empty(get_post_meta($this->postId, 'salaryRecurrency', TRUE)) ? get_post_meta($this->postId, 'salaryRecurrency', TRUE) : '';
    }

    public function getSalaryRecurrencyReadable(): string
    {
        return match ($this->getSalaryRecurrency()) {
            'MONTHLY'  => __('Monthly', 'jobs_posting'),
            'WEEKLY'   => __('Weekly', 'jobs_posting'),
            'DAILY'    => __('Daily', 'jobs_posting'),
            'HOURLY'   => __('Hourly', 'jobs_posting'),
            default    => __('Other', 'jobs_posting'),
        };
    }

    public function getTotalHour(): int
    {
        return !empty(get_post_meta($this->postId, 'jobTotalHour', TRUE)) ? (int)get_post_meta($this->postId, 'jobTotalHour', TRUE) : 0;
    }
}