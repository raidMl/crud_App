<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; //for  use storage
use Carbon\Carbon; //for classify dates

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::select("id","title","description","image")->get();
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
        $request->validate([ //for validation
'title'=>'required',
'description'=>'required',
'image'=>'required|image'
        ]);
         //for store in db
$imageName=Str::random().'.'. $request->image->getClientOriginalExtension(); //213123.png
Storage::disk('public')->putFileAs('product/image',$request->image,$imageName);// save in storage
Product::create($request->post()+['image'=>$imageName]);//insert image to db
return response()->json(
    ["message"=>"item added successfully"]
);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(
            [  "product"=>$product ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request,Product $product)
    // {
//         $request->validate([ //for validation
//             'title'=>'required',
//             'description'=>'required',
//             'image'=>'nullable'  // we can don't change image
//                     ]);

//             $product->fill($request->post())->update();
// if($request->hasFile("image")){
//     if ($product->image){
//         $exist=Strorage::dik("public")->exists("product/image".$product->image);// bool
//         if($exist){
//            Storage::disk("public")->delete ("product/image".$product->image);
//         }

//     }
// }
//                      //for store in db
//             $imageName=Str::random().'.'. $request->image->getClientOriginalExtension(); //213123.png
//             Strorage::dik("public")->putFileAs("product/image",$request->image,$imageName);// save in storage
//             $product->image=$imageName;
//             $product->save();
//             return response()->json(
//                 ["message"=>"item updated successfully"]
//             );    
//         }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "image" => "nullable"
        ]);

        $product->fill($request->post())->update();


        if ($request->hasFile('image')) {
            if ($product->image) {
                    $exist = Storage::disk('public')->exists("product/image/{$product->image}"  );
                    if ($exist) {
                    Storage::disk('public')->delete("product/image/{$product->image}");
                    }
            }

        $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('product/image', $request->image, $imageName);
        $product->image = $imageName;
        $product->save();

        }


        return response()->json([
            'message' => 'Item updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            $exist = Storage::disk('public')->exists("product/image/{$product->image}"); //bool
            if ($exist) {
                Storage::disk('public')->delete("product/image/{$product->image}");
            }
        }
        $product->delete();
        return response()->json([
            'message' => 'Item deleted successfully'
        ]);

    }
}
