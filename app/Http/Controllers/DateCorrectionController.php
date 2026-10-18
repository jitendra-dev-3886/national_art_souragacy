<?php

namespace App\Http\Controllers;

use App\Services\EstablishmentDateParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DateCorrectionController extends Controller
{
    protected EstablishmentDateParser $parser;

    public function __construct(EstablishmentDateParser $parser)
    {
        $this->parser = $parser;
    }

    public function convertDates(string $type): JsonResponse
    {
        $type = strtoupper($type);

        $config = [

            'A' => [
                'table' => 'artclinic',
                'clinic_type' => 'ARTCLINIC'
            ],

            'B' => [
                'table' => 'artbank',
                'clinic_type' => 'ARTBANK'
            ],

            'S' => [
                'table' => 'surrogacyclinic',
                'clinic_type' => 'ARTSURROGACY'
            ]

        ];

        if (!isset($config[$type])) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid type. Use A, B or S.'
            ], 400);

        }

        $table = $config[$type]['table'];
        $clinicType = $config[$type]['clinic_type'];

        $total = 0;

        $statusSummary = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0
        ];

        DB::table($table)
            ->select(
                'id',
                'applicationno',
                'dateestab',
                'state',
                'applicationno_datetime_submission'
            )
            ->where('status', 1)
            ->where('appstatus', 'Pending')
            ->whereDate('applicationno_datetime_submission', '<=', '2025-09-12')
            ->whereIn('archive_status', [0, 1])
            ->orderBy('id')
            ->chunkById(500, function ($rows) use (
                &$total,
                &$statusSummary,
                $clinicType
            ) {

                DB::transaction(function () use (
                    $rows,
                    &$total,
                    &$statusSummary,
                    $clinicType
                ) {

                    foreach ($rows as $row) {

                        $total++;

                        $result = $this->parser->parse(
                            $row->dateestab,
                            $row->applicationno_datetime_submission
                        );

                        $statusSummary[$result['status']]++;

                        DB::table('corrected_establishment_date')
                            ->updateOrInsert(

                                [
                                    'application_no' => $row->applicationno
                                ],

                                [

                                    'app_id' => $row->id,

                                    'clinic_type' => $clinicType,

                                    'state' => $row->state,

                                    'applicationno_datetime_submission' => $row->applicationno_datetime_submission,

                                    'status' => $result['status'],

                                    'old_establishment_date' => $row->dateestab,

                                    'corrected_establishment_date' => $result['date'],

                                    'updated_at' => now()

                                ]

                            );
                    }
                });
            });

        return response()->json([

            'success' => true,

            'source_table' => $table,

            'clinic_type' => $clinicType,

            'total_records' => $total,

            'status_summary' => [

                'status_1_direct' => $statusSummary[1],

                'status_2_ambiguous_before_2022' => $statusSummary[2],

                'status_3_text_month' => $statusSummary[3],

                'status_4_numeric_string' => $statusSummary[4],

                'status_5_failed' => $statusSummary[5],

                'status_6_ambiguous_2022_onwards' => $statusSummary[6],

                'status_7_after_application_date' => $statusSummary[7]

            ]

        ]);
    }
    // {"success":true,"source_table":"artclinic","clinic_type":"ARTCLINIC","total_records":2204,"status_summary":{"status_1_direct":707,"status_2_ambiguous_before_2022":396,"status_3_text_month":749,"status_4_numeric_string":29,"status_5_failed":33,"status_6_ambiguous_2022_onwards":156,"status_7_after_application_date":134}}
    // {"success":true,"source_table":"artbank","clinic_type":"ARTBANK","total_records":593,"status_summary":{"status_1_direct":224,"status_2_ambiguous_before_2022":81,"status_3_text_month":164,"status_4_numeric_string":5,"status_5_failed":19,"status_6_ambiguous_2022_onwards":71,"status_7_after_application_date":29}}
    // {"success":true,"source_table":"surrogacyclinic","clinic_type":"ARTSURROGACY","total_records":389,"status_summary":{"status_1_direct":162,"status_2_ambiguous_before_2022":59,"status_3_text_month":135,"status_4_numeric_string":2,"status_5_failed":4,"status_6_ambiguous_2022_onwards":20,"status_7_after_application_date":7}}
}


