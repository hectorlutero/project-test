<?php

namespace App\Http\Controllers\Admin;


use App\Services\RoleService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RolesController extends Controller
{
    protected RoleService $roleService;
    function __construct(RoleService $roleService)
    {

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->roleService = $roleService;

    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {
            $list = $this->roleService->getAll(25, 'id', $order);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.configs.roles.index')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando Perfil de Acesso";
        } else {
            $result['entry'] = $this->roleService->getById($id);
            $result['title'] = "Editando Perfil de Acesso: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->roleService->getFields()['fields'];
            $result['action'] = "/admin/role/" . $result['entry']->id;
            $result['model'] = "admin.roles";

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
            'permissions'
        ]);
        $permissions = $request->permissions ?? [];

        try {
            $data['id'] = $id;
            $this->roleService->saveRoleData($data, $permissions);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            dd($e);
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.roles.index');
    }

    public function deleteEntry(Request $request)
    {

        try {
            $this->roleService->delete($request->id);

            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.roles.index');
    }

}