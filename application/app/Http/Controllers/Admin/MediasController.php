<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class MediasController extends Controller
{
    protected MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        try {
            $list = $this->mediaService->getAll(25);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.medias')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando empresa";
        } else {
            $result['entry'] = $this->mediaService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->mediaService->getFields()['fields'];
            $result['action'] = "/admin/media/" . $result['entry']->id;
            $result['model'] = "admin.medias";

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
            '_token'
        ]);

        try {
            $data['id'] = $id;
            $media = $this->mediaService->saveMediaData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.medias.index');
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->mediaService->delete($request->id);
            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->back();
    }
}