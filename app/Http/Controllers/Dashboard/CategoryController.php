<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Role;
use App\Category;

use Image;
use Storage;

class CategoryController extends Controller
{

/*****************************************************************************/  
    public function index(Request $request)
    {
        $categories = Category::where( function($q)use($request) {
            return $q->when($request->search, function($query)use($request) {
                $query->whereTranslationLike('title','%'.$request->search.'%');
            });
        })->get();
       return view('dashboard.categories.index',['categories'=>$categories]);
    }
/*****************************************************************************/
    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'ar.title'=>'required|max:50|min:2|unique:category_translations,title',
            'en.title'=>'required|max:50|min:2|unique:category_translations,title',
            'ar.desc'=>'nullable|min:2|max:100',
            'en.desc'=>'nullable|min:2|max:100',
            'image'=>'image'
        ];
    
        $this->validate($request, $rules);
        
        $data = $request->except('image');

        $category = Category::create($data);

        if($request->image) {
            /*** Create The Folder If Not Exists */
            $path="uploads/dashboard/categories/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $category->image = $request->image->hashName();
            $category->save();
        }

        return redirect(route('dashboard.categories.index'))->with('msg_ok',trans('messages.create_category'));;
    }
/*****************************************************************************/
/*    public function show(Category $category)
    {
        return view('dashboard.categories.show');
    }
/*****************************************************************************/
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',['category'=>$category]);
    }

    public function update(Request $request, Category $category)
    {  
        $rules = [
            'ar.title'=>['required','max:50','min:2',Rule::unique('category_translations','title')->ignore($category->id,'category_id')],
            'en.title'=>['required','max:50','min:2',Rule::unique('category_translations','title')->ignore($category->id,'category_id')],
            'ar.desc'=>'nullable|min:2|max:100',
            'en.desc'=>'nullable|min:2|max:100',
            'image'=>'image'
        ];
    
        $this->validate($request, $rules);
        
        $data = $request->except('image');

        $category->update($data);

        if($request->image) {
            if($category->image != 'no_img.png'){
                Storage::disk('uploads')->delete('/dashboard/categories/images/'.$category->image);
            }
            /*** Create The Folder If Not Exists */
            $path="uploads/dashboard/categories/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $category->image = $request->image->hashName();
            $category->save();
        }

        return redirect(route('dashboard.categories.index'))->with('msg_ok',trans('messages.update_category'));;
    }
/*****************************************************************************/
    public function destroy(Category $category)
    {
        // $books = \App\Book::all();
        // foreach($books as $book) {
        //     if($book->category_id == $category->id) {
        //         return redirect(route('dashboard.categories.index'))->with('msg_danger','You Can\'t Delete This Category. It Has Some Books ...!');;
        //     }
        // }
        if($category->image != 'no_img.png'){
            Storage::disk('uploads')->delete('/dashboard/categories/images/'.$category->image);
        }
        
        $category->deleteTranslations();
        $category->delete();
       
        return redirect(route('dashboard.categories.index'))->with('msg_danger',trans('messages.delete_category'));
    }
}
