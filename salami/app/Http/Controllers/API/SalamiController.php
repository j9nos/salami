<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use App\Models\Product;

use Illuminate\Support\Facades\DB;

class SalamiController extends BaseController
{
    public function show_salamis()
    {
        $product = DB::table('product')
        ->join('ingredient', 'ingredient_id', '=', 'ingredient.id')
        ->select('name', 'price', 'type_of_meat', 'production_time')
        ->get();
        return $this->sendResponse($product, "Loaded");
    }

    public function show_salami($id)
    {
        $product = DB::table('product')
        ->join('ingredient', 'ingredient_id', '=', 'ingredient.id')
        ->select('name', 'price', 'type_of_meat', 'production_time')
        ->where('product.id','=',$id)
        ->get();
        return $this->sendResponse($product, "Specific salami loaded");
    }

    public function search_salami_by_name($name)
    {
        $product = DB::table('product')
        ->join('ingredient', 'ingredient_id', '=', 'ingredient.id')
        ->select('name', 'price', 'type_of_meat', 'production_time')
        ->where('name', 'LIKE', '%'. $name. '%')
        ->get();
        return $this->sendResponse($product, "searched by name");
    }

    public function search_salami_by_meat($meat)
    {
        $product = DB::table('product')
        ->join('ingredient', 'ingredient_id', '=', 'ingredient.id')
        ->select('name', 'price', 'type_of_meat', 'production_time')
        ->where('type_of_meat', 'LIKE', '%'. $meat. '%')
        ->get();
        return $this->sendResponse($product, "searched by meat");
    }


    /*
        =====================================
        | AUTHENTIKÁCIÓT IGÉNYLŐ FÜGGVÉNYEK |
        =====================================
    */


    public function add_new_salami(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input,
        [
            "name" => "required",
            "price" => "required",
            "ingredient_id" => "required",
            "production_time"=>"required"
        ]);

        if($validator->fails())
        {
            return $this->sendError($validator->errors());
        }

        $new_product = Product::create($input);
        return $this->sendResponse($new_product,"new product added");
    }

    public function edit_salami_data($id, Request $request)
    {
        $input = $request->all();
        $validator=Validator::make($input, [
            "name"=>"required",
            "price"=>"required",
            "ingredient_id"=>"required",
            "production_time"=>"required"
        ]);
        if($validator->fails())
        {
            return $this->sendError($validator->errors());
        }
        $product = Product::find($id);
        $product->update($input);
        return $this->sendResponse($product, "Modified");
    }

    public function throw_salami_out($id)
    {
        $product = Product::destroy($id);
        return $this->sendResponse($product,"Salami thrown out");
    }

}