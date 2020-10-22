<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\ProductResource;
use App\Media;
use App\Merchant;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|integer',
            'category_id' => 'required|integer',
            'name' => 'required',
            'model' => 'required',
            'description' => 'required',
            'price' => 'required',
            'is_new' => 'required|boolean',
            'media_1' => 'required|mimes:jpeg,jpg,png,gif,mp4,3gp,mkv|max:10240',
            'media_2' => 'required|mimes:jpeg,jpg,png,gif,mp4,3pg,mkv|max:10240',
            'media_3' => 'required|mimes:jpeg,jpg,png,gif,mp4,3gp,mkv|max:10240',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $media_array = [
            'media_1' => $request->file('media_1'),
            'media_2' => $request->file('media_2'),
            'media_3' => $request->file('media_3'),
        ];

        $data = $request->only(['merchant_id', 'category_id', 'name', 'model', 'description', 'specification', 'other_details', 'price', 'is_new', 'is_negotiable']);
        if ($this->MerchantAndCategoryExists($request->merchant_id, $request->category_id)){
            $product = Product::create($data);

            foreach ($media_array as $file){
                $file_name = sha1($file->getClientOriginalName().now()).".".$file->getClientOriginalExtension();
                $destinationPath = public_path('/products/'.$this->getMediaType($file->getClientOriginalExtension()));
                $file->move($destinationPath, $file_name);
                $product->media()->create([
                    "type" => $this->getMediaType($file->getClientOriginalExtension()),
                    "path" => $file_name,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Product stored'], 200);
        }
        return response()->json(['success' => false, 'errors' => 'Model not found'], 404);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'name' => 'required',
            'model' => 'required',
            'description' => 'required',
            'price' => 'required',
            'is_new' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        if (!$this->ProductBelongsToMerchant(auth()->user()->merchant()->first()->id, $product->id)){
            return response()->json(['success' => false, 'errors' => 'Model doesn\'t belong to user'], 401);
        }

        $data = $request->only(['category_id', 'name', 'model', 'description', 'specification', 'other_details', 'price', 'is_new', 'is_negotiable']);
        $product->update($data);

        return response()->json(['success' => true, 'message' => 'Product updated'], 200);
    }

    public function updateMedia(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'media_id' => 'required',
            'media' => 'required|mimes:jpeg,jpg,png,gif,mp4,3gp,mkv|max:10240',
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        if (!$this->ProductBelongsToMerchant(auth()->user()->merchant()->first()->id, $product->id) || !$this->MediaBelongsToProduct($request->media_id, $product->id)){
            return response()->json(['success' => false, 'errors' => 'Model doesn\'t belong to user'], 401);
        }
        $file = $request->file('media');
        $file_name = sha1($file->getClientOriginalName().now()).".".$file->getClientOriginalExtension();
        $destinationPath = public_path('/products/'.$this->getMediaType($file->getClientOriginalExtension()));
        $file->move($destinationPath, $file_name);
        $media = Media::find($request->media_id);
        unlink('products/'.$media->type.'/'.$media->path);
        $media->update([
            "type" => $this->getMediaType($file->getClientOriginalExtension()),
            "path" => $file_name,
        ]);
    }

    public function destroy(Product $product)
    {
        if (!$this->ProductBelongsToMerchant(auth()->user()->merchant()->first()->id, $product->id)){
            return response()->json(['success' => false, 'errors' => 'Model doesn\'t belong to user'], 401);
        }
        $product->delete();
        foreach ($product->media()->get() as $file){
            unlink('products/'.$file->type.'/'.$file->path);
        }
        $product->media()->delete();
        return response()->json(['success' => true, 'message' => 'Product deleted'], 401);
    }

    protected function MerchantAndCategoryExists($merchant, $category)
    {
        if (Merchant::find($merchant) && Category::find($category))
        {
            return true;
        }
        return false;
    }

    protected function ProductBelongsToMerchant($merchant, $product)
    {
        if (Product::where('id', $product)->where('merchant_id', $merchant)->first())
        {
            return true;
        }
        return false;
    }

    protected function getMediaType($extension){
        if ($extension == "png" || $extension == "jpeg" || $extension == "jpg" || $extension == "gif"){
            return "Image";
        }
        return "Video";
    }

    protected function MediaBelongsToProduct($media, $product)
    {
        if (Media::where('id', $media)->where('product_id', $product)->first())
        {
            return true;
        }
        return false;
    }
}
