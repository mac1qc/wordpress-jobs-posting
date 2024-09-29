<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\component\enum;

enum SalaryRecurrency: string
{
    case FULL_TIME  = 'FULL_TIME';
    case PART_TIME  = 'PART_TIME';
    case CONTRACTOR = 'CONTRACTOR';
    case TEMPORARY  = 'TEMPORARY';
    case INTERN     = 'INTERN';
    case VOLUNTEER  = 'VOLUNTEER';
    case PER_DIEM   = 'PER_DIEM';
    case OTHER      = 'OTHER';
}

/*class SalaryRecurrency
{
    public const FULL_TIME  = 'FULL_TIME';
    public const PART_TIME  = 'PART_TIME';
    public const CONTRACTOR = 'CONTRACTOR';
    public const TEMPORARY  = 'TEMPORARY';
    public const INTERN     = 'INTERN';
    public const VOLUNTEER  = 'VOLUNTEER';
    public const PER_DIEM   = 'PER_DIEM';
    public const OTHER      = 'OTHER';
}*/