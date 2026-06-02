<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'weight',
        'gender',
        'race',
        'image',
        'user_id',
    ];

    public function User(){
        return $this->hasOne(User::class ,'id' , 'user_id');
    }
    public function scopeSearch($query,$search){
        if($search){
            $query->where(function($query) use ($search){
                $query->where('users.name','like','%'.$search.'%')
                    ->orWhere('cats.name','like','%'.$search.'%');
            });
            return $query;
        }
    }
    public function Vaccines(){
        return $this->belongsToMany(Vaccine::class,'vaccines_cats','cat_id','vaccine_id');
    }

}
