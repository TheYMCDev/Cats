<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\CatRepository;
use App\Http\Services\BaseService;
use App\Http\Services\CatService;
use App\Http\Services\UserService;
use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends BaseController
{
    protected $baseRepositoryCat;

    public function __construct(BaseService $service)
    {
        parent::__construct($service);
    }

    public function all(Request $request){
        //$cats = Cat::with('user','vaccines')->get();
        $search = $request->search ?? null;
        $conditions = $request->conditions ?? null;
        $age = $request->age ?? null;
        $orderBy = $request->orderBy ?? 'cats.id';
        $orderType = $request->orderType ?? 'ASC';

        /* $cats = Cat::query()
            ->join('users', 'cats.user_id', '=', 'users.id')
            ->select('cats.id','cats.name as Nombre Gatito','users.name as Dueño','cats.gender as Genero','cats.age as Edad')
            ->when($age,function($query,$age){
                $query->where('cats.age',$age);
        })
            ->search($search)
            ->orderBy($orderBy,$orderType)
            ->get();
       /* for($i=0; $i<count($cats); $i++){
            $cats[$i]->user;
        }
        */
        $cats=$this->baseRepositoryCat->indexQuery([
           'relationships'=>[
               'leftjoin'=>['users','cats.user_id','users.id'],
           ],
           'select'=>['cats.id','cats.name as NombreGatito','users.name as Dueño','cats.gender as Genero','cats.age as Edad'],
           'groupBy'=>['cats.id','cats.name'],
           'orderBy'=>['cats.name' => 'DESC'],
           'conditions'=>$conditions,
           'search'=>$search,

        ]);

        return response()->json($cats);
    }

    public function show(Request $request, $id){
        $cat = $this->baseRepositoryCat->getByIdRelationships($id,['user']);
        if(!$cat){
            return response()->json('Cat not found', 404);
        }
        return response()->json($cat);
    }
    public function store(Request $request){
        //$params = $request->all();
        //$cat = new Cat();
        $cat = $this->baseRepositoryCat->create($request->all());

        //$cat->fill($params);
        //$cat->save();
        return response()->json($cat);
    }
    public function update(Request $request, $id){
        //$params = $request->all();
        //$cat = Cat::find($id);
        $cat = $this->baseRepositoryCat->update($id, $request->all());
        if(!$cat){
            return response()->json('Cat not found', 404);
        }
       // $cat->fill($params);
       // $cat->save();
        return response()->json($cat);
    }
    public function destroy(Request $request, $id){
        $cat = $this->baseRepositoryCat->delete($id);
        if(!$cat){
            return response()->json('Cat not found', 404);
        }
        $cat->delete();
        return response()->json('Cat deleted successfully',200);
    }
}
