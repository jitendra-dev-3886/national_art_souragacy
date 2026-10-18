<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ArchiveTable extends Model
{
    use HasFactory;
    public $table= 'archive_table';

    protected $fillable =[
            'application_no', 
            'archive_id',     
            'userid',         
            'clinicname',     
            'address',        
            'pincode',        
            'state',          
            'district',       
            'email',          
            'mobile',         
            'action_taken_by',
            'action_taken_id',
            'type_of_clinic', 
            'archive_id',     
            'archive_status', 

    ];

    public function work_flowData()
    { 
        return $this->belongsTo(WorkFlowTable::class, 'archive_id','application_id');
    }
}