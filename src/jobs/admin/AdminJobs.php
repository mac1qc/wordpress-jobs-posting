<?php

declare(strict_types=1);

namespace Mac1qc\WordpressJobsPosting\jobs\admin;

class AdminJobs
{
    public function __construct(
        private string $postType,
        private array $customPost = [],
    ) {
        add_meta_box('job_meta', __('Job informations', 'jobs_posting'), [$this, 'jobMeta'], $postType, 'normal', 'low');
        add_meta_box('company_meta', __('Company informations', 'jobs_posting'), [$this, 'companyMeta'], $postType, 'normal', 'low');
        add_meta_box('advantages_meta', __('Job benifits', 'jobs_posting'), [$this, 'advantagesMeta'], $postType, 'normal', 'low');
        add_meta_box('where_meta', __('Job location', 'jobs_posting'), [$this, 'whereMeta'], $postType, 'normal', 'low');
        add_meta_box('salary_meta', __('Salary', 'jobs_posting'), [$this, 'salaryMeta'], $postType, 'normal', 'low');

        add_action('admin_footer', [$this, 'editJobScripts']);
        add_action('save_post', [$this, 'saveJob']);
    }

    public function jobMeta(): void
    {
        global $post;

        $this->customPost = $post ? get_post_custom($post->ID) : [];

        $jobEndTime     = !empty($this->customPost['jobEndTime']) ? $this->customPost['jobEndTime'][0] : '';
        $jobStartTime   = !empty($this->customPost['jobStartTime']) ? $this->customPost['jobStartTime'][0] : '';
        $jobType        = !empty($this->customPost['jobType']) ? $this->customPost['jobType'][0] : '';
        $jobDescription = !empty($this->customPost['jobDescription']) ? $this->customPost['jobDescription'][0] : '';
        $jobSkills      = !empty($this->customPost['jobSkills']) ? $this->customPost['jobSkills'][0] : '';
        $jobTotalHour   = !empty($this->customPost['jobTotalHour']) ? $this->customPost['jobTotalHour'][0] : '';
        ?>
        <div>
            <label for="jobEndTime"><?= __('Show until:', 'jobs_posting')?></label>
            <input name="jobEndTime" id="jobEndTime" value="<?= $jobEndTime ? date('Y-m-d', (int)$jobEndTime) : ''; ?>" type="date" />
        </div>

        <div>
            <label for="jobStartTime"><?= __('Start working on:', 'jobs_posting')?></label>
            <input name="jobStartTime" id="jobStartTime" value="<?= $jobStartTime; ?>" type="text" />
        </div>

        <div>
            <label for="jobType"><?= __('Job type:', 'jobs_posting')?></label>
            <select name="jobType" id="jobType">
                <option value="FULL_TIME"<?= $jobType === 'FULL_TIME' ? ' selected="selected"' : '';?>><?= __('Full time', 'jobs_posting')?></option>
                <option value="PART_TIME"<?= $jobType === 'PART_TIME' ? ' selected="selected"' : '';?>><?= __('Part time', 'jobs_posting')?></option>
                <option value="CONTRACTOR"<?= $jobType === 'CONTRACTOR' ? ' selected="selected"' : '';?>><?= __('Contractor', 'jobs_posting')?></option>
                <option value="TEMPORARY"<?= $jobType === 'TEMPORARY' ? ' selected="selected"' : '';?>><?= __('Temporary', 'jobs_posting')?></option>
                <option value="INTERN"<?= $jobType === 'INTERN' ? ' selected="selected"' : '';?>><?= __('Intern', 'jobs_posting')?></option>
                <option value="VOLUNTEER"<?= $jobType === 'VOLUNTEER' ? ' selected="selected"' : '';?>><?= __('Volunteer', 'jobs_posting')?></option>
                <option value="PER_DIEM"<?= $jobType === 'PER_DIEM' ? ' selected="selected"' : '';?>><?= __('Per diem', 'jobs_posting')?></option>
                <option value="OTHER"<?= $jobType === 'OTHER' ? ' selected="selected"' : '';?>><?= __('Other', 'jobs_posting')?></option>
            </select>
        </div>

        <div>
            <label for="jobDescription"><?= __('Job description:', 'jobs_posting')?></label>
            <?php wp_editor($jobDescription, 'jobDescription', ['wpautop'=>true, 'teeny'=>true]);?>
        </div>

        <div>
            <label for="jobSkills"><?= __('Required skills:', 'jobs_posting')?></label>
            <?php wp_editor($jobSkills, 'jobSkills', ['wpautop'=>true, 'teeny'=>true]); ?>
        </div>

        <div>
            <label for="jobTotalHour"><?= __('Total hours a week:', 'jobs_posting')?></label>
            <input name="jobTotalHour" id="jobTotalHour" value="<?= $jobTotalHour; ?>" type="number" min="0" />
        </div>
        <?php
    }
    
