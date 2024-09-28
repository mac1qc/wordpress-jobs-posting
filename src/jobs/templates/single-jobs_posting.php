<?php

use Mac1qc\WordpressJobsPosting\jobs\component\ContentJob;

get_header();
the_post();

$jobTitle   = $post->post_title;
$postId     = $post->ID;
$contentJob = new ContentJob($post->ID);

$jobDescription        = $contentJob->getDescription();
$jobRequiredSkills     = $contentJob->getRequiredSkills();
$jobPerks              = $contentJob->getPerks();
$jobCompanyName        = $contentJob->getCompanyName();
$jobCompanyDescription = $contentJob->getCompanyDescription();
$jobDisplayEnd         = $contentJob->getDisplayEnd();
$jobType               = $contentJob->getType();
$jobCompanyWebsite     = $contentJob->getWebsite();
$jobLogo               = $contentJob->getLogo();
$jobStreetAddress      = $contentJob->getStreetAddress();
$jobCityAddress        = $contentJob->getCity();
$jobProvinceAddress    = $contentJob->getProvince();
$jobPostalCodeAddress  = $contentJob->getPostalCode();
$jobCountryAddress     = $contentJob->getCountry();
$jobSalaryCategory     = $contentJob->getSalaryCategory();
$jobCurrency           = $contentJob->getCurrency();
$jobMinValue           = $contentJob->getSalaryMin();
$jobMaxValue           = $contentJob->getSalaryMax();
$jobSalaryRecurrency   = $contentJob->getSalaryRecurrency();
$jobCompanySameAddress = $contentJob->isSameAddress();

$forbidenCaracters = [',',' '];
$goodCaracters     = ['.',''];
?>
<script type="application/ld+json">
    {
        "@context" : "https://schema.org/",
        "@type" : "JobPosting",
        "title" : "<?= $jobTitle;?>",
        "description" : "
            <?php if ($jobDescription) {?>
                <h2><?= __('The company', 'jobs_posting')?></h2>
                <?= str_replace('"', '\"', $jobCompanyDescription);?>
            <?php }
            if ($jobDescription) {?>
                <h2><?= __('Job description', 'jobs_posting')?></h2>
                <?= str_replace('"', '\"', $jobDescription);?>
            <?php }
            if ($jobRequiredSkills) {?>
                <h2><?= __('Required skills', 'jobs_posting')?></h2>
                <?= str_replace('"', '\"', $jobRequiredSkills);?>
            <?php }
            if ($jobPerks) {?>
                <h2><?= __('Job perks', 'jobs_posting')?></h2>
                <?= str_replace('"', '\"', $jobPerks);?>
            <?php }?>
        ",
        "identifier": {
            "@type": "PropertyValue",
            "name": "<?= $jobCompanyName;?>",
            "value": "<?= 'gj-' . $postId?>"
        },
        "datePosted" : "<?= get_the_date('Y-m-d');?>",
        "validThrough" : "<?= date("Y-m-d", $jobDisplayEnd);?>T23:59",
        "employmentType" : "<?= $jobType;?>",
        "hiringOrganization" : {
            "@type" : "Organization",
            "name" : "<?= $jobCompanyName;?>",
            "sameAs" : "<?= $jobCompanyWebsite;?>",
            "logo" : "<?= $jobLogo;?>"
        },
        "jobLocation": {
            "@type": "Place",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "<?= $jobStreetAddress;?>",
                "addressLocality": ", <?= $jobCityAddress;?>",
                "addressRegion": "<?= $jobProvinceAddress;?>",
                "postalCode": "<?= $jobPostalCodeAddress;?>",
                "addressCountry": "<?= $jobCountryAddress;?>"
            }
        }<?php if($jobMinValue || $jobMaxValue){?>,
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "<?= $jobCurrency;?>",
                "value": {
                    "@type": "QuantitativeValue",
                    "value": <?php if ($jobMinValue || $jobMaxValue) {
                        echo ($jobMinValue) ? 
                            str_replace($forbidenCaracters, $goodCaracters, $jobMinValue) . ',' :
                            str_replace($forbidenCaracters, $goodCaracters, $jobMaxValue) . ',';
                        } else {
                            echo '0,';
                        }

                        if ($jobMinValue && $jobMaxValue) {
                            ?>
                            "minValue": <?= str_replace($forbidenCaracters, $goodCaracters, $jobMinValue)?>,
                            "maxValue": <?= str_replace($forbidenCaracters, $goodCaracters, $jobMaxValue)?>,
                            <?php
                        }?>
                    "unitText": "<?= $jobSalaryRecurrency?>"
                }
            }
        <?php } else { ?>,
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "USD",
                "value": {
                    "@type": "QuantitativeValue",
                    "value": 0,
                    "unitText": "HOUR"
                }
            }
        <?php }?>
    }
