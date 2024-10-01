<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\component\enum;

enum JobType: string
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