    public function companyMeta(): void
    {
        $companyName         = !empty($this->customPost['companyName']) ? $this->customPost['companyName'][0] : '';
        $companyWebsite      = !empty($this->customPost['companyWebsite']) ? $this->customPost['companyWebsite'][0] : '';
        $companyAddress      = !empty($this->customPost['companyAddress']) ? $this->customPost['companyAddress'][0] : '';
        $companyEmail        = !empty($this->customPost['companyEmail']) ? $this->customPost['companyEmail'][0] : '';
        $companyAddressApply = !empty($this->customPost['companyAddressApply']) ? $this->customPost['companyAddressApply'][0] : '';
        $companyPhone        = !empty($this->customPost['companyPhone']) ? $this->customPost['companyPhone'][0] : '';
        $companyFax          = !empty($this->customPost['companyFax']) ? $this->customPost['companyFax'][0] : '';
        $companySameAddress  = !empty($this->customPost['companySameAddress']) ? $this->customPost['companySameAddress'][0] : '';
        $companyDescription  = !empty($this->customPost['companyDescription']) ? $this->customPost['companyDescription'][0] : '';
        $companyURLApply     = !empty($this->customPost['companyURLApply']) ? $this->customPost['companyURLApply'][0] : '';
        ?>
        <div>
            <label for="companyName"><?= __('Company name:', 'jobs_posting')?></label>
            <input name="companyName" id="companyName" value="<?= $companyName; ?>" type="text" />
        </div>
        
        <div>
            <label for="companyWebsite"><?= __('Site internet :', 'jobs_posting')?></label>
            <input name="companyWebsite" id="companyWebsite" value="<?= $companyWebsite; ?>" type="text" />
        </div>

        <div>
            <label for="companySameAddress"><input type="checkbox" name="companySameAddress" id="companySameAddress" value="true"<?= $companySameAddress !== '' ? ' checked="checked"' : '';?>> <?= __('Company address <strong>IS NOT</strong> the same than where the employee will work', 'jobs_posting')?></label>
        </div>

        <div id="divCompanyAddress">
            <label for="companyAddress"><?= __('Address:', 'jobs_posting')?></label>
            <textarea name="companyAddress" id="companyAddress"><?= $companyAddress; ?></textarea>
        </div>

        <div>
            <label for="companyEmail"><?= __('Email:', 'jobs_posting')?></label>
            <input name="companyEmail" id="companyEmail" value="<?= $companyEmail; ?>" type="text" />
        </div>

        <div>
            <label for="companyAddressApply"><?= __('Mail address:', 'jobs_posting')?></label>
            <textarea name="companyAddressApply" id="companyAddressApply"><?= $companyAddressApply; ?></textarea>
        </div>

        <div>
            <label for="companyPhone"><?= __('Phone:', 'jobs_posting')?></label>
            <input name="companyPhone" id="companyPhone" value="<?= $companyPhone; ?>" type="tel" />
        </div>

        <div>
            <label for="companyFax"><?= __('Fax:', 'jobs_posting')?></label>
            <input name="companyFax" id="companyFax" value="<?= $companyFax; ?>" type="tel" />
        </div>

        <div>
            <label for="companyURLApply"><?= __('Company URL to apply:', 'jobs_posting')?></label>
            <input name="companyURLApply" id="companyURLApply" value="<?= $companyURLApply; ?>" type="text" />
        </div>

        <div>
            <label for="companyDescription"><?= __('Company description:', 'jobs_posting')?></label>
            <?php wp_editor($companyDescription, 'companyDescription', ['wpautop' => true, 'teeny' => true]);?>
        </div>
        <?php
    }

