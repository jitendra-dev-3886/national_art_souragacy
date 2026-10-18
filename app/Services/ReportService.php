<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Connection;
use Carbon\Carbon;

class ReportService
{
    private Connection $secondDatabase;

    // 1. CLASS CONSTANTS
    private const TBL_ART = 'patient_artclinic';
    private const TBL_SURROGACY = 'patient_surrogacyclinic';
    private const TBL_BANK = 'patient_artbank';

    private const REPORT_SECTIONS = [
        'A. Submitted data' => [
            'art_patients_submitted'        => 'Patient records submitted by ART clinics',
            'bank_donors_submitted'         => 'Donor records submitted by ART banks',
            'surrogacy_patients_submitted' => 'Patient records submitted by Surrogacy clinics',
        ],
        'B. No. of married couples who have undergone' => [
            'married_iui'         => 'Married Couples IUI',
            'married_iui_level_1' => 'Married Couples IUI Level-1',
            'married_iui_level_2' => 'Married Couples IUI Level-2',
            'married_art'         => 'Married Couples ART Treatment',


            'married_art_treament_ai'         => 'Artificial insemination',
            'married_art_treament_ivf_et'         => 'In vitro fertilization-embryo transfer(IVF-ET)',
            'married_art_treament_gift'         => 'Gamete intrafallopian tube transfer(GIFT)',
            'married_art_treament_icsi_et'         => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
            'married_art_treament_picsi'         => 'Physiological Intra-cytoplasmic sperm injection(PICSI)',
            'married_art_treament_imsi'         => 'Intra-cytoplasmic morphologically selected sperm injection(IMSI)',
            'married_art_treament_rosni'         => 'Round spermatid nucleus injection(ROSNI)',
            'married_art_treament_elsi'         => 'Elongated spermatid injection(ELSI)',
            'married_art_treament_others'         => 'Others',

            'married_surrogacy' => 'Surrogacy Couples Treatment',
        ],
        'C. No. of Single woman who have undergone:' => [
            'single_iui'        => 'Single woman IUI',

            'single_iui_level_1' => 'Single Couples IUI Level-1',
            'single_iui_level_2' => 'Single Couples IUI Level-2',

            'single_iui_level_1' => 'Single Couples IUI Level-1',
            'single_iui_level_2' => 'Single Couples IUI Level-2',
            'single_art'        => 'Single woman ART Treatment',
            'single_surrogacy' => 'Surrogacy Treatment',
        ],
        'D. Total No. of procedures undertaken:' => [
            'proc_iui_h' => 'Procedure Undertaken IUI (H)',
            'proc_iui_d' => 'Procedure Undertaken IUI (D)',
        ],
        'E. Total No. of IVF/ICSI procedures undertaken:' => [
            'ivf_icsi_self'  => 'IVF/ICSI Self gametes',
            'ivf_icsi_donor' => 'IVF/ICSI Donor gametes',
        ],
        'F. Total No. of Surrogacy procedures undertaken -' => [
            'surrogacy_self'  => 'Surrogacy Self gametes',
            'surrogacy_donor' => 'Surrogacy Donor gametes',
        ],
        'G. Cause of Infertility in ART Treatment:' => [
            'art_cause_male'        => 'Infertility in ART Treatment Male factor',
            'art_cause_female'      => 'Infertility in ART Treatment ART Female factor',
            'art_cause_unexplained' => 'Unexplained factors',
        ],
        'H. Medication Indication for Surrogacy Treatment:' => [
            'sur_ind_uterus'       => 'Uterus Abnormalities',
            'sur_ind_ivf_fail'     => 'Repeated IVF Failure',
            'sur_ind_preg_loss'    => 'Multiple Pregnancy Loss',
            'sur_ind_illness'      => 'Life Threatening Illness',
            'sur_ind_male'         => 'Male Factor',
        ],
        'I. Having Surviving Child' => [
            'sur_child_yes' => 'Having Surviving Child Yes',
            'sur_child_no'  => 'Having Surviving Child No',
        ],
        'J. Treatment Outcome (Pregnant/ Not Pregnant)' => [
            'outcome_art_preg'      => 'ART Treatment (Pregnant)',
            'outcome_art_not_preg'  => 'ART Treatment (Not Pregnant)',
            'outcome_sur_preg'      => 'Surrogacy Treatment (Pregnant)',
            'outcome_sur_not_preg'  => 'Surrogacy Treatment (Not Pregnant)',
        ], 
    ];

