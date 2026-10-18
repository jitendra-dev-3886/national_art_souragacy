<?php
namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicEquipmentModel extends Model
{
    use HasFactory;

    // If table name does not follow Laravel's naming convention
    protected $table = 'tbl_clinic_equipment';

    // If your primary key is not 'id', set it here
    protected $primaryKey = 'id';

    // If timestamps are used with different format or names, update this
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'clinic_id',
        'equipmentname',
        'status',
        'clinic_type',
        'application_no',
        'validitydate',
    ];

    // If any date columns need to be treated as Carbon instances
    protected $dates = [
        'created_at',
        'updated_at',
        'validitydate',
    ];
}
