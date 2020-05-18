<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Category;
use App\Product;
use Image;
use Storage;


class ProductController extends Controller
{
/*****************************************************************************/
    public function index(Request $request)
    {
        $paginate = 10;
        $categories = Category::all();
        if( count($categories) > 0) {

            // $approvedproducts = Product::where('isApproved',true)->latest()->get();
            
            if($request->category_id !='all') {
                $products = Product::where(function($q)use($request) {
                    $q->when($request->category_id, function($query)use($request) {
                        return $query->where('category_id',$request->category_id)
                        ->whereTranslationLike('title','%'.$request->search.'%');
                    });
                })->paginate(3);
            } else {
                $products = Product::where(function($q)use($request) {
                    $q->whereTranslationLike('title','%'.$request->search.'%');
                })->paginate(3);
            }

            return view('dashboard.products.index',['products'=> $products]);
           
        }
        else {
            return redirect(route('dashboard.categories.index'))->with('msg_danger',trans('messages.no_categories'));
        }  
    }
/*****************************************************************************/
    public function create()
    {
        $categories = Category::all();
        if( count($categories) > 0) {
            return view('dashboard.products.create');
        }
        else {
            return redirect(route('dashboard.categories.index'))->with('msg_danger',trans('messages.no_categories'));
        }  
    }

    public function store(Request $request)
    {
        $messages_ar = [
            'category_id.integer' => 'الرجاء ... اختيار قسم المنتج من القائمة ...!',
        ];
        $messages_en = [
            'category_id.integer' => 'Please ... Choose the category from the list ...!',
        ];
        $rules = [
            'category_id'=>'required|integer',
            'ar.title'=>['required','min:2',Rule::unique('product_translations','title')],
            'en.title'=>['required','min:2',Rule::unique('product_translations','title')],
            'ar.desc'=>'nullable|min:2|max:100',
            'en.desc'=>'nullable|min:2|max:100 ',
            'cost_price'=>'required|nullable|numeric',
            'sale_price'=>'required|nullable|numeric',
            'count'=>'required|nullable|numeric',
            'image'=>'nullable|image',
        ];

        if(app()->getlocale() == 'ar'){
            $this->validate($request, $rules, $messages_ar);
        }
        if(app()->getlocale() == 'en'){
            $this->validate($request, $rules, $messages_en);
        }

        $data = $request->except('image');
        $data += ['user_id' => auth()->user()->id];
        $product= Product::create($data);

        /***************************************/
        if($request->image) {
            /*** Create The Folder If Not Exists */
            $path="uploads/products/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint) {
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $product->image = $request->image->hashName();
            $product->save();
        }

        return redirect(route('dashboard.products.index'))->with('msg_ok',trans('messages.create_product'));
    }

/*****************************************************************************/
    // public function show(Product $Product)
    // {
    //     $comments = Comment::where('Product_id',$Product->id)->paginate(3);
    //     return view('dashboard.products.show',['Product'=>$Product,'comments'=>$comments]);
    // }

/*****************************************************************************/
    public function edit(Product $product)
    {
        $categories = Category::all();
        if( count($categories) > 0 ) {
            return view('dashboard.products.edit')->with(['product'=>$product]);
        }
        else {
            return redirect(route('dashboard.categories.index'));
        }
    }

    public function update(Request $request, Product $product)
    {
        $messages_ar = [
            'category_id.integer' => 'الرجاء ... اختيار قسم المنتج من القائمة ...!',
        ];
        $messages_en = [
            'category_id.integer' => 'Please ... Choose the category from the list ...!',
        ];
        $rules = [
            'category_id'=>'required|integer',
            'ar.title'=>['required','min:2',Rule::unique('product_translations','title')->ignore($product->id,'product_id')],
            'en.title'=>['required','min:2',Rule::unique('product_translations','title')->ignore($product->id,'product_id')],
            'ar.desc'=>'nullable|min:2|max:100',
            'en.desc'=>'nullable|min:2|max:100 ',
            'cost_price'=>'required|nullable|numeric',
            'sale_price'=>'required|nullable|numeric',
            'count'=>'required|nullable|numeric',
            'image'=>'nullable|image',
        ];

        if(app()->getlocale() == 'ar'){
            $this->validate($request, $rules, $messages_ar);
        }
        if(app()->getlocale() == 'en'){
            $this->validate($request, $rules, $messages_en);
        }

        $data = $request->except('image', 'remove_image');
        $product->update($data);

        /************/

        if($request->image) {
            if($product->image != 'no_img.png'){
                Storage::disk('uploads')->delete('/products/images/'.$product->image);
            }
            /*** Create The Folder If Not Exists */
            $path="uploads/products/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint) {
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $product->image = $request->image->hashName();
            $product->save();
        }

        if($request->remove_image == 'remove') {
            if($product->image != 'no_img.png'){
                Storage::disk('uploads')->delete('/products/images/'.$product->image);
            }
            $product->image = 'no_img.png';
            $product->save();
        }

        return redirect(route('dashboard.products.index'))->with('msg_ok',trans('messages.update_product'));
    }

/*****************************************************************************/
    public function destroy(Product $product)
    {
        if($product->image != 'no_img.png') {
            Storage::disk('uploads')->delete('/products/images/'.$product->image);
        }

        $product->deleteTranslations();
        $product->delete();
        return redirect(route('dashboard.products.index'))->with('msg_danger',trans('messages.delete_product'));
    }

/*****************************************************************************/
    public function approve(Product $product)
    {
        $product->is_approved = true;
        $product->save();
        return redirect(route('dashboard.products.index'))->with('msg_ok',trans('messages.approve_product'));
    }
/*****************************************************************************/
}
