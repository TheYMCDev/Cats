<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'vaccine_name',
        'vaccine_description',
    ];

    public function Cats(){
        return $this->belongstoMany(Cat::class,'vaccines_cats','vaccine_id','cat_id');
    }
}