    public function advantagesMeta(): void
    {
        $advantagesDescription = !empty($this->customPost['advantagesDescription']) ? $this->customPost['advantagesDescription'][0] : '';
        ?>
        <div>
            <label for="advantagesDescription"><?= __('Job advantages:', 'jobs_posting')?></label>
            <?php wp_editor($advantagesDescription, 'advantagesDescription', ['wpautop'=>true, 'teeny'=>true]); ?>
        </div>
        <?php
    }

    public function whereMeta(): void
    {
        $whereStreet     = !empty($this->customPost['whereStreet']) ? $this->customPost['whereStreet'][0] : '';
        $whereCity       = !empty($this->customPost['whereCity']) ? $this->customPost['whereCity'][0] : '';
        $whereProvince   = !empty($this->customPost['whereProvince']) ? $this->customPost['whereProvince'][0] : '';
        $wherePostalCode = !empty($this->customPost['wherePostalCode']) ? $this->customPost['wherePostalCode'][0] : '';
        $whereCountry    = !empty($this->customPost['whereCountry']) ? $this->customPost['whereCountry'][0] : '';
        ?>
        <div>
            <label for="whereCountry"><?= __('Country:', 'jobs_posting')?></label>
            <select name="whereCountry" id="whereCountry">
                <option value="CA" <?= $whereCountry === 'CA' ? ' selected="selected"' : '';?>><?= __('Canada', 'jobs_posting')?></option>
                <option value="US" <?= $whereCountry === 'US' ? ' selected="selected"' : '';?>><?= __('United States', 'jobs_posting')?></option>
            </select>
        </div>

        <div>
            <label for="whereProvince"><?= __('Province/State:', 'jobs_posting')?></label>
            <select name="whereProvince" id="whereProvince">
                <option value="">--- <?= __('CANADA', 'jobs_posting')?> ---</option>
                <option value="AB" <?= $whereProvince === 'AB' ? ' selected="selected"' : '';?>><?= __('Alberta', 'jobs_posting')?></option>
                <option value="BC" <?= $whereProvince === 'BC' ? ' selected="selected"' : '';?>><?= __('British Columbia', 'jobs_posting')?></option>
                <option value="PE" <?= $whereProvince === 'PE' ? ' selected="selected"' : '';?>><?= __('Prince Edward Island', 'jobs_posting')?></option>
                <option value="MB" <?= $whereProvince === 'MB' ? ' selected="selected"' : '';?>><?= __('Manitoba', 'jobs_posting')?></option>
                <option value="NB" <?= $whereProvince === 'NB' ? ' selected="selected"' : '';?>><?= __('New Brunswick', 'jobs_posting')?></option>
                <option value="NS" <?= $whereProvince === 'NS' ? ' selected="selected"' : '';?>><?= __('Nova Scotia', 'jobs_posting')?></option>
                <option value="NU" <?= $whereProvince === 'NU' ? ' selected="selected"' : '';?>><?= __('Nunavut', 'jobs_posting')?></option>
                <option value="ON" <?= $whereProvince === 'ON' ? ' selected="selected"' : '';?>><?= __('Ontario', 'jobs_posting')?></option>
                <option value="QC" <?= $whereProvince === 'QC' ? ' selected="selected"' : '';?>><?= __('Québec', 'jobs_posting')?></option>
                <option value="SK" <?= $whereProvince === 'SK' ? ' selected="selected"' : '';?>><?= __('Saskatchewan', 'jobs_posting')?></option>
                <option value="NL" <?= $whereProvince === 'NL' ? ' selected="selected"' : '';?>><?= __('Newfoundland and Labrador', 'jobs_posting')?></option>
                <option value="NT" <?= $whereProvince === 'NT' ? ' selected="selected"' : '';?>><?= __('North West Territories', 'jobs_posting')?></option>
                <option value="YT" <?= $whereProvince === 'YT' ? ' selected="selected"' : '';?>><?= __('Yukon', 'jobs_posting')?></option>
                <option value="">--- <?= __('UNITED STATES', 'jobs_posting')?> ---</option>
                <option value="AL" <?= $whereProvince === 'AL' ? ' selected="selected"' : '';?>><?= __('Alabama', 'jobs_posting')?></option>
                <option value="AK" <?= $whereProvince === 'AK' ? ' selected="selected"' : '';?>><?= __('Alaska', 'jobs_posting')?></option>
                <option value="AZ" <?= $whereProvince === 'AZ' ? ' selected="selected"' : '';?>><?= __('Arizona', 'jobs_posting')?></option>
                <option value="AR" <?= $whereProvince === 'AR' ? ' selected="selected"' : '';?>><?= __('Arkansas', 'jobs_posting')?></option>
                <option value="CA" <?= $whereProvince === 'CA' ? ' selected="selected"' : '';?>><?= __('Californie', 'jobs_posting')?></option>
                <option value="CO" <?= $whereProvince === 'CO' ? ' selected="selected"' : '';?>><?= __('Colorado', 'jobs_posting')?></option>
                <option value="CT" <?= $whereProvince === 'CT' ? ' selected="selected"' : '';?>><?= __('Connecticut', 'jobs_posting')?></option>
                <option value="DE" <?= $whereProvince === 'DE' ? ' selected="selected"' : '';?>><?= __('Delaware', 'jobs_posting')?></option>
                <option value="FL" <?= $whereProvince === 'FL' ? ' selected="selected"' : '';?>><?= __('Floride', 'jobs_posting')?></option>
                <option value="GA" <?= $whereProvince === 'GA' ? ' selected="selected"' : '';?>><?= __('Georgie', 'jobs_posting')?></option>
                <option value="HI" <?= $whereProvince === 'HI' ? ' selected="selected"' : '';?>><?= __('Hawaii', 'jobs_posting')?></option>
                <option value="ID" <?= $whereProvince === 'ID' ? ' selected="selected"' : '';?>><?= __('Idaho', 'jobs_posting')?></option>
                <option value="IL" <?= $whereProvince === 'IL' ? ' selected="selected"' : '';?>><?= __('Illinois', 'jobs_posting')?></option>
                <option value="IN" <?= $whereProvince === 'IN' ? ' selected="selected"' : '';?>><?= __('Indiana', 'jobs_posting')?></option>
                <option value="IA" <?= $whereProvince === 'IA' ? ' selected="selected"' : '';?>><?= __('Iowa', 'jobs_posting')?></option>
                <option value="KS" <?= $whereProvince === 'KS' ? ' selected="selected"' : '';?>><?= __('Kansas', 'jobs_posting')?></option>
                <option value="KY" <?= $whereProvince === 'KY' ? ' selected="selected"' : '';?>><?= __('Kentucky', 'jobs_posting')?></option>
                <option value="LA" <?= $whereProvince === 'LA' ? ' selected="selected"' : '';?>><?= __('Louisiane', 'jobs_posting')?></option>
                <option value="ME" <?= $whereProvince === 'ME' ? ' selected="selected"' : '';?>><?= __('Maine', 'jobs_posting')?></option>
                <option value="MD" <?= $whereProvince === 'MD' ? ' selected="selected"' : '';?>><?= __('Maryland', 'jobs_posting')?></option>
                <option value="MA" <?= $whereProvince === 'MA' ? ' selected="selected"' : '';?>><?= __('Massachusetts', 'jobs_posting')?></option>
                <option value="MI" <?= $whereProvince === 'MI' ? ' selected="selected"' : '';?>><?= __('Michigan', 'jobs_posting')?></option>
                <option value="MN" <?= $whereProvince === 'MN' ? ' selected="selected"' : '';?>><?= __('Minnesota', 'jobs_posting')?></option>
                <option value="MS" <?= $whereProvince === 'MS' ? ' selected="selected"' : '';?>><?= __('Mississippi', 'jobs_posting')?></option>
                <option value="MO" <?= $whereProvince === 'MO' ? ' selected="selected"' : '';?>><?= __('Missouri', 'jobs_posting')?></option>
                <option value="MT" <?= $whereProvince === 'MT' ? ' selected="selected"' : '';?>><?= __('Montana', 'jobs_posting')?></option>
                <option value="NE" <?= $whereProvince === 'NE' ? ' selected="selected"' : '';?>><?= __('Nebraska', 'jobs_posting')?></option>
                <option value="NV" <?= $whereProvince === 'NV' ? ' selected="selected"' : '';?>><?= __('Nevada', 'jobs_posting')?></option>
                <option value="NH" <?= $whereProvince === 'NH' ? ' selected="selected"' : '';?>><?= __('New Hampshire', 'jobs_posting')?></option>
                <option value="NJ" <?= $whereProvince === 'NJ' ? ' selected="selected"' : '';?>><?= __('New Jersey', 'jobs_posting')?></option>
                <option value="NM" <?= $whereProvince === 'NM' ? ' selected="selected"' : '';?>><?= __('New Mexico', 'jobs_posting')?></option>
                <option value="NY" <?= $whereProvince === 'NY' ? ' selected="selected"' : '';?>><?= __('New York', 'jobs_posting')?></option>
                <option value="NC" <?= $whereProvince === 'NC' ? ' selected="selected"' : '';?>><?= __('North Carolina', 'jobs_posting')?></option>
                <option value="ND" <?= $whereProvince === 'ND' ? ' selected="selected"' : '';?>><?= __('North Dakota', 'jobs_posting')?></option>
                <option value="OH" <?= $whereProvince === 'OH' ? ' selected="selected"' : '';?>><?= __('Ohio', 'jobs_posting')?></option>
                <option value="OK" <?= $whereProvince === 'OK' ? ' selected="selected"' : '';?>><?= __('Oklahoma', 'jobs_posting')?></option>
                <option value="OR" <?= $whereProvince === 'OR' ? ' selected="selected"' : '';?>><?= __('Oregon', 'jobs_posting')?></option>
                <option value="PA" <?= $whereProvince === 'PA' ? ' selected="selected"' : '';?>><?= __('Pennsylvanie', 'jobs_posting')?></option>
                <option value="RI" <?= $whereProvince === 'RI' ? ' selected="selected"' : '';?>><?= __('Rhode Island', 'jobs_posting')?></option>
                <option value="SC" <?= $whereProvince === 'SC' ? ' selected="selected"' : '';?>><?= __('South Carolina', 'jobs_posting')?></option>
                <option value="SD" <?= $whereProvince === 'SD' ? ' selected="selected"' : '';?>><?= __('South Dakota', 'jobs_posting')?></option>
                <option value="TN" <?= $whereProvince === 'TN' ? ' selected="selected"' : '';?>><?= __('Tennessee', 'jobs_posting')?></option>
                <option value="TX" <?= $whereProvince === 'TX' ? ' selected="selected"' : '';?>><?= __('Texas', 'jobs_posting')?></option>
                <option value="UT" <?= $whereProvince === 'UT' ? ' selected="selected"' : '';?>><?= __('Utah', 'jobs_posting')?></option>
                <option value="VT" <?= $whereProvince === 'VT' ? ' selected="selected"' : '';?>><?= __('Vermont', 'jobs_posting')?></option>
                <option value="VA" <?= $whereProvince === 'VA' ? ' selected="selected"' : '';?>><?= __('Virginie', 'jobs_posting')?></option>
                <option value="WA" <?= $whereProvince === 'WA' ? ' selected="selected"' : '';?>><?= __('Washington', 'jobs_posting')?></option>
                <option value="WV" <?= $whereProvince === 'WV' ? ' selected="selected"' : '';?>><?= __('West Virginia', 'jobs_posting')?></option>
                <option value="WI" <?= $whereProvince === 'WI' ? ' selected="selected"' : '';?>><?= __('Wisconsin', 'jobs_posting')?></option>
                <option value="WY" <?= $whereProvince === 'WY' ? ' selected="selected"' : '';?>><?= __('Wyoming', 'jobs_posting')?></option>
            </select>
        </div>
        
        <div>
            <label for="whereStreet"><?= __('Street:', 'jobs_posting')?></label>
            <input name="whereStreet" id="whereStreet" value="<?= $whereStreet; ?>" type="text" />
        </div>

        <div>
            <label for="whereCity"><?= __('City:', 'jobs_posting')?></label>
            <input name="whereCity" id="whereCity" value="<?= $whereCity; ?>" type="text" />
        </div>
        
        <div>
            <label for="wherePostalCode"><?= __('ZIP:', 'jobs_posting')?></label>
            <input name="wherePostalCode" id="wherePostalCode" value="<?= $wherePostalCode; ?>" type="text" placeholder="<?= __('A1A 1A1', 'jobs_posting')?>" maxlength="7" />
        </div>
        <?php
    }

