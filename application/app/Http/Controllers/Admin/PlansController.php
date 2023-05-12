<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlansController extends Controller
{
    protected PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->middleware('permission:plan-list|plan-create|plan-edit|plan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
        $this->planService = $planService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {
            $list = $this->planService->getAll(25, 'id', $order);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.configs.plans.index')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando Plano";
        } else {
            $result['entry'] = $this->planService->getById($id);
            $result['title'] = "Editando Plano: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->planService->getFields()['fields'];
            $result['action'] = "/admin/plans/" . $result['entry']->id;
            $result['model'] = "admin.plans";

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
        ]);

        try {
            $data['id'] = $id;
            $this->planService->savePlanData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            dd($e);
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }
        return redirect()->route('admin.plans.index');
    }


    public function deleteEntry(Request $request)
    {
        try {
            $this->planService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.plans.index');
    }
}