<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Fractal\Facades\Fractal;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data,$code);
    }
    protected function errorResponse($message, $code)
    {
        return response()->json(['error'=>$message, 'code'=>$code],$code);
    }

    protected function showAll(Collection $collection, $code=200)
    {
        if($collection->isEmpty()){
            return $this->successResponse($collection,$code);

        }
        $transformer = $collection->first()->transformer;
        $collection = $this->transformData($collection,$transformer);
        return $this->successResponse($collection,$code);
    }
    protected function showOne(Model $instance, $code=200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance,$transformer);

        return $this->successResponse($instance,$code);
    }

    protected function transformData($data, $transformer)
    {
        $data= fractal($data, new $transformer)->toArray();;
        return $data;
    }
}