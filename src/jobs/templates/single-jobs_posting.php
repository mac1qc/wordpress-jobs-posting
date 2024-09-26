<?php
get_header();
the_post();

$jobTitle       = $post->post_title;
$jobDescription = (!empty(get_post_meta( $post->ID, 'jobDescription', TRUE )))? wpautop(get_post_meta( $post->ID, 'jobDescription', TRUE )):'';
$jobRequiredSkills = (!empty(get_post_meta( $post->ID, 'jobSkills', TRUE )))? wpautop(get_post_meta( $post->ID, 'jobSkills', TRUE )):'';
$jobAdvantages = (!empty(get_post_meta( $post->ID, 'advantagesDescription', TRUE )))? wpautop(get_post_meta( $post->ID, 'advantagesDescription', TRUE )):'';
$jobCompanyName = (!empty(get_post_meta( $post->ID, 'companyName', TRUE )))?get_post_meta( $post->ID, 'companyName', TRUE ):'';
$jobCompanyDescription = (!empty(get_post_meta( $post->ID, 'companyDescription', TRUE )))?wpautop(get_post_meta( $post->ID, 'companyDescription', TRUE )):'';
$jobEndTime = (!empty(get_post_meta( $post->ID, 'jobEndTime', TRUE )))?get_post_meta( $post->ID, 'jobEndTime', TRUE ):'';
$jobType = (!empty(get_post_meta( $post->ID, 'jobType', TRUE )))?get_post_meta( $post->ID, 'jobType', TRUE ):'';
$jobCompanyWebsite = (!empty(get_post_meta( $post->ID, 'companyWebsite', TRUE )))?get_post_meta( $post->ID, 'companyWebsite', TRUE ):'';
$jobLogo = (!empty(esc_url(get_the_post_thumbnail_url(null, 'full'))))?esc_url(get_the_post_thumbnail_url(null, 'full')):'';
$jobStreetAddress = (!empty(get_post_meta( $post->ID, 'whereStreet', TRUE )))?get_post_meta( $post->ID, 'whereStreet', TRUE ):'';
$jobCityAddress = (!empty(get_post_meta( $post->ID, 'whereCity', TRUE )))?get_post_meta( $post->ID, 'whereCity', TRUE ):'';
$jobProvinceAddress = (!empty(get_post_meta( $post->ID, 'whereProvince', TRUE )))?get_post_meta( $post->ID, 'whereProvince', TRUE ):'';
$jobPostalCodeAddress = (!empty(get_post_meta( $post->ID, 'wherePostalCode', TRUE )))?get_post_meta( $post->ID, 'wherePostalCode', TRUE ):'';
$jobCountryAddress = (!empty(get_post_meta( $post->ID, 'whereCountry', TRUE )))?get_post_meta( $post->ID, 'whereCountry', TRUE ):'';
$salaryType = (!empty(get_post_meta( $post->ID, 'salaryJobType', TRUE )))?get_post_meta( $post->ID, 'salaryJobType', TRUE ):'';
$jobCurrency = (!empty(get_post_meta( $post->ID, 'salaryCurrency', TRUE )))?get_post_meta( $post->ID, 'salaryCurrency', TRUE ):'';
$jobMinValue = (!empty(get_post_meta( $post->ID, 'salaryMin', TRUE )))?get_post_meta( $post->ID, 'salaryMin', TRUE ):'';
$jobMaxValue = (!empty(get_post_meta( $post->ID, 'salaryMax', TRUE )))?get_post_meta( $post->ID, 'salaryMax', TRUE ):'';
$jobSalaryType = (!empty(get_post_meta( $post->ID, 'salaryType', TRUE )))?get_post_meta( $post->ID, 'salaryType', TRUE ):'';
$jobCompanySameAddress = (!empty(get_post_meta( $post->ID, 'companySameAddress', TRUE )))?get_post_meta( $post->ID, 'companySameAddress', TRUE ):'';