</script>

<h1><?= $jobTitle;?></h1>
<?php if (get_the_post_thumbnail_url(null, 'full')) {?>
    <img src="<?= $jobLogo;?>" alt="<?= $jobTitle;?>" />
<?php }?>

<h2><a href="<?= $jobCompanyWebsite?>" target="_blank"><?= $jobCompanyName?></a></h2>
<strong><?= __('Job type', 'jobs_posting')?></strong> : <?= $contentJob->getReadableType()?>

<?= $jobCityAddress;?>

<?php if ($contentJob->getTotalHour()) {?>
    <strong><?= __('Total hours', 'jobs_posting')?></strong> : <?= $contentJob->getTotalHour()?>
<?php }?>

<?= $contentJob->getPhone();?>

<strong><?= __('Salary', 'jobs_posting')?></strong> : <?php if ($jobMinValue || $jobMaxValue) {?>
    <?= $jobMinValue ? $jobMinValue : $jobMaxValue;?> $
    
    <?php if ($jobMinValue && $jobMaxValue && 
        ($jobMinValue !== $jobMaxValue)
    ) {
        sprintf(__('to %s $', 'jobs_posting'), $jobMaxValue);
    }?> / <?= $contentJob->getSalaryRecurrencyReadable();?>
<?php } else {
    echo ($jobSalaryCategory === 'commission') ? __('Commission', 'jobs_posting') : __('To discuss', 'jobs_posting');
}?>

<strong><?= __('Publish on', 'jobs_posting')?></strong> : <?= get_the_date('Y-m-d');?>

<?php if ($contentJob->getStartDate()) {?>
    <strong><?= __('Starting date', 'jobs_posting')?></strong> : <?= $contentJob->getStartDate()?>
<?php }?>

<?php if ($contentJob->getEmail() || 
    $contentJob->getFax() ||
    $contentJob->getMailAddress()
) {?>
    <a href="#<?= __('apply', 'jobs_posting')?>" class="td_btn"><?= __('Apply now', 'jobs_posting')?></a>
<?php }?>

<?php if ($jobCompanyDescription) {?>
    <h2><?= __('The company', 'jobs_posting')?></h2>
    <?= $jobCompanyDescription;?>
<?php }?>

<?php if($jobDescription){?>
    <h2><?= __('Job description', 'jobs_posting')?></h2>
    <?= $jobDescription;?>
<?php }?>

<?php if($jobRequiredSkills){?>
    <h2><?= __('Required skills', 'jobs_posting')?></h2>
    <?= $jobRequiredSkills;?>
<?php }?>

<?php if($jobPerks){?>
    <h2><?= __('Job perks', 'jobs_posting')?></h2>
    <?= $jobPerks;?>
<?php }?>

<?php if ($contentJob->getEmail() ||
    $contentJob->getFax() ||
    $contentJob->getMailAddress() || 
    $contentJob->getURLToApply()
) {?>
    <a id="<?= __('apply', 'jobs_posting')?>"></a>
    <h2><?= __('Apply now', 'jobs_posting')?></h2>

    <?php if ($contentJob->getURLToApply()) {?>
        <p><strong>
            <?php sprintf(
                __('On our <a href="%s" target="_blank" rel="nofollow noreferrer">website</a>', 'jobs_posting'), 
                $contentJob->getURLToApply()
            );?>
        </strong></p>
    <?php }

    if ($contentJob->getEmail()) {?>
        <p>
            <strong><?= __('By email:', 'jobs_posting')?></strong> 
            <a href="mailto:<?= $contentJob->getEmail()?>"><?= $contentJob->getEmail()?></a>
        </p>
    <?php }

    if ($contentJob->getFax()) {?>
        <p><strong><?= __('By fax:', 'jobs_posting')?></strong> <?= $contentJob->getFax()?></p>
    <?php }

    if ($contentJob->getMailAddress()) {?>
        <p>
            <strong><?= __('By mail:', 'jobs_posting')?></strong><br>
            <?= nl2br($contentJob->getMailAddress())?>
        </p>
    <?php }?>
<?php }?>
<?php get_footer(); ?>
