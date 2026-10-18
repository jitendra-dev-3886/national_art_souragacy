<?php
namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SsaPwdUpload extends Model
{
    use HasFactory;
    protected $table = 'ssa_pwd_upload';
    protected $fillable = [
        'admin_id',
        'admin_ip',
        'file_partial_path',
        'remark',
        'state_id',
        'ssa_id',
    ];
}