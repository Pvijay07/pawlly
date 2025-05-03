<?php

namespace Modules\Earning\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class EmployeeEarning extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'description', 'total_amount', 'payment_date', 'payment_type', 'commission_amount', 'tip_amount'];

    protected static function newFactory()
    {
        return \Modules\Earning\Database\factories\EmployeeEarningFactory::new();
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id')->with('branch');
    }
}