    private const SUBMITTED_RECORDS = [
        'art_patients_submitted'        => ['table' => self::TBL_ART],
        'bank_donors_submitted'         => ['table' => self::TBL_BANK],
        'surrogacy_patients_submitted' => ['table' => self::TBL_SURROGACY],
    ];

    private const STANDARD_RECORDS = [
        'married_iui'         => ['table' => self::TBL_ART, 'conditions' => ['case_of' => 'one', 'art_proc_undertaken' => 'intra-uterine insemination(IUI)']],
        'married_iui_level_1' => [
            'table' => self::TBL_ART,
            'level' => 'Level-1',
            'conditions' => [
                'case_of' => 'one', 
                'art_proc_undertaken' => 'intra-uterine insemination(IUI)'
            ]
        ],
        'married_iui_level_2' => [
            'table' => self::TBL_ART,
            'level' => 'Level-1',
            'conditions' => [
                'case_of' => 'one', 
                'art_proc_undertaken' => 'intra-uterine insemination(IUI)'
            ]
        ], 


        'single_iui_level_1' => [
            'table' => self::TBL_ART,
            'level' => 'Level-1',
            'conditions' => [
                'case_of' => 'two', 
                'art_proc_undertaken' => 'intra-uterine insemination(IUI)'
            ]
        ],
        'single_iui_level_2' => [
            'table' => self::TBL_ART,
            'level' => 'Level-1',
            'conditions' => [
                'case_of' => 'two', 
                'art_proc_undertaken' => 'intra-uterine insemination(IUI)'
            ]
        ],

        'married_art_treament_ai' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_ivf_et' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_gift' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_icsi_et' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_imsi' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_rosni' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_elsi' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_others' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],
        'married_art_treament_picsi' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'art_treatment']],

        'married_art'         => ['table' => self::TBL_ART, 'conditions' => ['case_of' => 'one']],
        'married_surrogacy' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'one', 'treatment_type' => 'surrogacy']],
        'single_iui'        => ['table' => self::TBL_ART, 'conditions' => ['case_of' => 'two', 'art_proc_undertaken' => 'intra-uterine insemination(IUI)']],
        'single_art'        => ['table' => self::TBL_ART, 'conditions' => ['case_of' => 'two']],
        'single_surrogacy' => ['table' => self::TBL_SURROGACY, 'conditions' => ['case_of' => 'two', 'treatment_type' => 'surrogacy']],
        'proc_iui_h' => ['table' => self::TBL_ART, 'conditions' => ['types_of_treat' => 'ART Treatment using self gametes']],
        'proc_iui_d' => ['table' => self::TBL_ART, 'conditions' => ['types_of_treat' => 'ART Treatment using donor gametes']],
        'ivf_icsi_self'  => ['table' => self::TBL_ART, 'conditions' => ['art_proc_undertaken' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'types_of_treat' => 'ART Treatment using self gametes']],
        'ivf_icsi_donor' => ['table' => self::TBL_ART, 'conditions' => ['art_proc_undertaken' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)', 'types_of_treat' => 'ART Treatment using donor gametes']],
        'surrogacy_self'  => ['table' => self::TBL_SURROGACY, 'conditions' => ['types_of_treat' => 'Surrogacy using own gametes']],
        'surrogacy_donor' => ['table' => self::TBL_SURROGACY, 'conditions' => ['types_of_treat' => 'Surrogacy using donor gametes']],
        'art_cause_male'        => ['table' => self::TBL_ART, 'conditions' => ['male_factor' => 'Y']],
        'art_cause_female'      => ['table' => self::TBL_ART, 'conditions' => ['female_factor' => 'Y']],
        'art_cause_unexplained' => ['table' => self::TBL_ART, 'conditions' => ['unexplained' => 'Y']],
        'sur_ind_uterus'    => ['table' => self::TBL_SURROGACY, 'conditions' => ['uterus_ab' => 'Y']],
        'sur_ind_ivf_fail'  => ['table' => self::TBL_SURROGACY, 'conditions' => ['ivf_failure' => 'Y']],
        'sur_ind_preg_loss' => ['table' => self::TBL_SURROGACY, 'conditions' => ['preg_loss' => 'Y']],
        'sur_ind_illness'   => ['table' => self::TBL_SURROGACY, 'conditions' => ['life_threat' => 'Y']],
        'sur_ind_male'      => ['table' => self::TBL_SURROGACY, 'conditions' => ['male_factor' => 'Y']],
        'sur_child_yes' => ['table' => self::TBL_SURROGACY, 'conditions' => ['num_pre_child' => 'Yes']],
        'sur_child_no'  => ['table' => self::TBL_SURROGACY, 'conditions' => ['num_pre_child' => 'No']],
        'outcome_art_preg'      => ['table' => self::TBL_ART, 'conditions' => ['treat_outcomes' => 'Pregnant']],
        'outcome_art_not_preg'  => ['table' => self::TBL_ART, 'conditions' => ['treat_outcomes' => 'Not Pregnant']],
        'outcome_sur_preg'      => ['table' => self::TBL_SURROGACY, 'conditions' => ['tratment_Outcome' => 'Pregnant']],
        'outcome_sur_not_preg'  => ['table' => self::TBL_SURROGACY, 'conditions' => ['tratment_Outcome' => 'Not Pregnant']],
    ];

    // 2. CONSTRUCTOR
    public function __construct()
    {
        $connectionName = config('database.second_connection_name', env('DB_SECOND_CONNECTION'));
        $this->secondDatabase = DB::connection($connectionName);
    }

    // Helper to get years dynamically
    public static function getTargetYears(): array
    {
        $startYear = 2022; 
        $currentYear = (int) now()->year; 
        
        return range($startYear, $currentYear);
    }

    public function getSections(): array
    {
        $sections = [];
        $sectionId = 1;

        foreach (self::REPORT_SECTIONS as $sectionName => $fields) {
            $section = [
                'id'     => $sectionId++,
                'name'   => $sectionName,
                'fields' => [],
            ];

            $fieldNo = 1;
            foreach ($fields as $code => $name) {
                $section['fields'][] = [
                    'code' => $code,
                    'name' => $fieldNo++ . '. ' . $name,
                ];
            }

            $sections[] = $section;
        }

        $yearSection = [
            'id'     => $sectionId++,
            'name'   => 'K. Year',
            'fields' => [],
        ];

        foreach ($this->getTargetYears() as $year) {
            $yearSection['fields'][] = [
                'code' => (string) $year,
                'name' => (string) $year,
            ];
        }
        
        $sections[] = $yearSection;

        return $sections;
    }

    public function generate(Request $request): array
    {
        $requestedFields = $request->input('fields', []);

        if (empty($requestedFields)) {
            return [];
        }

        $standardFields = array_intersect($requestedFields, array_keys(self::STANDARD_RECORDS));
        $submittedFields = array_intersect($requestedFields, array_keys(self::SUBMITTED_RECORDS));
        
        $years = $this->getTargetYears();
        $results = [];

        $levelFields = ['married_iui_level_1', 'married_iui_level_2'];
        $flatStandardFields = array_diff($standardFields, $levelFields);

        if (!empty($flatStandardFields)) {
            $results = array_merge($results, $this->batchStandardQueries($flatStandardFields, $years));
        }

        foreach ($levelFields as $field) {
            if (in_array($field, $standardFields) && isset(self::STANDARD_RECORDS[$field])) {
                $results = array_merge($results, $this->countWithClinicLevel($field, self::STANDARD_RECORDS[$field], $years, $years));
            }
        }

        foreach ($submittedFields as $field) {
            $results = array_merge($results, $this->countSubmittedData($field, self::SUBMITTED_RECORDS[$field], $years));
        }

        $validDataFields = array_merge($standardFields, $submittedFields);

        return collect($validDataFields)->map(function (string $field) use ($results, $years) {
            $yearlyData = [];
            foreach ($years as $year) {
                $yearlyData[$year] = (int) ($results["{$field}_{$year}"] ?? 0);
            }

            return [
                'code'  => $field,
                'title' => $this->getExactTitle($field),
                'count' => (int) ($results["{$field}_total"] ?? 0), 
                'years' => $yearlyData 
            ];
        })->toArray();
    }

    public function calculateAllDailyTotals(): array
    {
        $allFields = array_keys(self::STANDARD_RECORDS);
        $allSubmittedFields = array_keys(self::SUBMITTED_RECORDS);
        $allYears = self::getTargetYears();
        $selectedYears = $this->getTargetYears(); 
        
        $results = [];

        // 1. Run ONE unified batched query for ALL standard fields (handles flats and levels together)
        if (!empty($allFields)) {
            $results = array_merge($results, $this->batchStandardQueries($allFields, $selectedYears, $allYears));
        }

        // 2. Run queries for all submitted data fields
        foreach ($allSubmittedFields as $field) {
            $results = array_merge($results, $this->countSubmittedData($field, self::SUBMITTED_RECORDS[$field], $selectedYears, $allYears));
        }

        // 3. Format results mapping suffixes cleanly
        $finalResults = [];
        foreach ($results as $key => $value) {
            $intValue = (int) $value;

            if (str_ends_with($key, '_total')) {
                $originalField = str_replace('_total', '', $key);
                $finalResults[$originalField] = $intValue;
            } else {
                $finalResults[$key] = $intValue; 
            }
        }

        return $finalResults;
    }

    public function getExactTitle(string $fieldCode): string
    {
        foreach (self::REPORT_SECTIONS as $fields) {
            if (isset($fields[$fieldCode])) {
                return $fields[$fieldCode];
            }
        }
        
        return Str::headline($fieldCode); 
    }

    private function batchStandardQueries(array $fields, array $selectedYears, array $allYears): array
    {
        $groupedByTable = [];
        $counts = [];

        foreach ($fields as $field) {
            $tableName = self::STANDARD_RECORDS[$field]['table'];
            $groupedByTable[$tableName][] = $field;
        }

        foreach ($groupedByTable as $tableName => $tableFields) {
            $isSecondDb = in_array($tableName, [self::TBL_ART, self::TBL_SURROGACY, self::TBL_BANK]);
            $dbConnection = $isSecondDb ? $this->secondDatabase : DB::connection();
            
            $query = $dbConnection->table($tableName);

            // Check if any field in this table requires joining clinic_registration (for levels)
            $needsClinicJoin = collect($tableFields)->contains(function($field) {
                return isset(self::STANDARD_RECORDS[$field]['level']);
            });

            if ($needsClinicJoin && $tableName === self::TBL_ART) {
                $defaultDbName = config('database.connections.' . config('database.default') . '.database');
                $clinicRegTable = $defaultDbName . '.clinic_registration';
                
                $query->join($clinicRegTable, "{$tableName}.clinic_id", '=', "clinic_registration.clinic_id");
            }
            
            $selects = [];
            $bindings = [];

            foreach ($tableFields as $field) {
                $record = self::STANDARD_RECORDS[$field];
                $conditions = $record['conditions'];
                $level = $record['level'] ?? null;
                
                $caseParts = [];
                $conditionBindings = [];

                // Add level condition if specified
                if ($level !== null && $tableName === self::TBL_ART) {
                    $caseParts[] = "`clinic_registration`.`level` = ?";
                    $conditionBindings[] = $level;
                }

                // Add standard table conditions
                foreach ($conditions as $column => $value) {
                    $caseParts[] = "`$tableName`.`$column` = ?";
                    $conditionBindings[] = $value;
                }
                
                $caseString = implode(' AND ', $caseParts);
                
                // 1. Calculate Grand Total
                $selects[] = DB::raw("SUM(CASE WHEN $caseString THEN 1 ELSE 0 END) as `{$field}_total`");
                $bindings = array_merge($bindings, $conditionBindings); 
                
                // 2. Loop through ALL master years to keep array keys uniform
                foreach ($allYears as $year) {
                    if (in_array($year, $selectedYears)) {
                        $selects[] = DB::raw("SUM(CASE WHEN $caseString AND `{$tableName}`.`year` = ? THEN 1 ELSE 0 END) as `{$field}_{$year}`");
                        $bindings = array_merge($bindings, $conditionBindings);
                        $bindings[] = $year; 
                    } else {
                        $selects[] = DB::raw("0 as `{$field}_{$year}`");
                    }
                }
            }

            $query->select($selects)->addBinding($bindings, 'select');
            $result = (array) $query->first();
            
            $counts = array_merge($counts, array_map('intval', $result));
        }

        return $counts;
    }

    private function countSubmittedData(string $field, array $parameters, array $years): array
    {
        $tableName = $parameters['table'] ?? null;

        if (!$tableName) {
            return [];
        }

        $query = $this->secondDatabase->table("{$tableName} as pac")
            ->join('patient_period_reporting_table as pprt', 'pac.reporting_id', '=', 'pprt.id')
            ->where('pprt.status', 'Finished');

        $selects = [
            DB::raw("COUNT(*) as `{$field}_total`")
        ];

        foreach ($years as $year) {
            $yearInt = (int) $year;
            $selects[] = DB::raw("SUM(CASE WHEN pac.year = {$yearInt} THEN 1 ELSE 0 END) as `{$field}_{$yearInt}`");
        }

        $query->select($selects);
        $result = (array) $query->first();
        
        return array_map('intval', $result);
    }

    private function countWithClinicLevel(string $field, array $config, array $selectedYears, array $allYears): array
    {
        $tableName = $config['table'];
        
        // SAFETY CHECK: Levels are only applicable to TBL_ART (patient_artclinic)
        if ($tableName !== self::TBL_ART) {
            return ["{$field}_total" => 0];
        }

        $level = $config['level'];
        $conditions = $config['conditions'];

        $isSecondDb = in_array($tableName, [self::TBL_ART, self::TBL_SURROGACY, self::TBL_BANK]);
        $dbConnection = $isSecondDb ? $this->secondDatabase : DB::connection();

        // 1. Get the DEFAULT database name (where clinic_registration resides)
        $defaultDbName = config('database.connections.' . config('database.default') . '.database');
        $clinicRegTable = $defaultDbName . '.clinic_registration';

        // Base query joining the default database's clinic_registration table strictly for TBL_ART
        $query = $dbConnection->table($tableName)
            ->join($clinicRegTable, "{$tableName}.clinic_id", '=', "clinic_registration.clinic_id")
            ->where('clinic_registration.level', '=', $level);

        // Apply standard conditions (e.g., case_of, art_proc_undertaken)
        foreach ($conditions as $column => $value) {
            $query->where("{$tableName}.{$column}", '=', $value);
        }

        // --- GENERATE AND PRINT THE HARD SQL QUERY ---
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . addslashes($binding) . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        // This will display the exact executable SQL string and stop the script
        dd("DEBUG SQL FOR [{$field}]:", $sql);
        // ---------------------------------------------

        // 1. Calculate Grand Total
        $grandTotalQuery = clone $query;
        $grandTotal = $grandTotalQuery->count();

        $results = ["{$field}_total" => $grandTotal];

        // 2. Calculate Yearly Totals
        foreach ($allYears as $year) {
            $key = "{$field}_{$year}";
            
            if (in_array($year, $selectedYears)) {
                $yearQuery = clone $query;
                $results[$key] = $yearQuery->where("{$tableName}.year", '=', $year)->count();
            } else {
                $results[$key] = 0;
            }
        }

        return $results;
    }

    public function saveDailyReportToDatabase(array $data = null, string $reportDate = null, array|int|null $selectedYears = null): bool
    {

        // dd($data);
        $data = $data ?? $this->calculateAllDailyTotals();
        $reportDate = $reportDate ?? now()->toDateString(); 

        $allAvailableYears = self::getTargetYears(); 
        
        if (empty($selectedYears)) {
            $yearsToProcess = $allAvailableYears;
        } else {
            $yearsToProcess = is_array($selectedYears) ? $selectedYears : [$selectedYears];
        }

        foreach ($yearsToProcess as $year) {

            $getValue = function($field) use ($data, $year) {
                return $data["{$field}_{$year}"] ?? 0;  
            };

            DB::table('daily_report_submitted_records')->updateOrInsert(
                ['report_date' => $reportDate, 'year' => $year], 
                [
                    'art_patients_submitted'       => $getValue('art_patients_submitted'),
                    'bank_donors_submitted'        => $getValue('bank_donors_submitted'),
                    'surrogacy_patients_submitted' => $getValue('surrogacy_patients_submitted'),
                    'updated_at'                   => now(),
                ]
            );

            DB::table('daily_report_procedures')->updateOrInsert(
                ['report_date' => $reportDate, 'year' => $year],
                [
                    'married_iui'           => $getValue('married_iui'),                     
                    'married_iui_level_1'   => $getValue('married_iui_level_1'), 
                    'married_iui_level_2'   => $getValue('married_iui_level_2'), 
                    'married_art'           => $getValue('married_art'),

                    'married_art_treament_ai'       =>  $getValue('married_art_treament_ai'),
                    'married_art_treament_ivf_et'   =>  $getValue('married_art_treament_ivf_et'),
                    'married_art_treament_gift'     =>  $getValue('married_art_treament_gift'),
                    'married_art_treament_icsi_et'  =>  $getValue('married_art_treament_icsi_et'),
                    'married_art_treament_picsi'    =>  $getValue('married_art_treament_picsi'),
                    'married_art_treament_imsi'     =>  $getValue('married_art_treament_imsi'),
                    'married_art_treament_rosni'    =>  $getValue('married_art_treament_rosni'),
                    'married_art_treament_elsi'     =>  $getValue('married_art_treament_elsi'),
                    'married_art_treament_others'   =>  $getValue('married_art_treament_others'),  


                    'married_surrogacy'     => $getValue('married_surrogacy'),
                    'single_iui'            => $getValue('single_iui'),
                    'single_iui_level_1'    => $getValue('single_iui_level_1'), 
                    'single_iui_level_2'   => $getValue('single_iui_level_2'),
                    'single_art'            => $getValue('single_art'),
                    'single_surrogacy'      => $getValue('single_surrogacy'),
                    'proc_iui_h'            => $getValue('proc_iui_h'),
                    'proc_iui_d'            => $getValue('proc_iui_d'),
                    'ivf_icsi_self'         => $getValue('ivf_icsi_self'),
                    'ivf_icsi_donor'        => $getValue('ivf_icsi_donor'),
                    'surrogacy_self'        => $getValue('surrogacy_self'),
                    'surrogacy_donor'       => $getValue('surrogacy_donor'),
                    'art_cause_male'        => $getValue('art_cause_male'),
                    'art_cause_female'      => $getValue('art_cause_female'),
                    'art_cause_unexplained' => $getValue('art_cause_unexplained'),
                    'updated_at'            => now(),
                ]
            );

            DB::table('daily_report_outcomes')->updateOrInsert(
                ['report_date' => $reportDate, 'year' => $year],
                [
                    'sur_ind_uterus'       => $getValue('sur_ind_uterus'),
                    'sur_ind_ivf_fail'     => $getValue('sur_ind_ivf_fail'),
                    'sur_ind_preg_loss'    => $getValue('sur_ind_preg_loss'),
                    'sur_ind_illness'      => $getValue('sur_ind_illness'),
                    'sur_ind_male'         => $getValue('sur_ind_male'),
                    'sur_child_yes'        => $getValue('sur_child_yes'),
                    'sur_child_no'         => $getValue('sur_child_no'),
                    'outcome_art_preg'     => $getValue('outcome_art_preg'),
                    'outcome_art_not_preg' => $getValue('outcome_art_not_preg'),
                    'outcome_sur_preg'     => $getValue('outcome_sur_preg'),
                    'outcome_sur_not_preg' => $getValue('outcome_sur_not_preg'),
                    'updated_at'           => now(),
                ]
            );
        }

        return true;
    }
}