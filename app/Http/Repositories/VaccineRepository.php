<?php

namespace App\Http\Repositories;

Use App\Models\Vaccine;
use App\Http\Services\VaccinesService;
class VaccineRepository extends BaseRepository implements VaccinesService
{
    public function __construct(Vaccine $model)
    {
        parent::__construct($model);
    }
}
