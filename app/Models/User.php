<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'type',
        'name',
        'number',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'profile_picture',
        'premium',
        'premium_type',
        'premium_expired_days',
        'remember_token',
        'status',
        'registered',
        'birthday',
        'deleted',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->status = $model->updateStatus($model);
            $model->premium_expired_days = $model->updatePremiumExpiredDays($model);
            $model->premium_type = $model->updatePremiumType($model);
            $model->premium = $model->updatePremium($model);
        });
    }

    public function updateStatus($entity)
    {
        if(!empty($entity->deleted)){
            return 'deleted';
        }

        if(!empty($entity->registered)){
            return 'registered';
        }

        return 'pending';
    }

    public function updatePremiumExpiredDays($entity)
    {
        return 365;
    }

    public function updatePremiumType($entity)
    {
        if($entity->premium_expired_days > 31){
            return 'yearly';
        }

        if($entity->premium_expired_days >= 1 && $entity->premium_expired_days <= 31){
            return 'monthly';
        }

        return 'not_aplicable';
    }

    public function updatePremium($entity)
    {
        if($entity->premium_expired_days > 0){
            return 1;
        }

        return 0;
    }
}
