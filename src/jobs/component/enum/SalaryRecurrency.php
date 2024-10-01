<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\component\enum;

enum SalaryRecurrency: string
{
    case HOUR  = 'HOUR';
    case DAY   = 'DAY';
    case WEEK  = 'WEEK';
    case MONTH = 'MONTH';
    case YEAR  = 'YEAR';
}