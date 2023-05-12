<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    function __construct(UserService $userService)
    {

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->userService = $userService;

    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {
            $list = $this->userService->getAll(25, 'id', $order);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.users.index')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando Usuário";
        } else {
            $result['entry'] = $this->userService->getById($id);
            $result['title'] = "Editando Usuário: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->userService->getFields()['fields'];
            $result['action'] = "/admin/user/" . $result['entry']->id;
            $result['model'] = "admin.users";
            $result['js'] = "dashboard/users.js";

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return view('helpers.form-builder')
            ->with(['form' => $result]);
    }

    public function updateEntry(Request $request)
    {
        $id = $request->id;
        $data = $request->except([
            '_token',
            'roles'
        ]);
        $roles = $request->roles ?? [];

        try {
            $data['id'] = $id;
            $this->userService->saveUserData($data, $roles);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.users.index');
    }

    public function deleteEntry(Request $request)
    {

        try {
            $this->userService->delete($request->id);

            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.users.index');
    }

}