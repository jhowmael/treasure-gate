<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos (mass-assigned)
    protected $fillable = [
        'user_id',
        'mercado_pago_payment_id',
        'external_reference',
        'payer_email',
        'payer_number',
        'total_value',
        'method',
        'type',
        'registered',
        'approved',
        'deined',
        'status',
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->status = $model->updateStatus($model);
            $user = User::find($model->user_id);
            $user->save();
   
        });
    }

    public function updateStatus($entity)
    {
        if(!empty($entity->approved)){
            return 'approved';
        }

        if(!empty($entity->deined)){
            return 'deined';
        }

        if(!empty($entity->registered)){
            return 'registered';
        }

        return 'pending';
    }
}
