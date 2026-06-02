<?php

namespace App\Http\Services;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\VaccineRepository;

interface BaseService
{
public function getAll();

public function getById($id);

public function create($data);

public function update($id,$data);
public function delete($id);

public function indexQuery(array $params);
}
