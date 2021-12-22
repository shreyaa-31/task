<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\ProductRequest;
use Validator;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends BaseController
{

    public function store(ProductRequest $request)
    {

        $input = $request->all();
        
        $product = Product::create($input);

        return $this->sendResponse($product, 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if (is_null($product)) {
            return $this->sendResponse([],'Product not found.');
        }

        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    public function update(ProductRequest $request)
    {
        $product = Product::find($request->id);

       
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->price = $request->price;
        $product->save();


        return $this->sendResponse($product, 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendResponse('Product not found.');
        }

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }

    public function index(Request $request)
    {


        if (isset($request->name) || ((isset($request->start_price) && isset($request->end_price)))) {

            if (!empty($request->name) && !empty($request->start_price) && !empty($request->end_price)) {

                if ((int)$request->start_price < (int)$request->end_price) {

                    $products = Product::whereBetween('price', [(int)$request->start_price, (int)$request->end_price])->where('name', 'like', '%' . $request->name . '%')->get()->toArray();

                    if (empty($products)) {

                        return $this->sendResponse('Products not found.');
                    }
                    return $this->sendResponse($products, 'Products retrieved successfully.');
                } else {
                    return $this->sendResponse([],'Enter Appropriate range',422);
                }
            } elseif (!empty($request->start_price) && !empty($request->end_price)) {

                if ((int)$request->start_price < (int)$request->end_price) {
                    
                    $products = Product::whereBetween('price', [(int)$request->start_price, (int)$request->end_price])->get()->toArray();

                    if (empty($products)) {

                        return $this->sendResponse('Products not found.');
                    }

                    return $this->sendResponse($products, 'Products retrieved successfully.');

                } else {
                    return $this->sendResponse([],'Enter Appropriate range',422);
                }
            } elseif (!empty($request->name)) {

                $products = Product::where('name', 'like', '%' . $request->name . '%')->get()->toArray();

                if (empty($products)) {

                    return $this->sendResponse('Products not found.');
                }
                return $this->sendResponse($products, 'Products retrieved successfully.');
            }
        } else {

            $products = Product::all();

            if (empty($products)) {

                return $this->sendResponse('Products not found.');
            }

            return $this->sendResponse($products, 'Products retrieved successfully.');
        }
    }
}
