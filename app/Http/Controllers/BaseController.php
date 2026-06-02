<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BaseService;


class BaseController
{
    protected $service;
    public function __construct(BaseService $service){
        $this->service = $service;
    }
    public function all (Request $request){
        $request = $request->all();
    }

    public function store(Request $request){
        try{
            $params = $request->all();
            $instance = $this->service->create($params);
            return response()->json($instance, 200);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
    public function show(Request $request, $id){
        $params = $request->show();
        $instance = $this->service->getById($params);
        return response()->json($instance, 200);
    }
    public function update(Request $request, $id){
        $params = $request->all();
        $instance = $this->service->update($id, $params);
        if(!$instance) {
           return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($instance, 200);
    }
    public function destroy(Request $id){
        $instance = $this->service->delete($id);
        if(!$instance) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json('Delete successfully', 200);
    }

}
