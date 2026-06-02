<?php

namespace App\Http\Repositories;

use App\Http\Services\CatService;
use App\Models\Cat;

class CatRepository extends BaseRepository implements CatService
{
    public function __construct(Cat $model)
    {
         parent::__construct($model);
    }

}