$forbidenCaracters = [',',' '];
$goodCaracters     = ['.',''];
?>
<script type="application/ld+json">
{
"@context" : "https://schema.org/",
"@type" : "JobPosting",
"title" : "<?= $jobTitle;?>",
"description" : "
<?php if($jobDescription){?>
<h2><?= __('L\'entreprise', 'offre_emploi')?></h2>
<?= str_replace('"', '\"', $jobCompanyDescription);?>
<?php }
if($jobDescription){?>
<h2><?= __('Votre rôle', 'offre_emploi')?></h2>
<?= str_replace('"', '\"', $jobDescription);?>
<?php }
if($jobRequiredSkills){?>
<h2><?= __('Vos atouts', 'offre_emploi')?></h2>
<?= str_replace('"', '\"', $jobRequiredSkills);?>
<?php }
if($jobAdvantages){?>
<h2><?= __('Vos avantages', 'offre_emploi')?></h2>
<?= str_replace('"', '\"', $jobAdvantages);?>
<?php }?>
",
"identifier": {
"@type": "PropertyValue",
"name": "<?= $jobCompanyName;?>",
"value": "<?= 'gj-'.$post->ID?>"
},
"datePosted" : "<?= get_the_date('Y-m-d');?>",
"validThrough" : "<?= date("Y-m-d", $jobEndTime);?>T23:59",
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
"value": <?php if($jobMinValue || $jobMaxValue){
echo ($jobMinValue)?str_replace($forbidenCaracters,$goodCaracters,$jobMinValue).',':str_replace($forbidenCaracters,$goodCaracters,$jobMaxValue).',';
}else{
echo '0,';
}
if($jobMinValue && $jobMaxValue){
?>
"minValue": <?= str_replace($forbidenCaracters,$goodCaracters,$jobMinValue)?>,
"maxValue": <?= str_replace($forbidenCaracters,$goodCaracters,$jobMaxValue)?>,
<?php
}?>
"unitText": "<?= $jobSalaryType?>"
}
}
<?php }else{ ?>,
"baseSalary": {
"@type": "MonetaryAmount",
"currency": "CAD",
"value": {
"@type": "QuantitativeValue",
"value": 0,
"unitText": "HOUR"
}
}
<?php
}?>
}
</script>

<h1><?= $jobTitle;?></h1>
<?php if( get_the_post_thumbnail_url(null, 'full') != false ) {?><img src="<?= $jobLogo;?>" alt="<?= $jobTitle;?>" /><?php }?>
<h2><a href="<?= $jobCompanyWebsite?>" target="_blank"><?= $jobCompanyName?></a></h2>
<strong><?= __('Type d\'emploi', 'offre_emploi')?></strong> : <?php
switch($jobType){
case 'FULL_TIME':
echo __('Temps plein', 'offre_emploi');
break;
case 'PART_TIME':
echo __('Temps partiel', 'offre_emploi');
break;
case 'CONTRACTOR':
echo __('Contractuel', 'offre_emploi');
break;
case 'TEMPORARY':
echo __('Temporaire', 'offre_emploi');
break;
case 'INTERN':
echo __('Stagière', 'offre_emploi');
break;
case 'VOLUNTEER':
echo __('Bénévole', 'offre_emploi');
break;
case 'PER_DIEM':
echo __('À la journée', 'offre_emploi');
break;
default:
echo __('Autre', 'offre_emploi');
break;
}
?>
<?= $jobCityAddress;?>
<?php if(get_post_meta( $post->ID, 'jobTotalHour', TRUE )){?>
<strong><?= __('Nombre d\'heures', 'offre_emploi')?></strong> : <?= get_post_meta( $post->ID, 'jobTotalHour', TRUE )?>
<?php }?>
<?= (get_post_meta( $post->ID, 'companyPhone', TRUE ))?get_post_meta( $post->ID, 'companyPhone', TRUE ):'';?>
<strong><?= __('Salaire', 'offre_emploi')?></strong> : <?php if($jobMinValue || $jobMaxValue){?>
<?= ($jobMinValue)?$jobMinValue:$jobMaxValue;?> $
<?php if($jobMinValue && $jobMaxValue && ($jobMinValue !== $jobMaxValue)){echo __('à ', 'offre_emploi').$jobMaxValue.' $';}?> / <?php switch($jobSalaryType){
case 'HOUR':
echo __('Heure', 'offre_emploi');
break;
case 'DAY':
echo __('Jour', 'offre_emploi');
break;
case 'WEEK':
echo __('Semaine', 'offre_emploi');
break;
case 'MONTH':
echo __('Mois', 'offre_emploi');
break;
case 'YEAR':
echo __('Année', 'offre_emploi');
break;
}?>
<?php }else{
echo ($salaryType === 'commission')?__('À commission', 'offre_emploi'):__('À discuter', 'offre_emploi');
}?>
<strong><?= __('Publié le', 'offre_emploi')?></strong> : <?= get_the_date('Y-m-d');?>
<?php if(get_post_meta( $post->ID, 'jobStartTime', TRUE )){?>
<strong><?= __('Date d\'entrée en fonction', 'offre_emploi')?></strong> : <?= get_post_meta( $post->ID, 'jobStartTime', TRUE )?>
<?php }?>
<?php if(get_post_meta( $post->ID, 'companyEmail', TRUE ) || get_post_meta( $post->ID, 'companyFax', TRUE ) || get_post_meta( $post->ID, 'companyAddressApply', TRUE )){?>
<a href="#<?= __('postuler', 'offre_emploi')?>" class="td_btn"><?= __('Postuler maintenant', 'offre_emploi')?></a>
<?php }?>

