<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\clinic\Statetable;
use Illuminate\Support\Facades\Log;

class DailySnapshotController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Report Constants
    |--------------------------------------------------------------------------
    */
    private array $treatmentRows = [

    /*
    |--------------------------------------------------------------------------
    | Section C - Married Couple (case_of = one)
    |--------------------------------------------------------------------------
    */

        'C' => [

            // ART Treatment
            [
                'serial' => '1',
                'metricCode' => 'ART_TREATMENT',
                'metricName' => 'ART Treatment',
                'source' => 'both',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.1',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'AI',
                'categoryName' => 'AI',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.1.1',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_LEVEL1',
                'categoryName' => 'Level-1',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'one',
                'level' => 'Level-1',
            ],
            [
                'serial' => '1.1.2',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_LEVEL2',
                'categoryName' => 'Level-2',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'one',
                'level' => 'Level-2',

            ],
            [
                'serial' => '1.1.3',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'artificial insemination',
                'case' => 'one',
            ],

            [
                'serial' => '1.2',
                'metricCode' => 'IVF',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'IVF',
                'categoryName' => 'IVF-ET',
                'source' => 'both',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.2.1',
                'metricCode' => 'IVF_LEVEL1',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_LEVEL1',
                'categoryName' => 'Level-1',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'level' => 'Level-1',
                'source' => 'both',
                'case' => 'one',
            ],
            [
                'serial' => '1.2.2',
                'metricCode' => 'IVF_LEVEL2',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_LEVEL2',
                'categoryName' => 'Level-2',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'level' => 'Level-2',
                'source' => 'both',
                'case' => 'one',
            ],
            [
                'serial' => '1.2.3',
                'metricCode' => 'IVF_SURROGACY',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_SURROGACY',
                'categoryName' => 'SURROGACY',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'source' => 'surrogacy',
                'case' => 'one',
            ],

            [
                'serial' => '1.3',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ICSI',
                'categoryName' => 'ICSI-ET',
                'source' => 'both',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'one',
                'isParent' => true,
                
            ],
            [
                'serial' => '1.3.1',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_LEVEL1',
                'categoryName' => 'Level-1',
                'source' => 'both',
                'level' => 'Level-1',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'one',
            ],
            [
                'serial' => '1.3.2',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_LEVEL2',
                'categoryName' => 'Level-2',
                'source' => 'both',
                'level' => 'Level-2',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'one',
            ],
            [
                'serial' => '1.3.3',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'one',
            ],

            [
                'serial' => '1.4',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'GIFT',
                'categoryName' => 'GIFT',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'one',
                'isParent' => true,

            ],
            [
                'serial' => '1.4.1',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'one',
            ],
            [
                'serial' => '1.4.2',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'one',
            ],
            [
                'serial' => '1.4.3',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'one',
            ],

            [
                'serial' => '1.5',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'PICSI',
                'categoryName' => 'PICSI',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.5.1',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.5.2',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.5.3',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'one',
            ],

            [
                'serial' => '1.6',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'IMSI',
                'categoryName' => 'IMSI',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.6.1',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.6.2',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.6.3',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'one',
            ],

           [
                'serial' => '1.7',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ROSNI',
                'categoryName' => 'ROSNI',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.7.1',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.7.2',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.7.3',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'one',
            ],

            [
                'serial' => '1.8',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ELSI',
                'categoryName' => 'ELSI',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.8.1',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.8.2',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'one',
            ],
            [
                'serial' => '1.8.3',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'one',
            ],

            [
                'serial' => '1.9',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'OTHERS',
                'categoryName' => 'Others',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'one',
                'isParent' => true,
            ],
            [
                'serial' => '1.9.1',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'one',
            ],
            [
                'serial' => '1.9.2',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'one',
            ],
            [
                'serial' => '1.9.3',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Others',
                'case' => 'one',
            ],

            // IUI (existing logic)
            [
                'serial' => '2',
                'metricCode' => 'IUI',
                'metricName' => 'IUI',
                'source' => 'both',
                'isParent' => true,
                'case' => 'one',
            ],

            [
                'serial' => '2.1',
                'metricCode' => 'IUI_LEVEL1',
                'metricName' => 'IUI',
                'categoryName' => 'Level-1',
                'source' => 'both',
                'level' => 'Level-1',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'one',
            ],

            [
                'serial' => '2.2',
                'metricCode' => 'IUI_LEVEL2',
                'metricName' => 'IUI',
                'categoryName' => 'Level-2',
                'source' => 'both',
                'level' => 'Level-2',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'one',
            ],

            [
                'serial' => '2.3',
                'metricCode' => 'IUI_SURROGACY',
                'metricName' => 'IUI',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'one',
            ],

            // Surrogacy Treatment
            [
                'serial' => '3',
                'metricCode' => 'SURROGACY_TREATMENT',
                'metricName' => 'Surrogacy Treatment',
                'source' => 'surrogacy',
                'treatmentType' => 'surrogacy',
                'treatment' => 'surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'one',
            ],

        ],

    /*
    |--------------------------------------------------------------------------
    | Section D - Single Woman (case_of = two)
    |--------------------------------------------------------------------------
    */

        'D' => [

            // ART Treatment
            [
                'serial' => '1',
                'metricCode' => 'ART_TREATMENT',
                'metricName' => 'ART Treatment',
                'source' => 'both',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.1',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'AI',
                'categoryName' => 'AI',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.1.1',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'two',
            ],
            [
                'serial' => '1.1.2',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'artificial insemination',
                'case' => 'two',
            ],
            [
                'serial' => '1.1.3',
                'metricCode' => 'AI',
                'metricName' => 'ART Treatment (AI)',
                'categoryCode' => 'AI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'artificial insemination',
                'case' => 'two',
            ],

            [
                'serial' => '1.2',
                'metricCode' => 'IVF',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'IVF',
                'categoryName' => 'IVF-ET',
                'source' => 'both',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.2.1',
                'metricCode' => 'IVF',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'case' => 'two',
            ],
            [
                'serial' => '1.2.2',
                'metricCode' => 'IVF',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'case' => 'two',
            ],
            [
                'serial' => '1.2.3',
                'metricCode' => 'IVF',
                'metricName' => 'ART Treatment (IVF-ET)',
                'categoryCode' => 'IVF_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'in vitro fertilization-embryo transfer',
                'case' => 'two',
            ],

            [
                'serial' => '1.3',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ICSI',
                'categoryName' => 'ICSI-ET',
                'source' => 'both',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.3.1',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'two',
            ],
            [
                'serial' => '1.3.2',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'two',
            ],
            [
                'serial' => '1.3.3',
                'metricCode' => 'ICSI',
                'metricName' => 'ART Treatment (ICSI-ET)',
                'categoryCode' => 'ICSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                'case' => 'two',
            ],

            [
                'serial' => '1.4',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'GIFT',
                'categoryName' => 'GIFT',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.4.1',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'two',
            ],
            [
                'serial' => '1.4.2',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'two',
            ],
            [
                'serial' => '1.4.3',
                'metricCode' => 'GIFT',
                'metricName' => 'ART Treatment (GIFT)',
                'categoryCode' => 'GIFT_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'gamete intrafallopian tube transfer',
                'case' => 'two',
            ],

            [
                'serial' => '1.5',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'PICSI',
                'categoryName' => 'PICSI',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.5.1',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.5.2',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.5.3',
                'metricCode' => 'PICSI',
                'metricName' => 'ART Treatment (PICSI)',
                'categoryCode' => 'PICSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'physiological Intra-cytoplasmic sperm injection',
                'case' => 'two',
            ],

            [
                'serial' => '1.6',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'IMSI',
                'categoryName' => 'IMSI',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.6.1',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.6.2',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.6.3',
                'metricCode' => 'IMSI',
                'metricName' => 'ART Treatment (IMSI)',
                'categoryCode' => 'IMSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'intra-cytoplasmic morphologically selected sperm injection',
                'case' => 'two',
            ],

            [
                'serial' => '1.7',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ROSNI',
                'categoryName' => 'ROSNI',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.7.1',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.7.2',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.7.3',
                'metricCode' => 'ROSNI',
                'metricName' => 'ART Treatment (ROSNI)',
                'categoryCode' => 'ROSNI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'round spermatid nucleus injection',
                'case' => 'two',
            ],

            [
                'serial' => '1.8',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'ELSI',
                'categoryName' => 'ELSI',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.8.1',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.8.2',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'two',
            ],
            [
                'serial' => '1.8.3',
                'metricCode' => 'ELSI',
                'metricName' => 'ART Treatment (ELSI)',
                'categoryCode' => 'ELSI_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Elongated spermatid injection',
                'case' => 'two',
            ],

            [
                'serial' => '1.9',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment',
                'categoryCode' => 'OTHERS',
                'categoryName' => 'Others',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'two',
                'isParent' => true,
            ],
            [
                'serial' => '1.9.1',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'two',
            ],
            [
                'serial' => '1.9.2',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',
                'procedure' => 'Others',
                'case' => 'two',
            ],
            [
                'serial' => '1.9.3',
                'metricCode' => 'OTHERS',
                'metricName' => 'ART Treatment (Others)',
                'categoryCode' => 'OTHERS_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'Others',
                'case' => 'two',
            ],

            // IUI
            [
                'serial' => '2',
                'metricCode' => 'IUI',
                'metricName' => 'IUI',
                'source' => 'both',
                'case' => 'two',
                'isParent' => true,
            ],

            [
                'serial' => '2.1',
                'metricCode' => 'IUI_LEVEL1',
                'metricName' => 'IUI',
                'categoryCode' => 'LEVEL1',
                'categoryName' => 'Level-1',
                'source' => 'both',
                'level' => 'Level-1',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'two',
            ],

            [
                'serial' => '2.2',
                'metricCode' => 'IUI_LEVEL2',
                'metricName' => 'IUI',
                'categoryCode' => 'LEVEL2',
                'categoryName' => 'Level-2',
                'source' => 'both',
                'level' => 'Level-2',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'two',
            ],

            [
                'serial' => '2.3',
                'metricCode' => 'IUI_SURROGACY',
                'metricName' => 'IUI',
                'categoryCode' => 'SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'case' => 'two',
            ],

            // Surrogacy Treatment
            [
                'serial' => '3',
                'metricCode' => 'SURROGACY_TREATMENT',
                'metricName' => 'Surrogacy Treatment',
                'source' => 'surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'treatmentType' => 'surrogacy',
            ],

        ],

        /*
        |--------------------------------------------------------------------------
        | Section E - ART Treatment by Gamete Type
        |--------------------------------------------------------------------------
        */

        'E' => [

            // IUI(H)
           [
                'serial' => '1',
                'metricCode' => 'IUI_H',
                'metricName' => 'IUI(H)',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using self gametes',
                'source' => 'both',
                'isParent' => true,
            ],
            [
                'serial' => '1.1',
                'metricCode' => 'IUI_H',
                'metricName' => 'IUI(H)',
                'categoryCode' => 'IUI_H_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using self gametes',
                'source' => 'both',
            ],
            [
                'serial' => '1.2',
                'metricCode' => 'IUI_H',
                'metricName' => 'IUI(H)',
                'categoryCode' => 'IUI_H_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using self gametes',
                'source' => 'both',
            ],
            [
                'serial' => '1.3',
                'metricCode' => 'IUI_H',
                'metricName' => 'IUI(H)',
                'categoryCode' => 'IUI_H_SURROGACY',
                'categoryName' => 'Surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using self gametes',
                'source' => 'surrogacy',
            ],

            // [
            //     'serial' => '1.1',
            //     'metricCode' => 'IUI_H_IVF',
            //     'metricName' => 'IUI(H)',
            //     'categoryCode' => 'IVF',
            //     'categoryName' => 'IVF',
            //     'procedure' => 'intra-uterine insemination(IUI)',
            //     'artTreatmentType' => 'ART Treatment using self gametes',
            //     'source' => 'surrogacy',
            // ],

            // [
            //     'serial' => '1.2',
            //     'metricCode' => 'IUI_H_ICSI',
            //     'metricName' => 'IUI(H)',
            //     'categoryCode' => 'ICSI',
            //     'categoryName' => 'ICSI',
            //     'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
            //     'artTreatmentType' => 'ART Treatment using self gametes',
            //     'source' => 'both',
            // ],

            // IUI(D)
           [
                'serial' => '2',
                'metricCode' => 'IUI_D',
                'metricName' => 'IUI(D)',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using donor gametes',
                'source' => 'both',
                'isParent' => true,
            ],
            [
                'serial' => '2.1',
                'metricCode' => 'IUI_D',
                'metricName' => 'IUI(D)',
                'categoryCode' => 'IUI_D_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using donor gametes',
                'source' => 'both',
            ],
            [
                'serial' => '2.2',
                'metricCode' => 'IUI_D',
                'metricName' => 'IUI(D)',
                'categoryCode' => 'IUI_D_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using donor gametes',
                'source' => 'both',
            ],
            [
                'serial' => '2.3',
                'metricCode' => 'IUI_D',
                'metricName' => 'IUI(D)',
                'categoryCode' => 'IUI_D_SURROGACY',
                'categoryName' => 'Surrogacy',
                'procedure' => 'intra-uterine insemination(IUI)',
                'artTreatmentType' => 'ART Treatment using donor gametes',
                'source' => 'surrogacy',
            ],

            // [
            //     'serial' => '2.1',
            //     'metricCode' => 'IUI_D_IVF',
            //     'metricName' => 'IUI(D)',
            //     'categoryCode' => 'IVF',
            //     'categoryName' => 'IVF',
            //     'procedure' => 'in vitro fertilization-embryo transfer',
            //     'artTreatmentType' => 'ART Treatment using donor gametes',
            //     'source' => 'both',
            // ],

            // [
            //     'serial' => '2.2',
            //     'metricCode' => 'IUI_D_ICSI',
            //     'metricName' => 'IUI(D)',
            //     'categoryCode' => 'ICSI',
            //     'categoryName' => 'ICSI',
            //     'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
            //     'artTreatmentType' => 'ART Treatment using donor gametes',
            //     'source' => 'both',
            // ],

        ],

        /*
        |--------------------------------------------------------------------------
        | Section F
        |--------------------------------------------------------------------------
        */

        'F' => [

                [
                    'serial' => '1',
                    'metricCode' => 'ICSI',
                    'metricName' => 'ICSI',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'isParent' => true,
                ],

                [
                    'serial' => '1.1',
                    'metricCode' => 'ICSI_SELF',
                    'metricName' => 'ICSI (Self Gametes)',
                    'categoryCode' => 'SELF',
                    'categoryName' => 'Self Gametes',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                    'isParent' => true,

                ], [
                    'serial' => '1.1.1',
                    'metricCode' => 'ICSI_SELF',
                    'metricName' => 'ICSI (Self Gametes)',
                    'categoryCode' => 'SELF_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ], [
                    'serial' => '1.1.2',
                    'metricCode' => 'ICSI_SELF',
                    'metricName' => 'ICSI (Self Gametes)',
                    'categoryCode' => 'SELF_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ],
                [
                    'serial' => '1.1.3',
                    'metricCode' => 'ICSI_SELF',
                    'metricName' => 'ICSI (Self Gametes)',
                    'categoryCode' => 'SELF_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ],

                [
                    'serial' => '1.2',
                    'metricCode' => 'ICSI_DONOR',
                    'metricName' => 'ICSI (Donor Gametes)',
                    'categoryCode' => 'DONOR',
                    'categoryName' => 'Donor Gametes',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                    'isParent' => true,

                ],[
                    'serial' => '1.2.1',
                    'metricCode' => 'ICSI_DONOR',
                    'metricName' => 'ICSI (Donor Gametes)',
                    'categoryCode' => 'DONOR_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ],[
                    'serial' => '1.2.2',
                    'metricCode' => 'ICSI_DONOR',
                    'metricName' => 'ICSI (Donor Gametes)',
                    'categoryCode' => 'DONOR_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ],[
                    'serial' => '1.2.3',
                    'metricCode' => 'ICSI_DONOR',
                    'metricName' => 'ICSI  (Donor Gametes)',
                    'categoryCode' => 'DONOR_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'procedure' => 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ],

                [
                    'serial' => '2',
                    'metricCode' => 'IVF',
                    'metricName' => 'IVF',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'isParent' => true,
                ],

                [
                    'serial' => '2.1',
                    'metricCode' => 'IVF_SELF',
                    'metricName' => 'IVF',
                    'categoryCode' => 'SELF',
                    'categoryName' => 'Self Gametes',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                    'isParent' => true,

                ],[
                    'serial' => '2.1.1',
                    'metricCode' => 'IVF_SELF',
                    'metricName' => 'IVF (Self Gametes)',
                    'categoryCode' => 'SELF_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ],[
                    'serial' => '2.1.2',
                    'metricCode' => 'IVF_SELF',
                    'metricName' => 'IVF (Self Gametes)',
                    'categoryCode' => 'SELF_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ],[
                    'serial' => '2.1.3',
                    'metricCode' => 'IVF_SELF',
                    'metricName' => 'IVF ((Self Gametes))',
                    'categoryCode' => 'SELF_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using self gametes',
                ],

                [
                    'serial' => '2.2',
                    'metricCode' => 'IVF_DONOR',
                    'metricName' => 'IVF',
                    'categoryCode' => 'DONOR',
                    'categoryName' => 'Donor Gametes',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                    'isParent' => true,

                ], [
                    'serial' => '2.2.1',
                    'metricCode' => 'IVF_DONOR',
                    'metricName' => 'IVF (Donor Gametes)',
                    'categoryCode' => 'DONOR_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ], [
                    'serial' => '2.2.2',
                    'metricCode' => 'IVF_DONOR',
                    'metricName' => 'IVF (Donor Gametes)',
                    'categoryCode' => 'DONOR_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ], [
                    'serial' => '2.2.3',
                    'metricCode' => 'IVF_DONOR',
                    'metricName' => 'IVF (Donor Gametes)',
                    'categoryCode' => 'DONOR_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'procedure' => 'in vitro fertilization-embryo transfer',
                    'artTreatmentType' => 'ART Treatment using donor gametes',
                ],

            ],

        /*
        |--------------------------------------------------------------------------
        | Section G - Surrogacy Treatment
        |--------------------------------------------------------------------------
        */

        'G' => [

                [
                    'serial' => '1',
                    'metricCode' => 'SUR_SELF',
                    'metricName' => 'Using Self Gametes',
                    'source' => 'surrogacy',
                    'treatment' => 'surrogacy',
                    'artTreatmentType' => 'Surrogacy using self gametes',
                ],

                [
                    'serial' => '2',
                    'metricCode' => 'SUR_DONOR',
                    'metricName' => 'Using Donor Gametes',
                    'source' => 'surrogacy',
                    'treatment' => 'surrogacy',
                    'artTreatmentType' => 'Surrogacy using donor gametes',
                    'isParent' => true,
                ],

                [
                    'serial' => '2.1',
                    'metricCode' => 'SUR_DONOR_OOCYTE',
                    'metricName' => 'Using Donor Gametes',
                    'categoryCode' => 'DONOR_OOCYTE',
                    'categoryName' => 'Donor Oocyte & Self Sperm',
                    'source' => 'surrogacy',
                    'treatment' => 'surrogacy',
                    'artTreatmentType' => 'Surrogacy using donor gametes',
                    'donation' => 'Donor Oocyte & Self Sperm',
                ],

                [
                    'serial' => '2.2',
                    'metricCode' => 'SUR_DONOR_SPERM',
                    'metricName' => 'Using Donor Gametes',
                    'categoryCode' => 'DONOR_SPERM',
                    'categoryName' => 'Self Oocyte & Donor Sperm',
                    'source' => 'surrogacy',
                    'treatment' => 'surrogacy',
                    'artTreatmentType' => 'Surrogacy using donor gametes',
                    'donation' => 'Self Oocyte & Donor Sperm',
                ],

            ],
            'H' => [

                [
                    'serial' => '1',
                    'metricCode' => 'MALE_FACTOR',
                    'metricName' => 'Cause of Infertility',
                    'categoryCode' => 'MALE',
                    'categoryName' => 'Male Factor',
                    'source' => 'both',
                    'isParent' => true,

                    'artColumnFilters' => [
                        'male_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_male_factor' => 'Y',
                    ],
                ],[
                    'serial' => '1.1',
                    'metricCode' => 'MALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Male Factor)',
                    'categoryCode' => 'MALE_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',

                    'artColumnFilters' => [
                        'male_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_male_factor' => 'Y',
                    ],
                ],[
                    'serial' => '1.2',
                    'metricCode' => 'MALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Male Factor)',
                    'categoryCode' => 'MALE_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',

                    'artColumnFilters' => [
                        'male_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_male_factor' => 'Y',
                    ],
                ],[
                    'serial' => '1.3',
                    'metricCode' => 'MALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Male Factor)',
                    'categoryCode' => 'MALE_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',

                    'artColumnFilters' => [
                        'male_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_male_factor' => 'Y',
                    ],
                ],

                [
                    'serial' => '2',
                    'metricCode' => 'FEMALE_FACTOR',
                    'metricName' => 'Cause of Infertility',
                    'categoryCode' => 'FEMALE',
                    'categoryName' => 'Female Factor',
                    'source' => 'both',
                    'isParent' => true,

                    'artColumnFilters' => [
                        'female_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_female_factor' => 'Y',
                    ],
                ],[
                    'serial' => '2.1',
                    'metricCode' => 'FEMALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Female Factor)',
                    'categoryCode' => 'FEMALE_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'artColumnFilters' => [
                        'female_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_female_factor' => 'Y',
                    ],
                ],[
                    'serial' => '2.2',
                    'metricCode' => 'FEMALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Female Factor)',
                    'categoryCode' => 'FEMALE_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'artColumnFilters' => [
                        'female_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_female_factor' => 'Y',
                    ],
                ],[
                    'serial' => '2.3',
                    'metricCode' => 'FEMALE_FACTOR',
                    'metricName' => 'Cause of Infertility (Female Factor)',
                    'categoryCode' => 'FEMALE_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'artColumnFilters' => [
                        'female_factor' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_female_factor' => 'Y',
                    ],
                ],

                [
                    'serial' => '3',
                    'metricCode' => 'UNEXPLAINED',
                    'metricName' => 'Cause of Infertility',
                    'categoryCode' => 'UNEXPLAINED',
                    'categoryName' => 'Unexplained',
                    'source' => 'both',
                    'isParent' => true,

                    'artColumnFilters' => [
                        'unexplained' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_unexplained' => 'Y',
                    ],
                ],[
                    'serial' => '3.1',
                    'metricCode' => 'UNEXPLAINED',
                    'metricName' => 'Cause of Infertility (Unexplained)',
                    'categoryCode' => 'UNEXPLAINED_LEVEL1',
                    'categoryName' => 'Level-1',
                    'level' => 'Level-1',
                    'source' => 'both',
                    'artColumnFilters' => [
                        'unexplained' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_unexplained' => 'Y',
                    ],
                ],[
                    'serial' => '3.2',
                    'metricCode' => 'UNEXPLAINED',
                    'metricName' => 'Cause of Infertility (Unexplained)',
                    'categoryCode' => 'UNEXPLAINED_LEVEL2',
                    'categoryName' => 'Level-2',
                    'level' => 'Level-2',
                    'source' => 'both',
                    'artColumnFilters' => [
                        'unexplained' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_unexplained' => 'Y',
                    ],
                ],[
                    'serial' => '3.3',
                    'metricCode' => 'UNEXPLAINED',
                    'metricName' => 'Cause of Infertility (Unexplained)',
                    'categoryCode' => 'UNEXPLAINED_SURROGACY',
                    'categoryName' => 'Surrogacy',
                    'source' => 'surrogacy',
                    'artColumnFilters' => [
                        'unexplained' => 'Y',
                    ],

                    'surrogacyColumnFilters' => [
                        'art_unexplained' => 'Y',
                    ],
                ],

            ],
            'I' => [

                [
                    'serial' => '1',
                    'metricCode' => 'UTERUS_AB',
                    'metricName' => 'Medical Indication Necessitating Surrogacy',
                    'categoryCode' => 'UTERUS_AB',
                    'categoryName' => 'Uterus Abnormalities',
                    'source' => 'surrogacy',
                    'surrogacyColumnFilters' => [
                        'uterus_ab' => 'Y',
                    ],
                ],

                [
                    'serial' => '2',
                    'metricCode' => 'IVF_FAILURE',
                    'metricName' => 'Medical Indication Necessitating Surrogacy',
                    'categoryCode' => 'IVF_FAILURE',
                    'categoryName' => 'Repeated IVF Failure',
                    'source' => 'surrogacy',
                    'surrogacyColumnFilters' => [
                        'ivf_failure' => 'Y',
                    ],
                ],

                [
                    'serial' => '3',
                    'metricCode' => 'PREG_LOSS',
                    'metricName' => 'Medical Indication Necessitating Surrogacy',
                    'categoryCode' => 'PREG_LOSS',
                    'categoryName' => 'Multiple Pregnancy Loss',
                    'source' => 'surrogacy',
                    'surrogacyColumnFilters' => [
                        'preg_loss' => 'Y',
                    ],
                ],

                [
                    'serial' => '4',
                    'metricCode' => 'LIFE_THREAT',
                    'metricName' => 'Medical Indication Necessitating Surrogacy',
                    'categoryCode' => 'LIFE_THREAT',
                    'categoryName' => 'Life Threatening Illness',
                    'source' => 'surrogacy',
                    'surrogacyColumnFilters' => [
                        'life_threat' => 'Y',
                    ],
                ],

                [
                    'serial' => '5',
                    'metricCode' => 'MALE_FACTOR',
                    'metricName' => 'Medical Indication Necessitating Surrogacy',
                    'categoryCode' => 'MALE_FACTOR',
                    'categoryName' => 'Male Factor',
                    'source' => 'surrogacy',
                    'surrogacyColumnFilters' => [
                        'male_factor' => 'Y',
                    ],
                ],

            ],
            'J' => [
                [
                    'serial' => '1',
                    'metricCode' => 'PREVIOUS_CHILD_YES',
                    'metricName' => 'Previous Surviving Child',
                    'categoryCode' => 'YES',
                    'categoryName' => 'Yes',
                    'source' => 'surrogacy',

                    'surrogacyColumnFilters' => [
                        'num_pre_child' => 'Yes',
                    ],
                ],

                [
                    'serial' => '2',
                    'metricCode' => 'PREVIOUS_CHILD_NO',
                    'metricName' => 'Previous Surviving Child',
                    'categoryCode' => 'NO',
                    'categoryName' => 'No',
                    'source' => 'surrogacy',

                    'surrogacyColumnFilters' => [
                        'num_pre_child' => 'No',
                    ],
                ],

            ],
            'K' => [

            // Pregnant
            [
                'serial' => '1',
                'metricCode'   => 'PREGNANT',
                'metricName'   => 'Pregnant',
                'isParent'     => true,
            ],

            [
                'serial' => '1.1',
                'metricCode' => 'PREGNANT_ART',
                'metricName' => 'Pregnant',
                'categoryCode' => 'ART',
                'categoryName' => 'ART Treatment',
                'source' => 'both',
                'isParent'     => true,
                'artColumnFilters' => [
                    'treat_outcomes' => 'Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Pregnant',
                ],
            ],[
                'serial' => '1.1.1',
                'metricCode' => 'PREGNANT_ART',
                'metricName' => 'Pregnant (ART Treatment)',
                'categoryCode' => 'ART_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Pregnant',
                ],
            ],[
                'serial' => '1.1.2',
                'metricCode' => 'PREGNANT_ART',
                'metricName' => 'Pregnant (ART Treatment)',
                'categoryCode' => 'ART_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Pregnant',
                ],
            ],[
                'serial' => '1.1.3',
                'metricCode' => 'PREGNANT_ART',
                'metricName' => 'Pregnant (ART Treatment)',
                'categoryCode' => 'ART_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Pregnant',
                ],
            ],


            [
                'serial' => '1.2',
                'metricCode' => 'PREGNANT_SURROGACY',
                'metricName' => 'Pregnant',
                'categoryCode' => 'SURROGACY',
                'categoryName' => 'Surrogacy Treatment',
                'source' => 'surrogacy',

                'surrogacyColumnFilters' => [
                    'tratment_Outcome' => 'Pregnant',
                ],
            ],

            // Not Pregnant
            [
                'serial' => '2',
                'metricCode'   => 'NOT_PREGNANT',
                'metricName'   => 'Not Pregnant',
                'isParent'     => true,
            ],

            [
                'serial' => '2.1',
                'metricCode' => 'NOT_PREGNANT_ART',
                'metricName' => 'Not Pregnant',
                'categoryCode' => 'ART',
                'categoryName' => 'ART Treatment',
                'source' => 'both',
                'isParent'     => true,
                'artColumnFilters' => [
                    'treat_outcomes' => 'Not Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Not Pregnant',
                ],
            ], [
                'serial' => '2.1.1',
                'metricCode' => 'NOT_PREGNANT_ART',
                'metricName' => 'Not Pregnant (ART Treatment)',
                'categoryCode' => 'ART_LEVEL1',
                'categoryName' => 'Level-1',
                'level' => 'Level-1',
                'source' => 'both',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Not Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Not Pregnant',
                ],
            ], [
                'serial' => '2.1.2',
                'metricCode' => 'NOT_PREGNANT_ART',
                'metricName' => 'Not Pregnant (ART Treatment)',
                'categoryCode' => 'ART_LEVEL2',
                'categoryName' => 'Level-2',
                'level' => 'Level-2',
                'source' => 'both',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Not Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Not Pregnant',
                ],
            ], [
                'serial' => '2.1.3',
                'metricCode' => 'NOT_PREGNANT_ART',
                'metricName' => 'Not Pregnant (ART Treatment)',
                'categoryCode' => 'ART_SURROGACY',
                'categoryName' => 'Surrogacy',
                'source' => 'surrogacy',

                'artColumnFilters' => [
                    'treat_outcomes' => 'Not Pregnant',
                ],

                'surrogacyColumnFilters' => [
                    'art_treat_outcomes' => 'Not Pregnant',
                ],
            ],
            [
                'serial' => '2.2',
                'metricCode' => 'NOT_PREGNANT_SURROGACY',
                'metricName' => 'Not Pregnant',
                'categoryCode' => 'SURROGACY',
                'categoryName' => 'Surrogacy Treatment',
                'source' => 'surrogacy',

                'surrogacyColumnFilters' => [
                    'tratment_Outcome' => 'Not Pregnant',
                ],
            ],

        ],

    ];
    public function index()
    {
        try{
        $reportDate = request('report_date', date('Y-m-d'));
        $reportType = request('report_type', 'National');
        $stateName  = request('state_name');
        $view       = request('view', 'total'); // total | all | 2022 | 2023 ...

        $db = DB::connection(env('DB_SECOND_CONNECTION'));

        /*
        |--------------------------------------------------------------------------
        | Snapshot
        |--------------------------------------------------------------------------
        */

        $snapshotQuery = $db->table('report_snapshot')
            ->where('report_date', $reportDate)
            ->where('report_type', $reportType);

        if ($reportType == 'National') {
            $snapshotQuery->whereNull('state_name');
        } else {
            $snapshotQuery->where('state_name', strtoupper($stateName));
        }
        $snapshot = $snapshotQuery->first();
        if ($snapshot) {
                $reportDate = $snapshot->report_date;
                $reportgeneratedtime = $snapshot->generated_at;
            }
        if (!$snapshot) {
            $fallbackQuery = $db->table('report_snapshot')
                ->where('report_type', $reportType);

            if ($reportType == 'National') {
                $fallbackQuery->whereNull('state_name');
            } else {
                $fallbackQuery->where('state_name', strtoupper($stateName));
            }

            $snapshot = $fallbackQuery
                ->orderByDesc('report_date')
                ->first();
            if ($snapshot) {
                $reportDate = $snapshot->report_date;
                $reportgeneratedtime = $snapshot->generated_at;
            }
        }
        if (!$snapshot) {
            abort(404, 'Report Snapshot Not Found');
        }

        /*
        |--------------------------------------------------------------------------
        | Detail Rows
        |--------------------------------------------------------------------------
        */

        $details = $db->table('report_snapshot_detail') ->where('report_snapshot_id', $snapshot->id) ->orderBy('section') ->orderByRaw(" CAST(SUBSTRING_INDEX(serial_no,'.',1) AS UNSIGNED), CAST( IF( serial_no LIKE '%.%', SUBSTRING_INDEX(SUBSTRING_INDEX(serial_no,'.',2),'.',-1), 0 ) AS UNSIGNED ), CAST( IF( serial_no LIKE '%.%.%', SUBSTRING_INDEX(serial_no,'.',-1), 0 ) AS UNSIGNED ) ") ->get();

        /*
        |--------------------------------------------------------------------------
        | Year-wise Data
        |--------------------------------------------------------------------------
        */

        $yearData = $db->table('report_snapshot_year')
            ->whereIn('report_snapshot_detail_id', $details->pluck('id'))
            ->orderBy('report_year')
            ->get()
            ->groupBy('report_snapshot_detail_id');

       

        /*
        |--------------------------------------------------------------------------
        | Prepare Data for Blade
        |--------------------------------------------------------------------------
        */

        $startYear   = 2022;
        $currentYear = date('Y');

        /*
        |--------------------------------------------------------------------------
        | Build Tree Maps
        |--------------------------------------------------------------------------
        */

        $treeMap = [];
        $hasChildrenMap = [];
        foreach ($details as $detail) {

            $treeMap[$detail->section . '|' . $detail->serial_no] = $detail->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Data for Blade
        |--------------------------------------------------------------------------
        */

        foreach ($details as $detail) {

            /*
            |--------------------------------------------------------------------------
            | Tree Information
            |--------------------------------------------------------------------------
            */

            $detail->level = substr_count($detail->serial_no, '.');

            $parts = explode('.', $detail->serial_no);

            if (count($parts) > 1) {

                array_pop($parts);

                $parentSerial = implode('.', $parts);

                $detail->parent_id = $treeMap[$detail->section . '|' . $parentSerial] ?? null;

                if ($detail->parent_id) {
                    $hasChildrenMap[$detail->parent_id] = true;
                }

            } else {

                $detail->parent_id = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Year Wise Data
            |--------------------------------------------------------------------------
            */

            $detail->years = [];

            for ($y = $startYear; $y <= $currentYear; $y++) {
                $detail->years[$y] = 0;
            }

            if (isset($yearData[$detail->id])) {

                foreach ($yearData[$detail->id] as $row) {

                    $detail->years[$row->report_year] = $row->total_count;
                }
            }

            $detail->selected_count = null;

            if ($view != 'total' && $view != 'all') {

                $detail->selected_count = $detail->years[$view] ?? 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Has Children
        |--------------------------------------------------------------------------
        */

        foreach ($details as $detail) {

            $detail->has_children = $hasChildrenMap[$detail->id] ?? false;
        }

        $states = StateTable::query()
                ->orderBy('state_name')
                ->pluck('state_name');

        return view(
            'layouts.admin.reporting.daily_snapshot',
            [
                'snapshot'    => $snapshot,
                'details'     => $details,
                'view'        => $view,
                'reportDate'  => $reportDate,
                'reportType'  => $reportType,
                'stateName'   => $stateName,
                'currentYear' => $currentYear,
                'states'      => $states,
                'reportgeneratedtime'      => $reportgeneratedtime,
            ]
        );
        }
        catch (\Exception $e) {
        Log::error('not able to view the daily report page: ' . $e->getMessage());
        return redirect()->route('dashboard')->with('error', 'An error occurred while viewing the daily report page.');
        }

    }
    public function generateSnapshot($reportDate, $reportType = 'National', $stateName = null)
    {
        set_time_limit(0);
        $db = DB::connection(env('DB_SECOND_CONNECTION'));

        $db->transaction(function () use ($db, $reportDate, $reportType, $stateName) {

            /*
            |--------------------------------------------------------------------------
            | Delete Existing Snapshot (Optional)
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | Insert report_snapshot
            |--------------------------------------------------------------------------
            */
            $db->table('report_snapshot')
                ->where('report_date', $reportDate)
                ->where('report_type', $reportType)
                ->where('state_name', $reportType == 'National' ? null : strtoupper($stateName))
                ->delete();

            $snapshotId = $db->table('report_snapshot')->insertGetId([
                'report_date'  => $reportDate,
                'report_type'  => $reportType,
                'state_name'   => $reportType == 'National' ? null : strtoupper($stateName),
                'generated_at' => now(),
                'generated_by' => session('user_id') ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | SECTION A
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | A.1 Patient Records Submitted by ART Clinics
            |--------------------------------------------------------------------------
            */

            $this->insertSubmittedRecordMetric(
                $db,
                $snapshotId,
                $reportType,
                $stateName,
                'patient_artclinic',
                'A',
                1,
                'ART_PATIENT_SUBMITTED',
                'Patient Records Submitted by ART Clinics'
            );

            /*
            |--------------------------------------------------------------------------
            | A.2 Donor Records Submitted by ART Banks
            |--------------------------------------------------------------------------
            */

            $this->insertSubmittedRecordMetric(
                $db,
                $snapshotId,
                $reportType,
                $stateName,
                'patient_artbank',
                'A',
                2,
                'ART_BANK_DONOR_SUBMITTED',
                'Donor Records Submitted by ART Banks'
            );

            /*
            |--------------------------------------------------------------------------
            | A.3 Patient Records Submitted by Surrogacy Clinics
            |--------------------------------------------------------------------------
            */

            $this->insertSubmittedRecordMetric(
                $db,
                $snapshotId,
                $reportType,
                $stateName,
                'patient_surrogacyclinic',
                'A',
                3,
                'SURROGACY_PATIENT_SUBMITTED',
                'Patient Records Submitted by Surrogacy Clinics'
            );

            /*
            |--------------------------------------------------------------------------
            | SECTION C to G
            |--------------------------------------------------------------------------
            */
            $this->generateTreatmentSections(
                $db,
                $snapshotId,
                $reportType,
                $stateName
            );
        });
    }
    private function insertDetail(
        $db,
        $snapshotId,
        $section,
        $serialNo,
        $metricCode,
        $metricName,
        $total,
        array $yearWise,
        $categoryCode = null,
        $categoryName = null
    )
    {
        $detailId = $db->table('report_snapshot_detail')->insertGetId([
            'report_snapshot_id' => $snapshotId,
            'section'            => $section,
            'serial_no'          => $serialNo,
            'metric_code'        => $metricCode,
            'metric_name'        => $metricName,
            'category_code'      => $categoryCode,
            'category_name'      => $categoryName,
            'total_count'        => $total,
        ]);

        foreach ($yearWise as $year => $count) {
            $db->table('report_snapshot_year')->insert([
                'report_snapshot_detail_id' => $detailId,
                'report_year'               => $year,
                'total_count'               => $count,
            ]);
        }
    }
    /**
     * Insert submitted record metric into snapshot
     */
    private function insertSubmittedRecordMetric(
        $db,
        $snapshotId,
        $reportType,
        $stateName,
        $table,
        $section,
        $serialNo,
        $metricCode,
        $metricName
    ) {
        $artDb = DB::connection(config('database.default'))->getDatabaseName();

        $query = $db->table($table . ' as p')
            ->join('patient_period_reporting_table as pp', 'pp.id', '=', 'p.reporting_id')
            ->join($artDb . '.clinic_registration as cr', 'cr.clinic_id', '=', 'pp.clinic_id')
            ->where('pp.status', 'Finished')
            ->where('cr.status', 1);

        if ($reportType == 'State') {
            $query->where('cr.state', strtoupper($stateName));
        }

        /*
        |--------------------------------------------------------------------------
        | Total Count
        |--------------------------------------------------------------------------
        */

        $total = (clone $query)->count('p.id');

        /*
        |--------------------------------------------------------------------------
        | Year Wise Count
        |--------------------------------------------------------------------------
        */
        $yearWise = (clone $query)
            ->select(
                'pp.year',
                DB::raw('COUNT(p.id) as total')
            )
            ->groupBy('pp.year')
            ->orderBy('pp.year')
            ->pluck('total', 'pp.year')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Insert Detail
        |--------------------------------------------------------------------------
        */

        $this->insertDetail(
            $db,
            $snapshotId,
            $section,
            $serialNo,
            $metricCode,
            $metricName,
            $total,
            $yearWise
        );
    }
    private function insertTreatmentReport(
        $db,
        $snapshotId,

        // Snapshot Info
        $section,
        $serialNo,
        $metricCode,
        $metricName,
        $categoryCode = null,
        $categoryName = null,

        // Report Scope
        $reportType,
        $stateName,

        // Source
        $includeArtClinic = true,
        $includeSurrogacyClinic = true,

        // Common Filters
        $caseOf = null,

        // Procedure
        $procedure = null,

        // Clinic Level
        $level = null,

        // Gamete Type
        $artTreatmentType = null,

        // Treatment Type
        $treatmentType = null,

        // Donation Type
        $donationType = null,
        // Generic Column Filter
        $artColumnFilters = [],
        $surrogacyColumnFilters = []
    ) {

        $artDbName = DB::connection(config('database.default'))->getDatabaseName();

        $artTotal = 0;
        $artYearWise = [];

        $surTotal = 0;
        $surYearWise = [];

        /*
        |--------------------------------------------------------------------------
        | ART Clinic
        |--------------------------------------------------------------------------
        */

        if ($includeArtClinic) {

            $artQuery = $db->table('patient_artclinic as p')
                ->join('patient_period_reporting_table as pp', 'pp.id', '=', 'p.reporting_id')
                ->join($artDbName.'.clinic_registration as cr', 'cr.clinic_id', '=', 'pp.clinic_id')
                ->where('pp.status', 'Finished')
                ->where('cr.status', 1);

            /*
            |--------------------------------------------------------------------------
            | State Filter
            |--------------------------------------------------------------------------
            */

            if ($reportType == 'State') {
                $artQuery->where('cr.state', strtoupper($stateName));
            }

            /*
            |--------------------------------------------------------------------------
            | Case Of
            |--------------------------------------------------------------------------
            */

            if (!is_null($caseOf)) {
                $artQuery->where('p.case_of', $caseOf);
            }

            /*
            |--------------------------------------------------------------------------
            | Procedure
            |--------------------------------------------------------------------------
            */

            if (!is_null($procedure)) {
                $artQuery->where('p.art_proc_undertaken', $procedure);
            }

            /*
            |--------------------------------------------------------------------------
            | Clinic Level
            |--------------------------------------------------------------------------
            */

            if (!is_null($level)) {
                $artQuery->where('cr.level', $level);
            }

            /*
            |--------------------------------------------------------------------------
            | Types of Treatment
            |--------------------------------------------------------------------------
            */

            if (!is_null($artTreatmentType)) {
                $artQuery->where('p.types_of_treat', $artTreatmentType);
            }
            /*
            |--------------------------------------------------------------------------
            | Generic Column Filters
            |--------------------------------------------------------------------------
            */

            foreach ($artColumnFilters as $column => $value) {
                $artQuery->where('p.'.$column, $value);
            }

            /*
            |--------------------------------------------------------------------------
            | Total Count
            |--------------------------------------------------------------------------
            */

            $artTotal = (clone $artQuery)->count();

            /*
            |--------------------------------------------------------------------------
            | Year Wise Count
            |--------------------------------------------------------------------------
            */

            $artYearWise = (clone $artQuery)
                ->select(
                    'pp.year',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('pp.year')
                ->pluck('total', 'pp.year')
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | Surrogacy Clinic
        |--------------------------------------------------------------------------
        */

        if ($includeSurrogacyClinic) {

            $surQuery = $db->table('patient_surrogacyclinic as p')
                ->join('patient_period_reporting_table as pp', 'pp.id', '=', 'p.reporting_id')
                ->join($artDbName.'.clinic_registration as cr', 'cr.clinic_id', '=', 'pp.clinic_id')
                ->where('pp.status', 'Finished')
                ->where('cr.status', 1);

            /*
            |--------------------------------------------------------------------------
            | State Filter
            |--------------------------------------------------------------------------
            */

            if ($reportType == 'State') {
                $surQuery->where('cr.state', strtoupper($stateName));
            }

            /*
            |--------------------------------------------------------------------------
            | treatment_type
            |--------------------------------------------------------------------------
            |
            | Examples:
            | art_treatment
            | surrogacy
            |
            */

            if (!is_null($treatmentType)) {
                $surQuery->where('p.treatment_type', $treatmentType);
            }

            /*
            |--------------------------------------------------------------------------
            | art_case_of
            |--------------------------------------------------------------------------
            */

            if (!is_null($caseOf)) {
                if ($treatmentType == 'surrogacy') {
                    $surQuery->where('p.case_of', $caseOf);
                } else {
                    $surQuery->where('p.art_case_of', $caseOf);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Procedure
            |--------------------------------------------------------------------------
            */

            if (!is_null($procedure)) {
                $surQuery->where('p.art_proc_undertaken', $procedure);
            }

            /*
            |--------------------------------------------------------------------------
            | Clinic Level
            |--------------------------------------------------------------------------
            */

            if (!is_null($level)) {
                $surQuery->where('cr.level', $level);
            }

            /*
            |--------------------------------------------------------------------------
            | Treatment Type Mapping
            |--------------------------------------------------------------------------
            |
            | ART Sections (C,D,E,F)
            |     art_types_of_treat
            |
            | Surrogacy Section (G)
            |     types_of_treat
            |
            */

            if (!is_null($artTreatmentType)) {

                if ($treatmentType == 'surrogacy') {

                    $surQuery->where('p.types_of_treat', $artTreatmentType);

                } else {

                    $surQuery->where('p.art_types_of_treat', $artTreatmentType);

                }
            }

            /*
            |--------------------------------------------------------------------------
            | Donation Type
            |--------------------------------------------------------------------------
            |
            | Used only in G.2.1 / G.2.2
            |--------------------------------------------------------------------------
            */

            if (!is_null($donationType)) {

                $surQuery->where('p.types_of_treat1', $donationType);

            }
            /*
            |--------------------------------------------------------------------------
            | Generic Column Filters
            |--------------------------------------------------------------------------
            */

            foreach ($surrogacyColumnFilters as $column => $value) {
                $surQuery->where('p.'.$column, $value);
            }

            /*
            |--------------------------------------------------------------------------
            | Total Count
            |--------------------------------------------------------------------------
            */

            $surTotal = (clone $surQuery)->count();

            /*
            |--------------------------------------------------------------------------
            | Year Wise Count
            |--------------------------------------------------------------------------
            */

            $surYearWise = (clone $surQuery)
                ->select(
                    'pp.year',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('pp.year')
                ->pluck('total', 'pp.year')
                ->toArray();
        }
        /*
        |--------------------------------------------------------------------------
        | Merge Year Wise Data
        |--------------------------------------------------------------------------
        */

        $yearWise = [];

        foreach ($artYearWise as $year => $count) {
            $yearWise[$year] = $count;
        }

        foreach ($surYearWise as $year => $count) {
            if (isset($yearWise[$year])) {
                $yearWise[$year] += $count;
            } else {
                $yearWise[$year] = $count;
            }
        }

        ksort($yearWise);

        /*
        |--------------------------------------------------------------------------
        | Grand Total
        |--------------------------------------------------------------------------
        */

        $totalCount = $artTotal + $surTotal;

        /*
        |--------------------------------------------------------------------------
        | Insert Snapshot Detail
        |--------------------------------------------------------------------------
        */

        $this->insertDetail(
            $db,
            $snapshotId,
            $section,
            $serialNo,
            $metricCode,
            $metricName,
            $totalCount,
            $yearWise,
            $categoryCode,
            $categoryName
        );

    }
    private function generateTreatmentSections(
        $db,
        $snapshotId,
        $reportType,
        $stateName
    )
    {
        foreach ($this->treatmentRows as $section => $rows) {

            foreach ($rows as $row) {
                

                $this->insertTreatmentReport(
                    $db,
                    $snapshotId,

                    $section,
                    $row['serial'],

                    $row['metricCode'],
                    $row['metricName'],

                    $row['categoryCode'] ?? null,
                    $row['categoryName'] ?? null,

                    $reportType,
                    $stateName,

                    // includeArtClinic
                    ($row['source'] ?? 'both') === 'both',

                    // includeSurrogacyClinic
                    in_array(($row['source'] ?? 'both'), ['both', 'surrogacy']),

                    // caseOf
                    $row['case'] ?? null,

                    // procedure
                    $row['procedure'] ?? null,

                    // level
                    $row['level'] ?? null,

                    // artTreatmentType
                    $row['artTreatmentType'] ?? null,

                    // treatmentType
                    $row['treatment'] ?? null,

                    // donationType
                    $row['donation'] ?? null,
                    // art filters
                    $row['artColumnFilters'] ?? [],

                    // surrogacy filters
                    $row['surrogacyColumnFilters'] ?? [],
                );
            }
            $this->calculateSectionParents(
                    $db,
                    $snapshotId,
                    $section
                );

        }
    }
    public function runDailySnapshot()
    {
        // National Snapshot
        $this->generateSnapshot(
            now()->toDateString(),
            'National'
        );

        // Uncomment later if you want to generate State snapshots also
        /*
        $states = StateTable::pluck('state_name');

        foreach ($states as $state) {
            $this->generateSnapshot(
                now()->toDateString(),
                'State',
                strtoupper($state)
            );
        }
        */

        return response()->json([
            'success' => true,
            'message' => 'Daily snapshot generated successfully.'
        ]);
    }
   private function calculateSectionParents(
    $db,
    $snapshotId,
    $section
)
{
    // Fetch all rows for this section
    $rows = $db->table('report_snapshot_detail')
        ->where('report_snapshot_id', $snapshotId)
        ->where('section', $section)
        ->get()
        ->keyBy('serial_no');

    /*
    |--------------------------------------------------------------------------
    | Process deepest parents first
    |--------------------------------------------------------------------------
    |
    | Example order:
    |
    | 1.2
    | 1.3
    | 2.4
    | 1
    | 2
    |
    */

    $parents = collect($this->treatmentRows[$section])
        ->filter(fn($r) => ($r['isParent'] ?? false))
        ->sortByDesc(function ($r) {
            return substr_count($r['serial'], '.');
        });

    foreach ($parents as $parentRow) {

        $parentSerial = $parentRow['serial'];

        if (!isset($rows[$parentSerial])) {
            continue;
        }

        $parent = $rows[$parentSerial];

        $parentDepth = substr_count($parentSerial, '.');

        /*
        |--------------------------------------------------------------------------
        | Immediate children only
        |--------------------------------------------------------------------------
        */

        $children = $rows->filter(function ($row) use ($parentSerial, $parentDepth) {

            if (!str_starts_with($row->serial_no, $parentSerial . '.')) {
                return false;
            }

            return substr_count($row->serial_no, '.') == $parentDepth + 1;

        });

        if ($children->isEmpty()) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Parent Total
        |--------------------------------------------------------------------------
        */

        $parentTotal = $children->sum('total_count');

        $db->table('report_snapshot_detail')
            ->where('id', $parent->id)
            ->update([
                'total_count' => $parentTotal,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Update Parent object also
        |--------------------------------------------------------------------------
        */

        $rows[$parentSerial]->total_count = $parentTotal;

        /*
        |--------------------------------------------------------------------------
        | Year Wise Total
        |--------------------------------------------------------------------------
        */

        $yearWise = [];

        foreach ($children as $child) {

            $years = $db->table('report_snapshot_year')
                ->where('report_snapshot_detail_id', $child->id)
                ->get();

            foreach ($years as $year) {

                if (!isset($yearWise[$year->report_year])) {
                    $yearWise[$year->report_year] = 0;
                }

                $yearWise[$year->report_year] += $year->total_count;
            }
        }

        foreach ($yearWise as $year => $count) {

            $db->table('report_snapshot_year')
                ->updateOrInsert(
                    [
                        'report_snapshot_detail_id' => $parent->id,
                        'report_year' => $year,
                    ],
                    [
                        'total_count' => $count,
                    ]
                );
        }
    }
}
}