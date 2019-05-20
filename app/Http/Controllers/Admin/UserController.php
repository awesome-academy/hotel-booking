<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(userRepository $userRepository, roleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['keyword'])) {
            $users = $this->userRepository->search('email', $_GET['keyword'], Config::get('pagination.default'));
        } else {
            $users = $this->userRepository->paginate(Config::get('pagination.default'));
        }
        $data = compact('users');

        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $roles = $this->roleRepository->all();
        $data = compact('roles');

        return view('admin.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $data['remember_token'] = md5(uniqid());
        $this->userRepository->create($data);
        $request->session()->flash('store');

        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('admin.users.edit', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        if (is_null($user)) {
            abort('404');
        }
        $roles = $this->roleRepository->all();
        $data = compact(
            'user',
            'roles'
        );

        return view('admin.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $this->userRepository->update($id, $data);
        $request->session()->flash('update');

        return redirect(route('admin.users.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $delete = $this->userRepository->delete($id);
        if ($delete == true) {
            $request->session()->flash('delete');
        } else {
            $request->session()->flash('delete-error');
        }

        return redirect(route('admin.users.index'));
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $user = $this->userRepository->find($data['id']);
        if (is_null($user)) {

            return response()->json(['errors' => 'user_not_found', 'messages' => __('messages.Validate_cant_found_user')], 200);
        }
        $rules = array(
            'old_password' => 'required',
            'password' => 'required|min:6|max:15|confirmed',
        );
        $messages = array(
            'old_password.required' => __('messages.Validate_required'),
            'password.required' => __('messages.Validate_required'),
            'password.min' => __('messages.Validate_min') . ' :min ' . __('messages.Validate_character'),
            'password.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'password.confirmed' => __('messages.Validate_password_confirm'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['messages' => 'errors', 'errors' => $validator->messages()], 200);
        }
        if (!Hash::check($data['old_password'], $user->password)) {

            return response()->json(['errors' => 'wrong_old_password', 'messages' => __('messages.Validate_wrong_old_password')], 200);
        } else {
            $this->userRepository->update($data['id'], $data);

            return response()->json(['messages' => 'success'], 200);
        }
    }
}
