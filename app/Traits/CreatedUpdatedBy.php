<?php

namespace App\Traits;
use App\Models\User;

trait CreatedUpdatedBy {
    public static function bootCreatedUpdatedBy(){
        static::creating(function($model){
            if(auth()->check()){
                $model->created_by = auth()->id();
            }
        });

        static::updating(function($model){
            if(auth()->check() && $model->isClean('remember_token')){
                $model->updated_by = auth()->id();
            }
        });
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
