<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCat extends Model
{
    use HasFactory;

    protected $table = 'vaccines_cats';
    protected $fillable = [
        'vaccine_id',
        'cat_id',
    ];

    public function Vaccine(){
        return $this->hasOne(Vaccine::class , 'vaccine_id', 'id');
    }

    public function Cat(){
        return $this->hasOne(Cat::class , 'cat_id', 'id');
    }
}