<?php if($jobCompanyDescription){?>
<h2><?= __('L\'entreprise', 'offre_emploi')?></h2>
<?= $jobCompanyDescription;?>
<?php }?>

<?php if($jobDescription){?>
<h2><?= __('Votre rôle', 'offre_emploi')?></h2>
<?= $jobDescription;?>
<?php }?>

<?php if($jobRequiredSkills){?>
<h2><?= __('Vos atouts', 'offre_emploi')?></h2>
<?= $jobRequiredSkills;?>
<?php }?>

<?php if($jobAdvantages){?>
<h2><?= __('Vos avantages', 'offre_emploi')?></h2>
<?= $jobAdvantages;?>
<?php }?>

<?php if(get_post_meta( $post->ID, 'companyEmail', TRUE ) || get_post_meta( $post->ID, 'companyFax', TRUE ) || get_post_meta( $post->ID, 'companyAddressApply', TRUE ) || get_post_meta( $post->ID, 'companyURLApply', TRUE )){?>
<a id="<?= __('postuler', 'offre_emploi')?>"></a>
<h2><?= __('Postuler maintenant', 'offre_emploi')?></h2>

<?php if(get_post_meta( $post->ID, 'companyURLApply', TRUE )){?>
<p><strong><?php printf( __('Sur notre <a href="%s" target="_blank" rel="nofollow noreferrer">site internet</a>', 'offre_emploi'), get_post_meta( $post->ID, 'companyURLApply', TRUE ));?></strong></p>
<?php }
if(get_post_meta( $post->ID, 'companyEmail', TRUE )){?>
<p><strong><?= __('Par courriel', 'offre_emploi')?></strong> : <a href="mailto:<?= get_post_meta( $post->ID, 'companyEmail', TRUE )?>"><?= get_post_meta( $post->ID, 'companyEmail', TRUE )?></a></p>
<?php }
if(get_post_meta( $post->ID, 'companyFax', TRUE )){?>
<p><strong><?= __('Par télécopieur', 'offre_emploi')?></strong> : <?= get_post_meta( $post->ID, 'companyFax', TRUE )?></p>
<?php }
if(get_post_meta( $post->ID, 'companyAddressApply', TRUE )){?>
<p><strong><?= __('Par courrier', 'offre_emploi')?></strong> :<br><?= nl2br(get_post_meta( $post->ID, 'companyAddressApply', TRUE ))?></p>
<?php }?>
<?php }?>
<?php get_footer(); ?>