    public function salaryMeta(): void
    {
        $salaryJobType  = !empty($this->customPost['salaryJobType']) ? $this->customPost['salaryJobType'][0] : '';
        $salaryCurrency = !empty($this->customPost['salaryCurrency']) ? $this->customPost['salaryCurrency'][0] : '';
        $salaryMin      = !empty($this->customPost['salaryMin']) ? $this->customPost['salaryMin'][0] : '';
        $salaryMax      = !empty($this->customPost['salaryMax']) ? $this->customPost['salaryMax'][0] : '';
        $salaryType     = !empty($this->customPost['salaryType']) ? $this->customPost['salaryType'][0] : '';
        ?>
        <div>
            <label for="salaryJobType"><?= __('Salary category:', 'jobs_posting')?></label>
            <select name="salaryJobType" id="salaryJobType">
                <option <?= $salaryJobType === 'normal' ? ' selected="selected"' : '';?> value="normal"><?= __('Normal', 'jobs_posting')?></option>
                <option <?= $salaryJobType === 'discuter' ? ' selected="selected"' : '';?> value="discuter"><?= __('To discuss', 'jobs_posting')?></option>
                <option <?= $salaryJobType === 'commission' ? ' selected="selected"' : '';?> value="commission"><?= __('Commisson', 'jobs_posting')?></option>
            </select>
        </div>
        
        <div>
            <label for="salaryCurrency"><?= __('Currency:', 'jobs_posting')?></label>
            <select name="salaryCurrency" id="salaryCurrency">
                <option <?= $salaryCurrency === 'CAD' ? ' selected="selected"' : '';?>><?= __('CAD', 'jobs_posting')?></option>
                <option <?= $salaryCurrency === 'USD' ? ' selected="selected"' : '';?>><?= __('USD', 'jobs_posting')?></option>
            </select>
        </div>

        <div>
            <label for="salaryMin"><?= __('Minimum salary:', 'jobs_posting')?></label>
            <input name="salaryMin" id="salaryMin" value="<?= $salaryMin; ?>" type="text" min="0" />
        </div>

        <div>
            <label for="salaryMax"><?= __('Maximum salary:', 'jobs_posting')?></label>
            <input name="salaryMax" id="salaryMax" value="<?= $salaryMax; ?>" type="text" min="0" />
        </div>

        <div>
            <label for="salaryType"><?= __('Salary type:', 'jobs_posting')?></label>
            <select name="salaryType" id="salaryType">
                <option value="HOUR"<?= $salaryType === 'HOUR' ?' selected="selected"' : '';?>><?= __('Hourly', 'jobs_posting')?></option>
                <option value="DAY"<?= $salaryType === 'DAY' ?' selected="selected"' : '';?>><?= __('Dayly', 'jobs_posting')?></option>
                <option value="WEEK"<?= $salaryType === 'WEEK' ?' selected="selected"' : '';?>><?= __('Weekly', 'jobs_posting')?></option>
                <option value="MONTH"<?= $salaryType === 'MONTH' ?' selected="selected"' : '';?>><?= __('Monthly', 'jobs_posting')?></option>
                <option value="YEAR"<?= $salaryType === 'YEAR' ?' selected="selected"' : '';?>><?= __('Yearly', 'jobs_posting')?></option>
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

            $postId          = $post->ID;
            $jobEndTimeEpoch = new \DateTime($_POST['jobEndTime'].' 23:59:59');
            
            update_post_meta($postId,'jobEndTime', $jobEndTimeEpoch->format('U'));
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
            update_post_meta($postId,'advantagesDescription', $_POST['advantagesDescription']);
            update_post_meta($postId,'whereStreet', $_POST['whereStreet']);
            update_post_meta($postId,'whereCity', $_POST['whereCity']);
            update_post_meta($postId,'whereProvince', $_POST['whereProvince']);
            update_post_meta($postId,'wherePostalCode', $_POST['wherePostalCode']);
            update_post_meta($postId,'whereCountry', $_POST['whereCountry']);
            update_post_meta($postId,'salaryJobType', $_POST['salaryJobType']);
            update_post_meta($postId,'salaryCurrency', $_POST['salaryCurrency']);
            update_post_meta($postId,'salaryMin', $_POST['salaryMin']);
            update_post_meta($postId,'salaryMax', $_POST['salaryMax']);
            update_post_meta($postId,'salaryType', $_POST['salaryType']);
            
            $updateCompanySameAddress = '';
            if (isset($_POST['companySameAddress'])) {
                $updateCompanySameAddress = 'true';
            }

            update_post_meta($postId, 'companySameAddress', $updateCompanySameAddress);
        }
    }
}
