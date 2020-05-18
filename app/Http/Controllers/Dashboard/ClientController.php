<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Role;
use Image;
use Storage;

use App\Client;

class ClientController extends Controller
{


/*****************************************************************************/  
    public function index(Request $request)
    {
        $clients = Client::where( function($q)use($request) {
            return $q->when($request->search, function($query)use($request) {
                $query->where('name','like','%'.$request->search.'%');
            });
        })->paginate(10);
       return view('dashboard.clients.index',['clients'=>$clients]);
    }
/*****************************************************************************/
    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|max:50|min:2|unique:clients,name',
            'phone'=>'required|min:1|array',
            'phone.*'=>'nullable|numeric',
            'phone.0'=>'required',
            'address'=>'nullable|min:2|max:100',
            'image'=>'nullable|image'
        ];
    
        $this->validate($request, $rules);
        
        $data = $request->except('image');
        $client = Client::create($data);

        if($request->image) {
            /*** Create The Folder If Not Exists */
            $path="uploads/dashboard/clients/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $client->image = $request->image->hashName();
            $client->save();
        }

        return redirect(route('dashboard.clients.index'))->with('msg_ok',trans('messages.create_client'));;
    }
/*****************************************************************************/
/*    public function show(client $client)
    {
        return view('dashboard.clients.show');
    }
/*****************************************************************************/
    public function edit(client $client)
    {
        return view('dashboard.clients.edit',['client'=>$client]);
    }

    public function update(Request $request, client $client)
    {  
        $rules = [
            'name'=>'required|max:50|min:2|unique:clients,name,'.$client->id,
            'phone'=>'required|min:1|array',
            'phone.*'=>'nullable|numeric',
            'phone.0'=>'required',
            'address'=>'nullable|min:2|max:100',
            'image'=>'nullable|image'
        ];
    
        $this->validate($request, $rules);
        
        $data = $request->except('image');
        $client->update($data);

        if($request->image) {
            if($client->image != 'no_img.png'){
                Storage::disk('uploads')->delete('/dashboard/clients/images/'.$client->image);
            }
            /*** Create The Folder If Not Exists */
            $path="uploads/dashboard/clients/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->resize(400, null, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $client->image = $request->image->hashName();
            $client->save();
        }

        return redirect(route('dashboard.clients.index'))->with('msg_ok',trans('messages.update_client'));;
    }
/*****************************************************************************/
    public function destroy(client $client)
    {
        if($client->image != 'no_img.png'){
            Storage::disk('uploads')->delete('/dashboard/clients/images/'.$client->image);
        }
        
        $client->delete();
       
        return redirect(route('dashboard.clients.index'))->with('msg_danger',trans('messages.delete_client'));;
    }
}

