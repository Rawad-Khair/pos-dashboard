<?php

namespace App\Http\Controllers\dashboard;
use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use Storage;

class UserController extends Controller
{
    public function __construct() {
        $this -> middleware('permission:create_users') -> only(['create','store']);
        $this -> middleware('permission:read_users') -> only('index');
        $this -> middleware('permission:update_users') -> only(['edit','update','block']);
        $this -> middleware('permission:delete_users') -> only('destroy');
    }
/*****************************************************************************/
    public function index(Request $request)
    {
        $paginate = 10;
        $roles = Role::all();
        /*/***** The Boss Searching ***/
        if(auth()->user()->hasRole('boss')) {
            
            if($request->search_for =='admins') {   //Searching for only Admins
                $users = User::whereRoleIs('admin') -> where(function($query) use($request) {
                    return $query -> when($request->search, function($query_2) use($request) {
                        return $query_2 -> where('first_name', 'like', '%'.$request->search.'%')
                                -> orWhere('last_name', 'like', '%'.$request->search.'%');
                    });
                })->paginate($paginate);    
            } elseif ($request->search_for =='users') {   //Searching for only Users
                $users = User::whereRoleIs('normal') -> where(function($query) use($request) {
                    return $query -> when($request->search, function($query_2) use($request) {
                        return $query_2 -> where('first_name', 'like', '%'.$request->search.'%')
                                -> orWhere('last_name', 'like', '%'.$request->search.'%');
                    });
                })->paginate($paginate);
            } else {    //Searching for all (admins + users)
                $users = User::where(function($query) use($request) {
                    return $query -> when($request->search, function($query_2) use($request) {
                        return $query_2 -> where('first_name', 'like', '%'.$request->search.'%')
                                -> orWhere('last_name', 'like', '%'.$request->search.'%');
                    });
                })->paginate($paginate);
            }
                   
            return view('dashboard.users.index',['users'=> $users, 'roles'=>$roles]);
        } // end the Boss setion

        /*/***** The Admin Searching ***/
        elseif (auth()->user()->hasRole('admin')) {
            $users = User::whereRoleIs('normal') -> where(function($query) use($request) {
                return $query -> when($request->search, function($query_2) use($request) {
                    return $query_2 -> where('first_name', 'like', '%'.$request->search.'%')
                            -> orWhere('last_name', 'like', '%'.$request->search.'%');
                });
            })->paginate($paginate);
            return view('dashboard.users.index',['users'=> $users, 'roles'=>$roles]);
        } // end the admin section
            
        // --------------There is the second way, but it is more difficult------------
        //     $terms = explode(' ', $request->search);
        //     $columns = ['first_name', 'last_name'];
        // // Start with an initial null query.
        // // I'm pretty sure Laravel expects a where before an orWhere,
        // // so this is an alright way to make that check.
        //     $query = null;
        // // For each of the search terms
        //     foreach ($terms as $term) {
        //         // For each column
        //         foreach ($columns as $column) {
        // // If we have not yet started a query, 
        // //start one now by applying a where to the User model. 
        // //If we have started a query i.e. $query is not null, then use an orWhere
        //             if (is_null($query)) {
        //                 $query = User::where($column, 'LIKE', '%' . $term . '%');
        //             } else {
        //                 $query->orWhere($column, 'LIKE', '%' . $term . '%');
        //             }
        //         }
        //     }
            
        //     $users = $query->whereRoleIs('normal')->paginate(3);

        /*/***** The Normal User Searching ***/
        else {
            $users = User::where('id','=',auth()->user()->id)->paginate(3);
            return view('dashboard.users.index',['users'=> $users, 'roles'=>$roles]);
        }
       
}

/*****************************************************************************/
    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'permissions.required' => trans('messages.role_at_least')
        ];
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'permissions' => 'required|array'
        ],$messages);

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        
        $user -> roles() -> attach(\App\Role::where('name','normal')->first());
    
        if($request->image) {
            /*** Create The Folder If Not Exists */
            $path="uploads/users/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->fit(200, 200, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $user->image = $request->image->hashName();
            $user->save();
        }

        if($request->permissions) {
            $user -> syncPermissions($request->permissions);
        } else {
            return redirect()->back()->with('msg_danger',trans('messages.role_at_least'));
        }

        return redirect(route('dashboard.users.index'))->with('msg_ok',trans('messages.create_user'));
       
    }

/*****************************************************************************/
    public function show(User $user)
    {
        

    }

/*****************************************************************************/
    public function edit(User $user)
    {
        return view('dashboard.users.edit')->with('user', $user);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user -> first_name = $request['first_name'];
        $user -> last_name = $request['last_name'];
        $user -> email = $request['email'];
        
        if($request->image) {
            /* Delete the old image ****/
            if($user->image != 'no_img.png'){
                Storage::disk('uploads')->delete('/users/images/'.$user->image);
            }
            /* Create the folder if isn't exist***/
            $path="uploads/users/images/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            /*** Using Laravel Intervention Package To Resize And Save Images */
            $img = Image::make($request->image);
            $img->fit(200, 200, function($constraint){
                $constraint-> aspectRatio(); //Aspect Ratio
            })->save($path.$request->image->hashName());
            /*** Save Image Name To Database */
            $user->image = $request->image->hashName();
        }

        $user->save();
           
        if($request->permissions) {
            $user -> syncPermissions($request->permissions);
        } else {
            return redirect()->back()->with('msg_danger',trans('messages.role_at_least'));
        }
      
       
        return redirect(route('dashboard.users.index'))->with('msg_ok',trans('messages.update_user'));

    }

/*****************************************************************************/
    public function destroy(User $user)
    {
        if($user->image != 'no_img.png'){
            Storage::disk('uploads')->delete('/users/images/'.$user->image);
        }
       $user->delete();
       return redirect(route('dashboard.users.index'))->with('msg_danger',trans('messages.delete_user'));
    }

/*****************************************************************************/
    public function change_roles(Request $request, User $user)
    {
        $newRole = $request->roles;
        $roles = Role::all();
        foreach($roles as $role) {
            if($newRole == $role->id) {
                $user->roles()->detach();
                $user->roles()->attach($role->id);
                return redirect()->back()->with('msg_ok',trans('messages.change_role'));
            }
        }
       
    }
/*****************************************************************************/
    public function block(Request $request, User $user)
    {

        if($user->is_blocked) {
            $user->is_blocked = false;
            $user->save();
            return redirect()->back()->with('msg_ok',trans('messages.unblock'));    
        } else {
            $user->is_blocked = true;
            $user->save();
            return redirect()->back()->with('msg_danger',trans('messages.block'));    
        }
       
    }
}
