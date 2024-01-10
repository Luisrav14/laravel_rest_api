<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(['status' => 'success', 'data' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
        ]);

        try {

            $product = new Product();
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->category = $request->input('category');
            $product->description = $request->input('decription');
            $product->image = $request->input('image');

            $product->save();
            return response()->json(['status' => 'success', 'message' => 'Product created.']);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Error to create.'], 500);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
        ]);

        try {
            $product->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'category' => $request->input('category'),
                'description' => $request->input('description'),
                'image' => $request->input('image'),
            ]);


            return response()->json(['status' => 'success', 'message' => 'Product updated.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error on update.'], 500);
        }
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy($id): JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            $product->delete();

            return response()->json(['status' => 'success', 'message' => 'Product deleted.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error on delete.'], 500);
        }
    }
}
