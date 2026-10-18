<?php
namespace App\Models\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprehensiveQuarterlyReport extends Model
{
    use HasFactory;
    public $timestamps = true;  
    protected $table= 'comprehensive_quarterly_reports';
    protected $fillable = [
        'report_id','state_id',	'state_auth_id','ip_address','year','quarter','signature','seal','applicant_name','designation','place','sign_pdf_date','upload_sign_pdf','final_date','status','art_clinic_q1','art_clinic_qtr_end_q1',
        'art_banks_q1','art_banks_qtr_end_q1','surrogacy_clinic_q1','surrogacy_clinic_qtr_end_q1','art_clinic_q2','art_clinic_qtr_end_q2','art_banks_q2','art_banks_qtr_end_q2','surrogacy_clinic_q2',
        'surrogacy_clinic_qtr_end_q2','art_clinic_q3','art_clinic_qtr_end_q3','art_banks_q3','art_banks_qtr_end_q3','surrogacy_clinic_q3','surrogacy_clinic_qtr_end_q3','art_clinic_q4',
        'art_clinic_qtr_end_q4','art_banks_q4','art_banks_qtr_end_q4','surrogacy_clinic_q4','surrogacy_clinic_qtr_end_q4','art_clinic_q5','art_clinic_qtr_end_q5','art_banks_q5','art_banks_qtr_end_q5','surrogacy_clinic_q5',
        'surrogacy_clinic_qtr_end_q5','art_clinic_q6','art_clinic_qtr_end_q6','art_banks_q6','art_banks_qtr_end_q6','surrogacy_clinic_q6','surrogacy_clinic_qtr_end_q6','art_clinic_q7','art_clinic_qtr_end_q7','art_banks_q7',
        'art_banks_qtr_end_q7','surrogacy_clinic_q7','surrogacy_clinic_qtr_end_q7','art_clinic_q8','art_clinic_qtr_end_q8','art_banks_q8','art_banks_qtr_end_q8','surrogacy_clinic_q8','surrogacy_clinic_qtr_end_q8',
        'art_clinic_q9','art_clinic_qtr_end_q9','art_banks_q9','art_banks_qtr_end_q9','surrogacy_clinic_q9','surrogacy_clinic_qtr_end_q9','art_clinic_q10','art_clinic_qtr_end_q10','art_banks_q10','art_banks_qtr_end_q10',
        'surrogacy_clinic_q10','surrogacy_clinic_qtr_end_q10','art_clinic_q11','art_clinic_qtr_end_q11','art_banks_q11','art_banks_qtr_end_q11','surrogacy_clinic_q11','surrogacy_clinic_qtr_end_q11','art_clinic_q12',
        'art_clinic_qtr_end_q12','art_banks_q12','art_banks_qtr_end_q12','surrogacy_clinic_q12','surrogacy_clinic_qtr_end_q12','art_clinic_q13','art_clinic_qtr_end_q13','art_banks_q13','art_banks_qtr_end_q13',
        'surrogacy_clinic_q13','surrogacy_clinic_qtr_end_q13','appeal_rej_app_a_q14','appeal_rej_app_qtr_end_a_q14','appeals_disposed_b_q14','appeals_disposed_qtr_end_b_q14','forwarded_dhr_i_q15','forwarded_dhr_qtr_end_i_q15',
        'received_stakeholders_ii_q15','received_stakeholders_qtr_end_ii_q15','suo_moto_cognizancеr_iii_q15','suo_moto_cognizancеr_qtr_end_iii_q15','action_taken_a_q16','action_taken_qtr_end_a_q16','art_clinics_b_q16',
        'art_clinics_qtr_end_b_q16','art_banks_b_q16','art_banks_qtr_end_b_q16','surrogacy_clinics_b_q16','surrogacy_clinics_qtr_end_b_q16','appeal_received_a_q17','appeal_received_qtr_end_a_q17','appeals_disposed_b_q17',
        'appeals_disposed_qtr_end_b_q17','complaints_filed_q18','complaints_filed_qtr_end_q18','applications_received_i_a_q19','applications_received_qtr_end_i_a_q19','applications_received_ii_a_q19',
        'applications_received_qtr_end_ii_a_q19','applications_received_iii_a_q19','applications_received_qtr_end_iii_a_q19','applications_received_iv_a_q19','applications_received_qtr_end_iv_a_q19','applications_granted_i_b_q19',
        'applications_granted_qtr_end_i_b_q19','applications_granted_ii_b_q19','applications_granted_qtr_end_ii_b_q19','applications_granted_iii_b_q19','applications_granted_qtr_end_iii_b_q19',
        'applications_granted_iv_b_q19','applications_granted_qtr_end_iv_b_q19','applications_rejected_i_c_q19','applications_rejected_qtr_end_i_c_q19','applications_rejected_ii_c_q19',
        'applications_rejected_qtr_end_ii_c_q19','applications_rejected_iii_c_q19','applications_rejected_qtr_end_iii_c_q19','applications_rejected_iv_c_q19','applications_rejected_qtr_end_iv_c_q19',
        'appeals_against_rejection_a_q20','appeals_against_rejection_qtr_end_a_q20','appeals_disposed_b_q20','appeals_disposed_qtr_end_b_q20','meeting_date_q21','meeting_date_qtr_end_q21','chapter_v_art_q22',
        'chapter_v_art_qtr_end_q22','surrogacy_chapter_vii_q22','surrogacy_chapter_qtr_end_vii_q22','created_at'       
    ];  
    public static function sumColumns(): array
    {
        return [
            'art_clinic_q1','art_clinic_qtr_end_q1',
        'art_banks_q1','art_banks_qtr_end_q1','surrogacy_clinic_q1','surrogacy_clinic_qtr_end_q1','art_clinic_q2','art_clinic_qtr_end_q2','art_banks_q2','art_banks_qtr_end_q2','surrogacy_clinic_q2',
        'surrogacy_clinic_qtr_end_q2','art_clinic_q3','art_clinic_qtr_end_q3','art_banks_q3','art_banks_qtr_end_q3','surrogacy_clinic_q3','surrogacy_clinic_qtr_end_q3','art_clinic_q4',
        'art_clinic_qtr_end_q4','art_banks_q4','art_banks_qtr_end_q4','surrogacy_clinic_q4','surrogacy_clinic_qtr_end_q4','art_clinic_q5','art_clinic_qtr_end_q5','art_banks_q5','art_banks_qtr_end_q5','surrogacy_clinic_q5',
        'surrogacy_clinic_qtr_end_q5','art_clinic_q6','art_clinic_qtr_end_q6','art_banks_q6','art_banks_qtr_end_q6','surrogacy_clinic_q6','surrogacy_clinic_qtr_end_q6','art_clinic_q7','art_clinic_qtr_end_q7','art_banks_q7',
        'art_banks_qtr_end_q7','surrogacy_clinic_q7','surrogacy_clinic_qtr_end_q7','art_clinic_q8','art_clinic_qtr_end_q8','art_banks_q8','art_banks_qtr_end_q8','surrogacy_clinic_q8','surrogacy_clinic_qtr_end_q8',
        'art_clinic_q9','art_clinic_qtr_end_q9','art_banks_q9','art_banks_qtr_end_q9','surrogacy_clinic_q9','surrogacy_clinic_qtr_end_q9','art_clinic_q10','art_clinic_qtr_end_q10','art_banks_q10','art_banks_qtr_end_q10',
        'surrogacy_clinic_q10','surrogacy_clinic_qtr_end_q10','art_clinic_q11','art_clinic_qtr_end_q11','art_banks_q11','art_banks_qtr_end_q11','surrogacy_clinic_q11','surrogacy_clinic_qtr_end_q11','art_clinic_q12',
        'art_clinic_qtr_end_q12','art_banks_q12','art_banks_qtr_end_q12','surrogacy_clinic_q12','surrogacy_clinic_qtr_end_q12','art_clinic_q13','art_clinic_qtr_end_q13','art_banks_q13','art_banks_qtr_end_q13',
        'surrogacy_clinic_q13','surrogacy_clinic_qtr_end_q13','appeal_rej_app_a_q14','appeal_rej_app_qtr_end_a_q14','appeals_disposed_b_q14','appeals_disposed_qtr_end_b_q14','forwarded_dhr_i_q15','forwarded_dhr_qtr_end_i_q15',
        'received_stakeholders_ii_q15','received_stakeholders_qtr_end_ii_q15','suo_moto_cognizancеr_iii_q15','suo_moto_cognizancеr_qtr_end_iii_q15','action_taken_a_q16','action_taken_qtr_end_a_q16','art_clinics_b_q16',
        'art_clinics_qtr_end_b_q16','art_banks_b_q16','art_banks_qtr_end_b_q16','surrogacy_clinics_b_q16','surrogacy_clinics_qtr_end_b_q16','appeal_received_a_q17','appeal_received_qtr_end_a_q17','appeals_disposed_b_q17',
        'appeals_disposed_qtr_end_b_q17','complaints_filed_q18','complaints_filed_qtr_end_q18','applications_received_i_a_q19','applications_received_qtr_end_i_a_q19','applications_received_ii_a_q19',
        'applications_received_qtr_end_ii_a_q19','applications_received_iii_a_q19','applications_received_qtr_end_iii_a_q19','applications_received_iv_a_q19','applications_received_qtr_end_iv_a_q19','applications_granted_i_b_q19',
        'applications_granted_qtr_end_i_b_q19','applications_granted_ii_b_q19','applications_granted_qtr_end_ii_b_q19','applications_granted_iii_b_q19','applications_granted_qtr_end_iii_b_q19',
        'applications_granted_iv_b_q19','applications_granted_qtr_end_iv_b_q19','applications_rejected_i_c_q19','applications_rejected_qtr_end_i_c_q19','applications_rejected_ii_c_q19',
        'applications_rejected_qtr_end_ii_c_q19','applications_rejected_iii_c_q19','applications_rejected_qtr_end_iii_c_q19','applications_rejected_iv_c_q19','applications_rejected_qtr_end_iv_c_q19',
        'appeals_against_rejection_a_q20','appeals_against_rejection_qtr_end_a_q20','appeals_disposed_b_q20','appeals_disposed_qtr_end_b_q20','meeting_date_q21','meeting_date_qtr_end_q21','chapter_v_art_q22',
        'chapter_v_art_qtr_end_q22','surrogacy_chapter_vii_q22'
        ];
    }
}
