<?php

namespace App\Helpers;

use App\Models\clinic\ArtClinicModel;
use App\Models\clinic\BankModel;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\ArtClinicCertificateDetails;
use App\Models\clinic\BankCertificateDetails;
use App\Models\clinic\SurrogacyClinicCertificateDetails;
use App\Models\renewal\RenewalSCApplication;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\renewal\RenewalFee;
use App\Models\ChangeAddress\ChangeAddressApplication;
use App\Models\ChangeAddress\ChangeAddressFee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class dashboardHelper
{
    public static function countClinic($status = NULL)
    {
        if ($status) {
            $data = ArtClinicCertificateDetails::where('approved_rejected', $status)->count();
            $data = ArtClinicModel::with('certificate')->whereHas('certificate', function ($q) {
                $q->where('approved_rejected', 'Registration Rejected');
            })->count();
        } else {
            $data = ArtClinicModel::where('status', 1)->whereIn('archive_status', [0, 1])->count();
        }
        return $data ? $data : 0;
    }

    public static function countBank($status = NULL)
    {
        if ($status) {
            $data = BankCertificateDetails::where('approved_rejected', $status)->count();
            $data = BankModel::with('certificate')->whereHas('certificate', function ($q) {
                $q->where('approved_rejected', 'Registration Rejected');
            })->count();
        } else {
            $data = BankModel::where('status', 1)->whereIn('archive_status', [0, 1])->count();
        }
        return $data ? $data : 0;
    }

    public static function countSurrogacy($status = NULL)
    {
        if ($status) {
            $data = SurrogacyClinicCertificateDetails::where('approved_rejected', $status)->count();
            $data = SurrogacyClinicModel::with('certificate')
                ->whereHas('certificate', function ($q) {
                    $q->where('approved_rejected', 'Registration Rejected');
                })
                ->count();
        } else {
            $data = SurrogacyClinicModel::where('status', 1)->whereIn('archive_status', [0, 1])->count();
        }
        return $data ? $data : 0;
    }

    public static function notificationDate()
    {
        $notification_date = "2026-06-17";
        return $notification_date;
    }
    public static function getAmountdate($id, $recived_date)
    {
        $renewal = RenewalSCApplication::where('id', $id)->first();

        $clinic_data = ClinicRegistrationModel::where('clinic_id', $renewal->clinic_id)
            ->where('userid_applicant', $renewal->userid)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
        $notification_date = Carbon::parse(self::notificationDate());
        $reciving_ssa_date = Carbon::parse($recived_date);

        $receiveDate = Carbon::parse($reciving_ssa_date);
        
        $certificate_expiery_Date   = Carbon::parse($clinic_data->certificate_valid_date);
        if (!empty($clinic_data->level)) {
            $renewal_fee = RenewalFee::where('clinic_type', $clinic_data->clinic_type)->where('level', $clinic_data->level)->where('status', 1)->first();
        } else {
            $renewal_fee = RenewalFee::where('clinic_type', $clinic_data->clinic_type)->where('status', 1)->first();
        }
        $notification_date_plus_60 = $notification_date->copy()->addDays(61);

        if ($notification_date_plus_60 > $certificate_expiery_Date && $notification_date_plus_60 > $receiveDate) {

            $amount = $renewal_fee->fees_before_expiry;
            $expiry_date = $notification_date_plus_60;
        } else if ($certificate_expiery_Date->gte($receiveDate)) {

            $amount = $renewal_fee->fees_before_expiry;
            $expiry_date = $certificate_expiery_Date;
       
        } else {
            $amount = $renewal_fee->fees_after_expiry;
            $expiry_date = $certificate_expiery_Date;
            
        }
        return [$amount,$expiry_date];
    }

    public static function getAmountdetailsCA($id, $userid, $clinic_type)  // Change address
    {
        $change_add = ChangeAddressApplication::where([
            'id' => $id,
            'userid' => $userid,
            'clinic_type' => $clinic_type
        ])->first();

        if (!$change_add) return null;

        if ($change_add->appstatus === 'Rejected') {
            return $change_add->fee_amount;
        }

        $query = DB::table('renewal_fees')
            ->where('clinic_type', $clinic_type)
            ->where('status', 1);
        if ($clinic_type === 'ARTCLINIC') {

        $clinic_level = ClinicRegistrationModel::where([
            'clinic_id' => $change_add->clinic_id,
            'userid_applicant' => $change_add->userid,
            'status' => 1
        ])->value('level');

        $query->where('level', $clinic_level);
        }
        $fee = $query->first();
        return $fee ? $fee->fees_after_expiry : 0;
    }
}
