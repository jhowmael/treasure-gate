<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos (mass-assigned)
    protected $fillable = [
        'user_id',
        'external_reference',
        'payer_email',
        'payer_number',
        'total_value',
        'status',
        'created_at',
        'updated_at',
    ];
}
