<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class BePartnerController extends Controller
{
    protected User $user;
    function __construct(User $user)
    {
        $this->user = $user;
    }



    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $data = $request->except([
            '_token',
        ]);
        $roles = ['partner' => 'partner'];

        try {
            $user = $this->user->find($id);
            $user->syncRoles($roles);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_error");
            return redirect()->back();
        }

        return redirect()->back();
    }

}