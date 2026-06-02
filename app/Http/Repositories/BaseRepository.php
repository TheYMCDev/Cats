<?php

namespace App\Http\Repositories;
use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class BaseRepository implements BaseService
{
    protected $model;
    public function __construct(Model $model){
        $this->model = $model;
    }
    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        $instance=$this->model->find($id);
        if(!$instance)
            return null;
        return $instance;
    }

    public function create($data)
    {
        $storeModel = new $this->model;
        $storeModel->fill($data);
        $storeModel->save();
        return $storeModel;

    }

    public function update($id, $data)
    {
        $storeModel = $this->getById($id);
        if(!$storeModel)
            return null;
        $storeModel->fill($data);
        $storeModel->save();
        return $storeModel;
    }

    public function delete($id)
    {
        $storeModel = $this->getById($id);
        if(!$storeModel)
            return null;
        $storeModel->delete();
        return $storeModel;
    }
    public function getByIdRelationships($id, array $relationships)
    {
        return $this->model::with($relationships)->findOrFail($id);
    }
    public function indexQuery(array $params)
    {
        $joins = $params['relationships'];
        $select = $params['select'] ?? '*';
        $groupBy = $params['groupBy'] ?? null;
        $search = $params['search'] ?? null;
        $conditions = $params['conditions'] ?? null;
        $query = $this->model::query()->select($select);

        foreach($joins as $key => $join){
            switch($key){
                case 'innerjoin':
                    $query->join($join[0], $join[1], $join[2]);
                    break;
                case 'leftjoin':
                    $query->leftJoin($join[0], $join[1], $join[2]);
                    break;
                default:
                    break;
            }
        }

        if(!empty($conditions)){
            foreach($conditions as $column => $condition){
                if(!is_array($condition)){
                    if ($condition !== null) {
                        $query->where($column, $condition);
                    }
                } else {
                    $operator=$condition[0];
                    switch ($operator) {
                        case 'LIKE':
                        case '=':
                        case '!=':
                        case '>':
                        case '>=':
                        case '<':
                        case '<=':
                            if (isset($condition[1]) && $condition[1] !== null) {
                                $query->where($column, $operator, $condition[1]);
                            }
                            break;

                        case 'in':
                            if(isset($condition[1]) && !empty($condition[1])){
                                $query->whereIn($column, $condition[1]);
                            }
                            break;

                        case 'not in':
                            if(isset($condition[1]) && !empty($condition[1])){
                                $query->whereNotIn($column, $condition[1]);
                            }
                            break;

                        case 'null':
                            $query->whereNull($column);
                            break;

                        case 'not null':
                            $query->whereNotNull($column);
                            break;

                        default:
                            break;
                    }
                }
            }
        }

        if($groupBy){
            $query->groupBy($groupBy);
        }
        if(method_exists($this->model, 'scopeSearch')&&$search){
            $query->search($search);

        }


        return $query->get();


    }
}
