<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\admin;

use Mac1qc\WordpressJobsPosting\jobs\component\ContentJob;
use Mac1qc\WordpressJobsPosting\jobs\component\enum\JobType;
use Mac1qc\WordpressJobsPosting\jobs\component\enum\SalaryRecurrency;

class AdminJobs
{
    private ContentJob $contentJob;

    public function __construct(private string $postType)
    {
        add_meta_box('job_meta', __('Job informations', 'jobs_posting'), [$this, 'jobMeta'], $postType, 'normal', 'low');
        add_meta_box('company_meta', __('Company informations', 'jobs_posting'), [$this, 'companyMeta'], $postType, 'normal', 'low');
        add_meta_box('advantages_meta', __('Job benifits', 'jobs_posting'), [$this, 'perksMeta'], $postType, 'normal', 'low');
        add_meta_box('where_meta', __('Job location', 'jobs_posting'), [$this, 'whereMeta'], $postType, 'normal', 'low');
        add_meta_box('salary_meta', __('Salary', 'jobs_posting'), [$this, 'salaryMeta'], $postType, 'normal', 'low');

        add_action('admin_footer', [$this, 'editJobScripts']);
        add_action('save_post', [$this, 'saveJob']);
    }

    public function jobMeta(): void
    {
        global $post;

        $postId = $post ? $post->ID : 0;

        $this->contentJob = new ContentJob($postId);

        $jobDisplayEnd = $this->contentJob->getDisplayEnd();
        $jobType       = $this->contentJob->getType();
        ?>
        <div>
            <label for="jobDisplayEnd"><?= __('Show until:', 'jobs_posting')?></label>
            <input name="jobDisplayEnd" id="jobDisplayEnd" value="<?= $jobDisplayEnd ? date('Y-m-d', (int)$jobDisplayEnd) : ''; ?>" type="date" />
        </div>

        <div>
            <label for="jobStartTime"><?= __('Start working on:', 'jobs_posting')?></label>
            <input name="jobStartTime" id="jobStartTime" value="<?= $this->contentJob->getStartDate(); ?>" type="text" />
        </div>

        <div>
            <label for="jobType"><?= __('Job type:', 'jobs_posting')?></label>
            <select name="jobType" id="jobType">
                <option value="<?= JobType::FULL_TIME->value?>"<?= $jobType === JobType::FULL_TIME->value ? ' selected="selected"' : '';?>>
                    <?= __('Full time', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::PART_TIME->value?>"<?= $jobType === JobType::PART_TIME->value ? ' selected="selected"' : '';?>>
                    <?= __('Part time', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::CONTRACTOR->value?>"<?= $jobType === JobType::CONTRACTOR->value ? ' selected="selected"' : '';?>>
                    <?= __('Contractor', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::TEMPORARY->value?>"<?= $jobType === JobType::TEMPORARY->value ? ' selected="selected"' : '';?>>
                    <?= __('Temporary', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::INTERN->value?>"<?= $jobType === JobType::INTERN->value ? ' selected="selected"' : '';?>>
                    <?= __('Intern', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::VOLUNTEER->value?>"<?= $jobType === JobType::VOLUNTEER->value ? ' selected="selected"' : '';?>>
                    <?= __('Volunteer', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::PER_DIEM->value?>"<?= $jobType === JobType::PER_DIEM->value ? ' selected="selected"' : '';?>>
                    <?= __('Per diem', 'jobs_posting')?>
                </option>
                <option value="<?= JobType::OTHER->value?>"<?= $jobType === JobType::OTHER->value ? ' selected="selected"' : '';?>>
                    <?= __('Other', 'jobs_posting')?>
                </option>
            </select>
        </div>

        <div>
            <label for="jobDescription"><?= __('Job description:', 'jobs_posting')?></label>
            <?php wp_editor($this->contentJob->getDescription(), 'jobDescription', ['wpautop'=>true, 'teeny'=>true]);?>
        </div>

        <div>
            <label for="jobSkills"><?= __('Required skills:', 'jobs_posting')?></label>
            <?php wp_editor($this->contentJob->getRequiredSkills(), 'jobSkills', ['wpautop'=>true, 'teeny'=>true]); ?>
        </div>

        <div>
            <label for="jobTotalHour"><?= __('Total hours a week:', 'jobs_posting')?></label>
            <input name="jobTotalHour" id="jobTotalHour" value="<?= $this->contentJob->getTotalHour(); ?>" type="number" min="0" />
        </div>
        <?php
    }
    
    public function companyMeta(): void
    {
        ?>
        <div>
            <label for="companyName"><?= __('Company name:', 'jobs_posting')?></label>
            <input name="companyName" id="companyName" value="<?= $this->contentJob->getCompanyName(); ?>" type="text" />
        </div>
        
        <div>
            <label for="companyWebsite"><?= __('Site internet :', 'jobs_posting')?></label>
            <input name="companyWebsite" id="companyWebsite" value="<?= $this->contentJob->getWebsite(); ?>" type="text" />
        </div>

        <div>
            <label for="companySameAddress"><input type="checkbox" name="companySameAddress" id="companySameAddress" value="true"<?= $this->contentJob->isSameAddress() ? ' checked="checked"' : '';?>> <?= __('Company address <strong>IS NOT</strong> the same than where the employee will work', 'jobs_posting')?></label>
        </div>

        <div id="divCompanyAddress">
            <label for="companyAddress"><?= __('Address:', 'jobs_posting')?></label>
            <textarea name="companyAddress" id="companyAddress"><?= $this->contentJob->getCompanyAddress(); ?></textarea>
        </div>

        <div>
            <label for="companyEmail"><?= __('Email:', 'jobs_posting')?></label>
            <input name="companyEmail" id="companyEmail" value="<?= $this->contentJob->getEmail(); ?>" type="text" />
        </div>

        <div>
            <label for="companyAddressApply"><?= __('Mail address:', 'jobs_posting')?></label>
            <textarea name="companyAddressApply" id="companyAddressApply"><?= $this->contentJob->getMailAddress(); ?></textarea>
        </div>

        <div>
            <label for="companyPhone"><?= __('Phone:', 'jobs_posting')?></label>
            <input name="companyPhone" id="companyPhone" value="<?= $this->contentJob->getPhone(); ?>" type="tel" />
        </div>

        <div>
            <label for="companyFax"><?= __('Fax:', 'jobs_posting')?></label>
            <input name="companyFax" id="companyFax" value="<?= $this->contentJob->getFax(); ?>" type="tel" />
        </div>

        <div>
            <label for="companyURLApply"><?= __('Company URL to apply:', 'jobs_posting')?></label>
            <input name="companyURLApply" id="companyURLApply" value="<?= $this->contentJob->getURLToApply(); ?>" type="text" />
        </div>

        <div>
            <label for="companyDescription"><?= __('Company description:', 'jobs_posting')?></label>
            <?php wp_editor($this->contentJob->getCompanyDescription(), 'companyDescription', ['wpautop' => true, 'teeny' => true]);?>
        </div>
        <?php
    }

    public function perksMeta(): void
    {
        ?>
        <div>
            <label for="perksDescription"><?= __('Job perks:', 'jobs_posting')?></label>
            <?php wp_editor($this->contentJob->getPerks(), 'perksDescription', ['wpautop'=>true, 'teeny'=>true]); ?>
        </div>
        <?php
    }

    public function whereMeta(): void
    {
        $whereProvince = $this->contentJob->getProvince();
        $whereCountry  = $this->contentJob->getCountry();
        ?>
        <div>
            <label for="whereCountry"><?= __('Country:', 'jobs_posting')?></label>
            <select name="whereCountry" id="whereCountry">
                <option value="CA" <?= $whereCountry === 'CA' ? ' selected="selected"' : '';?>>
                    <?= __('Canada', 'jobs_posting')?>
                </option>
                <option value="US" <?= $whereCountry === 'US' ? ' selected="selected"' : '';?>>
                    <?= __('United States', 'jobs_posting')?>
                </option>
            </select>
        </div>

        <div>
            <label for="whereProvince"><?= __('Province/State:', 'jobs_posting')?></label>
            <select name="whereProvince" id="whereProvince">
                <option value="">--- <?= __('CANADA', 'jobs_posting')?> ---</option>
                <option value="AB" <?= $whereProvince === 'AB' ? ' selected="selected"' : '';?>>
                    <?= __('Alberta', 'jobs_posting')?>
                </option>
                <option value="BC" <?= $whereProvince === 'BC' ? ' selected="selected"' : '';?>>
                    <?= __('British Columbia', 'jobs_posting')?>
                </option>
                <option value="PE" <?= $whereProvince === 'PE' ? ' selected="selected"' : '';?>>
                    <?= __('Prince Edward Island', 'jobs_posting')?>
                </option>
                <option value="MB" <?= $whereProvince === 'MB' ? ' selected="selected"' : '';?>>
                    <?= __('Manitoba', 'jobs_posting')?>
                </option>
                <option value="NB" <?= $whereProvince === 'NB' ? ' selected="selected"' : '';?>>
                    <?= __('New Brunswick', 'jobs_posting')?>
                </option>
                <option value="NS" <?= $whereProvince === 'NS' ? ' selected="selected"' : '';?>>
                    <?= __('Nova Scotia', 'jobs_posting')?>
                </option>
                <option value="NU" <?= $whereProvince === 'NU' ? ' selected="selected"' : '';?>>
                    <?= __('Nunavut', 'jobs_posting')?>
                </option>
                <option value="ON" <?= $whereProvince === 'ON' ? ' selected="selected"' : '';?>>
                    <?= __('Ontario', 'jobs_posting')?>
                </option>
                <option value="QC" <?= $whereProvince === 'QC' ? ' selected="selected"' : '';?>>
                    <?= __('Québec', 'jobs_posting')?>
                </option>
                <option value="SK" <?= $whereProvince === 'SK' ? ' selected="selected"' : '';?>>
                    <?= __('Saskatchewan', 'jobs_posting')?>
                </option>
                <option value="NL" <?= $whereProvince === 'NL' ? ' selected="selected"' : '';?>>
                    <?= __('Newfoundland and Labrador', 'jobs_posting')?>
                </option>
                <option value="NT" <?= $whereProvince === 'NT' ? ' selected="selected"' : '';?>>
                    <?= __('North West Territories', 'jobs_posting')?>
                </option>
                <option value="YT" <?= $whereProvince === 'YT' ? ' selected="selected"' : '';?>>
                    <?= __('Yukon', 'jobs_posting')?>
                </option>
                <option value="">--- <?= __('UNITED STATES', 'jobs_posting')?> ---</option>
                <option value="AL" <?= $whereProvince === 'AL' ? ' selected="selected"' : '';?>>
                    <?= __('Alabama', 'jobs_posting')?>
                </option>
                <option value="AK" <?= $whereProvince === 'AK' ? ' selected="selected"' : '';?>>
                    <?= __('Alaska', 'jobs_posting')?>
                </option>
                <option value="AZ" <?= $whereProvince === 'AZ' ? ' selected="selected"' : '';?>>
                    <?= __('Arizona', 'jobs_posting')?>
                </option>
                <option value="AR" <?= $whereProvince === 'AR' ? ' selected="selected"' : '';?>>
                    <?= __('Arkansas', 'jobs_posting')?>
                </option>
                <option value="CA" <?= $whereProvince === 'CA' ? ' selected="selected"' : '';?>>
                    <?= __('California', 'jobs_posting')?>
                </option>
                <option value="CO" <?= $whereProvince === 'CO' ? ' selected="selected"' : '';?>>
                    <?= __('Colorado', 'jobs_posting')?>
                </option>
                <option value="CT" <?= $whereProvince === 'CT' ? ' selected="selected"' : '';?>>
                    <?= __('Connecticut', 'jobs_posting')?>
                </option>
                <option value="DE" <?= $whereProvince === 'DE' ? ' selected="selected"' : '';?>>
                    <?= __('Delaware', 'jobs_posting')?>
                </option>
                <option value="FL" <?= $whereProvince === 'FL' ? ' selected="selected"' : '';?>>
                    <?= __('Florida', 'jobs_posting')?>
                </option>
                <option value="GA" <?= $whereProvince === 'GA' ? ' selected="selected"' : '';?>>
                    <?= __('Georgia', 'jobs_posting')?>
                </option>
                <option value="HI" <?= $whereProvince === 'HI' ? ' selected="selected"' : '';?>>
                    <?= __('Hawaii', 'jobs_posting')?>
                </option>
                <option value="ID" <?= $whereProvince === 'ID' ? ' selected="selected"' : '';?>>
                    <?= __('Idaho', 'jobs_posting')?>
                </option>
                <option value="IL" <?= $whereProvince === 'IL' ? ' selected="selected"' : '';?>>
                    <?= __('Illinois', 'jobs_posting')?>
                </option>
                <option value="IN" <?= $whereProvince === 'IN' ? ' selected="selected"' : '';?>>
                    <?= __('Indiana', 'jobs_posting')?>
                </option>
                <option value="IA" <?= $whereProvince === 'IA' ? ' selected="selected"' : '';?>>
                    <?= __('Iowa', 'jobs_posting')?>
                </option>
                <option value="KS" <?= $whereProvince === 'KS' ? ' selected="selected"' : '';?>>
                    <?= __('Kansas', 'jobs_posting')?>
                </option>
                <option value="KY" <?= $whereProvince === 'KY' ? ' selected="selected"' : '';?>>
                    <?= __('Kentucky', 'jobs_posting')?>
                </option>
                <option value="LA" <?= $whereProvince === 'LA' ? ' selected="selected"' : '';?>>
                    <?= __('Louisiana', 'jobs_posting')?>
                </option>
                <option value="ME" <?= $whereProvince === 'ME' ? ' selected="selected"' : '';?>>
                    <?= __('Maine', 'jobs_posting')?>
                </option>
                <option value="MD" <?= $whereProvince === 'MD' ? ' selected="selected"' : '';?>>
                    <?= __('Maryland', 'jobs_posting')?>
                </option>
                <option value="MA" <?= $whereProvince === 'MA' ? ' selected="selected"' : '';?>>
                    <?= __('Massachusetts', 'jobs_posting')?>
                </option>
                <option value="MI" <?= $whereProvince === 'MI' ? ' selected="selected"' : '';?>>
                    <?= __('Michigan', 'jobs_posting')?>
                </option>
                <option value="MN" <?= $whereProvince === 'MN' ? ' selected="selected"' : '';?>>
                    <?= __('Minnesota', 'jobs_posting')?>
                </option>
                <option value="MS" <?= $whereProvince === 'MS' ? ' selected="selected"' : '';?>>
                    <?= __('Mississippi', 'jobs_posting')?>
                </option>
                <option value="MO" <?= $whereProvince === 'MO' ? ' selected="selected"' : '';?>>
                    <?= __('Missouri', 'jobs_posting')?>
                </option>
                <option value="MT" <?= $whereProvince === 'MT' ? ' selected="selected"' : '';?>>
                    <?= __('Montana', 'jobs_posting')?>
                </option>
                <option value="NE" <?= $whereProvince === 'NE' ? ' selected="selected"' : '';?>>
                    <?= __('Nebraska', 'jobs_posting')?>
                </option>
                <option value="NV" <?= $whereProvince === 'NV' ? ' selected="selected"' : '';?>>
                    <?= __('Nevada', 'jobs_posting')?>
                </option>
                <option value="NH" <?= $whereProvince === 'NH' ? ' selected="selected"' : '';?>>
                    <?= __('New Hampshire', 'jobs_posting')?>
                </option>
                <option value="NJ" <?= $whereProvince === 'NJ' ? ' selected="selected"' : '';?>>
                    <?= __('New Jersey', 'jobs_posting')?>
                </option>
                <option value="NM" <?= $whereProvince === 'NM' ? ' selected="selected"' : '';?>>
                    <?= __('New Mexico', 'jobs_posting')?>
                </option>
                <option value="NY" <?= $whereProvince === 'NY' ? ' selected="selected"' : '';?>>
                    <?= __('New York', 'jobs_posting')?>
                </option>
                <option value="NC" <?= $whereProvince === 'NC' ? ' selected="selected"' : '';?>>
                    <?= __('North Carolina', 'jobs_posting')?>
                </option>
                <option value="ND" <?= $whereProvince === 'ND' ? ' selected="selected"' : '';?>>
                    <?= __('North Dakota', 'jobs_posting')?>
                </option>
                <option value="OH" <?= $whereProvince === 'OH' ? ' selected="selected"' : '';?>>
                    <?= __('Ohio', 'jobs_posting')?>
                </option>
                <option value="OK" <?= $whereProvince === 'OK' ? ' selected="selected"' : '';?>>
                    <?= __('Oklahoma', 'jobs_posting')?>
                </option>
                <option value="OR" <?= $whereProvince === 'OR' ? ' selected="selected"' : '';?>>
                    <?= __('Oregon', 'jobs_posting')?>
                </option>
                <option value="PA" <?= $whereProvince === 'PA' ? ' selected="selected"' : '';?>>
                    <?= __('Pennsylvanie', 'jobs_posting')?>
                </option>
                <option value="RI" <?= $whereProvince === 'RI' ? ' selected="selected"' : '';?>>
                    <?= __('Rhode Island', 'jobs_posting')?>
                </option>
                <option value="SC" <?= $whereProvince === 'SC' ? ' selected="selected"' : '';?>>
                    <?= __('South Carolina', 'jobs_posting')?>
                </option>
                <option value="SD" <?= $whereProvince === 'SD' ? ' selected="selected"' : '';?>>
                    <?= __('South Dakota', 'jobs_posting')?>
                </option>
                <option value="TN" <?= $whereProvince === 'TN' ? ' selected="selected"' : '';?>>
                    <?= __('Tennessee', 'jobs_posting')?>
                </option>
                <option value="TX" <?= $whereProvince === 'TX' ? ' selected="selected"' : '';?>>
                    <?= __('Texas', 'jobs_posting')?>
                </option>
                <option value="UT" <?= $whereProvince === 'UT' ? ' selected="selected"' : '';?>>
                    <?= __('Utah', 'jobs_posting')?>
                </option>
                <option value="VT" <?= $whereProvince === 'VT' ? ' selected="selected"' : '';?>>
                    <?= __('Vermont', 'jobs_posting')?>
                </option>
                <option value="VA" <?= $whereProvince === 'VA' ? ' selected="selected"' : '';?>>
                    <?= __('Virginie', 'jobs_posting')?>
                </option>
                <option value="WA" <?= $whereProvince === 'WA' ? ' selected="selected"' : '';?>>
                    <?= __('Washington', 'jobs_posting')?>
                </option>
                <option value="WV" <?= $whereProvince === 'WV' ? ' selected="selected"' : '';?>>
                    <?= __('West Virginia', 'jobs_posting')?>
                </option>
                <option value="WI" <?= $whereProvince === 'WI' ? ' selected="selected"' : '';?>>
                    <?= __('Wisconsin', 'jobs_posting')?>
                </option>
                <option value="WY" <?= $whereProvince === 'WY' ? ' selected="selected"' : '';?>>
                    <?= __('Wyoming', 'jobs_posting')?>
                </option>
            </select>
        </div>
        
        <div>
            <label for="whereStreet"><?= __('Street:', 'jobs_posting')?></label>
            <input name="whereStreet" id="whereStreet" value="<?= $this->contentJob->getStreetAddress(); ?>" type="text" />
        </div>

        <div>
            <label for="whereCity"><?= __('City:', 'jobs_posting')?></label>
            <input name="whereCity" id="whereCity" value="<?= $this->contentJob->getCity(); ?>" type="text" />
        </div>
        
        <div>
            <label for="wherePostalCode"><?= __('ZIP:', 'jobs_posting')?></label>
            <input name="wherePostalCode" id="wherePostalCode" value="<?= $this->contentJob->getPostalCode(); ?>" type="text" placeholder="<?= __('A1A 1A1', 'jobs_posting')?>" maxlength="7" />
        </div>
        <?php
    }

    public function salaryMeta(): void
    {
        $salaryJobCategory = $this->contentJob->getSalaryCategory();
        $salaryCurrency    = $this->contentJob->getCurrency();
        $salaryRecurrency  = $this->contentJob->getSalaryRecurrency();
        ?>
        <div>
            <label for="salaryJobCategory"><?= __('Salary category:', 'jobs_posting')?></label>
            <select name="salaryJobCategory" id="salaryJobCategory">
                <option <?= $salaryJobCategory === 'normal' ? ' selected="selected"' : '';?> value="normal">
                    <?= __('Normal', 'jobs_posting')?>
                </option>
                <option <?= $salaryJobCategory === 'discuss' ? ' selected="selected"' : '';?> value="discuss">
                    <?= __('To discuss', 'jobs_posting')?>
                </option>
                <option <?= $salaryJobCategory === 'commission' ? ' selected="selected"' : '';?> value="commission">
                    <?= __('Commisson', 'jobs_posting')?>
                </option>
            </select>
        </div>
        
        <div>
            <label for="salaryCurrency"><?= __('Currency:', 'jobs_posting')?></label>
            <select name="salaryCurrency" id="salaryCurrency">
                <option <?= $salaryCurrency === 'CAD' ? ' selected="selected"' : '';?>>
                    <?= __('CAD', 'jobs_posting')?>
                </option>
                <option <?= $salaryCurrency === 'USD' ? ' selected="selected"' : '';?>>
                    <?= __('USD', 'jobs_posting')?>
                </option>
            </select>
        </div>

        <div>
            <label for="salaryMin"><?= __('Minimum salary:', 'jobs_posting')?></label>
            <input name="salaryMin" id="salaryMin" value="<?= $this->contentJob->getSalaryMin(); ?>" type="text" min="0" />
        </div>

        <div>
            <label for="salaryMax"><?= __('Maximum salary:', 'jobs_posting')?></label>
            <input name="salaryMax" id="salaryMax" value="<?= $this->contentJob->getSalaryMax(); ?>" type="text" min="0" />
        </div>

        <div>
            <label for="salaryRecurrency"><?= __('Salary type:', 'jobs_posting')?></label>
            <select name="salaryRecurrency" id="salaryRecurrency">
                <option value="<?= SalaryRecurrency::HOUR->value?>"<?= $salaryRecurrency === SalaryRecurrency::HOUR->value ? ' selected="selected"' : '';?>>
                    <?= __('Hourly', 'jobs_posting')?>
                </option>
                <option value="<?= SalaryRecurrency::DAY->value?>"<?= $salaryRecurrency === SalaryRecurrency::DAY->value ? ' selected="selected"' : '';?>>
                    <?= __('Daily', 'jobs_posting')?>
                </option>
                <option value="<?= SalaryRecurrency::WEEK->value?>"<?= $salaryRecurrency === SalaryRecurrency::WEEK->value ? ' selected="selected"' : '';?>>
                    <?= __('Weekly', 'jobs_posting')?>
                </option>
                <option value="<?= SalaryRecurrency::MONTH->value?>"<?= $salaryRecurrency === SalaryRecurrency::MONTH->value ? ' selected="selected"' : '';?>>
                    <?= __('Monthly', 'jobs_posting')?>
                </option>
                <option value="<?= SalaryRecurrency::YEAR->value?>"<?= $salaryRecurrency ===  SalaryRecurrency::YEAR->value ? ' selected="selected"' : '';?>>
                    <?= __('Yearly', 'jobs_posting')?>
                </option>
            </select>
        </div>
        <?php
    }

    public function editJobScripts(): void
    {
        ?>
        <style type="text/css">
            #job_meta input[type="date"],
            #job_meta input[type="datetime-local"],
            #job_meta input[type="datetime"],
            #job_meta input[type="email"],
            #job_meta input[type="month"],
            #job_meta input[type="number"],
            #job_meta input[type="password"],
            #job_meta input[type="search"],
            #job_meta input[type="tel"],
            #job_meta input[type="text"],
            #job_meta input[type="time"],
            #job_meta input[type="url"],
            #job_meta input[type="week"],
            #company_meta input[type="date"],
            #company_meta input[type="datetime-local"],
            #company_meta input[type="datetime"],
            #company_meta input[type="email"],
            #company_meta input[type="month"],
            #company_meta input[type="number"],
            #company_meta input[type="password"],
            #company_meta input[type="search"],
            #company_meta input[type="tel"],
            #company_meta input[type="text"],
            #company_meta input[type="time"],
            #company_meta input[type="url"],
            #company_meta input[type="week"],
            #advantages_meta input[type="date"],
            #advantages_meta input[type="datetime-local"],
            #advantages_meta input[type="datetime"],
            #advantages_meta input[type="email"],
            #advantages_meta input[type="month"],
            #advantages_meta input[type="number"],
            #advantages_meta input[type="password"],
            #advantages_meta input[type="search"],
            #advantages_meta input[type="tel"],
            #advantages_meta input[type="text"],
            #advantages_meta input[type="time"],
            #advantages_meta input[type="url"],
            #advantages_meta input[type="week"],
            #where_meta input[type="date"],
            #where_meta input[type="datetime-local"],
            #where_meta input[type="datetime"],
            #where_meta input[type="email"],
            #where_meta input[type="month"],
            #where_meta input[type="number"],
            #where_meta input[type="password"],
            #where_meta input[type="search"],
            #where_meta input[type="tel"],
            #where_meta input[type="text"],
            #where_meta input[type="time"],
            #where_meta input[type="url"],
            #where_meta input[type="week"],
            #salary_meta input[type="date"],
            #salary_meta input[type="datetime-local"],
            #salary_meta input[type="datetime"],
            #salary_meta input[type="email"],
            #salary_meta input[type="month"],
            #salary_meta input[type="number"],
            #salary_meta input[type="password"],
            #salary_meta input[type="search"],
            #salary_meta input[type="tel"],
            #salary_meta input[type="text"],
            #salary_meta input[type="time"],
            #salary_meta input[type="url"],
            #salary_meta input[type="week"]{
                width: 50%;
            }
            #company_meta textarea{
                width:  50%;
                height: 100px;
                resize: none;
            }
            #job_meta label,
            #company_meta label,
            #advantages_meta label,
            #where_meta label,
            #salary_meta label{
                display:     block;
                font-weight: bold;
                margin-top:  10px;
            }
        </style>

        <script type="text/javascript">
            jQuery(document).on('ready', function() {
                changeVisibilityChecked('#companySameAddress','#divCompanyAddress');

                jQuery('#companySameAddress').on('change', function() {
                    changeVisibilityChecked('#companySameAddress','#divCompanyAddress');
                });

                function changeVisibilityChecked(source = null, target = null) {
                    var sourceChecked = jQuery(source).attr('checked');
                    
                    if (typeof sourceChecked !== typeof undefined && sourceChecked !== false) {
                        jQuery(target).css({'display':'block'});
                    } else {
                        jQuery(target).css({'display':'none'});
                    }
                }

                jQuery('body').on('submit.edit-post', '#post',function(){
                    if (jQuery('#_thumbnail_id').val() <= 0) {
                        window.alert('<?= __('A thumbnail is required', 'jobs_posting')?>');
                        jQuery('#major-publishing-actions .spinner').hide();
                        jQuery('#major-publishing-actions').find(':button, :submit, a.submitdelete, #post-preview').removeClass('disabled');
                        return false;
                    }
                });
            });
        </script>
        <?php
    }

    public function saveJob(): void
    {
        if (isset($_POST['jobStartTime'])) {
            global $post;

            $postId = $post->ID;

            $jobDisplayEndEpoch = new \DateTime($_POST['jobDisplayEnd'].' 23:59:59');
            
            update_post_meta($postId,'jobDisplayEnd', $jobDisplayEndEpoch->format('U'));
            update_post_meta($postId,'jobStartTime', $_POST['jobStartTime']);
            update_post_meta($postId,'jobType', $_POST['jobType']);
            update_post_meta($postId,'jobDescription', $_POST['jobDescription']);
            update_post_meta($postId,'jobSkills', $_POST['jobSkills']);
            update_post_meta($postId,'jobTotalHour', $_POST['jobTotalHour']);
            update_post_meta($postId,'companyName', $_POST['companyName']);
            update_post_meta($postId,'companyWebsite', $_POST['companyWebsite']);
            update_post_meta($postId,'companyAddress', $_POST['companyAddress']);
            update_post_meta($postId,'companyEmail', $_POST['companyEmail']);
            update_post_meta($postId,'companyAddressApply', $_POST['companyAddressApply']);
            update_post_meta($postId,'companyPhone', $_POST['companyPhone']);
            update_post_meta($postId,'companyFax', $_POST['companyFax']);
            update_post_meta($postId,'companyURLApply', $_POST['companyURLApply']);
            update_post_meta($postId,'companyDescription', $_POST['companyDescription']);
            update_post_meta($postId,'perksDescription', $_POST['perksDescription']);
            update_post_meta($postId,'whereStreet', $_POST['whereStreet']);
            update_post_meta($postId,'whereCity', $_POST['whereCity']);
            update_post_meta($postId,'whereProvince', $_POST['whereProvince']);
            update_post_meta($postId,'wherePostalCode', $_POST['wherePostalCode']);
            update_post_meta($postId,'whereCountry', $_POST['whereCountry']);
            update_post_meta($postId,'salaryJobCategory', $_POST['salaryJobCategory']);
            update_post_meta($postId,'salaryCurrency', $_POST['salaryCurrency']);
            update_post_meta($postId,'salaryMin', $_POST['salaryMin']);
            update_post_meta($postId,'salaryMax', $_POST['salaryMax']);
            update_post_meta($postId,'salaryRecurrency', $_POST['salaryRecurrency']);
            
            $updateCompanySameAddress = '';
            if (isset($_POST['companySameAddress'])) {
                $updateCompanySameAddress = 'true';
            }

            update_post_meta($postId, 'companySameAddress', $updateCompanySameAddress);
        }
    }
}
