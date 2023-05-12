<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\ProductService;
use App\Services\ServiceService;
use App\Services\PlanService;
use App\Services\UserService;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{

    /**
     * @var CompanyService
     * @var ProductService
     * @var ServiceService
     * @var PlanService
     * @var UserService
     */

    protected CompanyService $companyService;
    protected ProductService $productService;
    protected ServiceService $serviceService;
    protected PlanService $planService;
    protected UserService $userService;

    public function __construct(
        CompanyService $companyService,
        ProductService $productService,
        ServiceService $serviceService,
        PlanService $planService,
        UserService $userService
    ) {
        $this->companyService = $companyService;
        $this->productService = $productService;
        $this->serviceService = $serviceService;
        $this->planService = $planService;
        $this->userService = $userService;
    }


    /**
     * Displays the dashboard screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $businesses = [
            "name" => "Negócios",
            "icon" => "fa fa-landmark"
        ];
        $products = [
            "name" => "Produtos",
            "icon" => "fa fa-cart-shopping"
        ];
        $services = [
            "name" => "Serviços",
            "icon" => "fa fa-briefcase"
        ];
        $plans = [
            "name" => "Plano",
            "icon" => "fa fa-id-badge"
        ];
        $customers = [
            "name" => "Clientes",
            "icon" => "fa fa-user"
        ];
        $partners = [
            "name" => "Parceiros",
            "icon" => "fa fa-user-check"
        ];
        $motoboys = [
            "name" => "Motoboys",
            "icon" => "fa fa-motorcycle"
        ];
        $sells = [
            "name" => "Vendas",
            "icon" => "fa fa-hand-holding-dollar"
        ];
        $negotiations = [
            "name" => "Negociações",
            "icon" => "fa fa-handshake"
        ];
        $businessesPlans = [
            "name" => "Empresas por Plano",
            "icon" => "fa fa-id-badge"
        ];

        $plans = $this->planService->getAll(25, 'id', 'desc');


        if (auth()->user()->hasRole('admin')) {
            $businesses['data']['active'] = count($this->companyService->filterCompanyFieldInArray('status', ['active'], 9999999, 'id', 'desc', auth()->id()));
            $businesses['data']['pending'] = count($this->companyService->filterCompanyFieldInArray('status', ['pending_approval'], 9999999, 'id', 'desc', auth()->id()));
            $businesses['route'] = 'admin.companies.index';
            $products['data'] = count($this->productService->getAll(9999999));
            $products['route'] = 'admin.products.index';
            $services['data'] = count($this->serviceService->getAll(9999999));
            $services['route'] = 'admin.services.index';
            $customers['data'] = count($this->userService->getAll(9999999, 'id', 'desc'));
            $customers['route'] = 'admin.users.index';
            $partnerRole = Role::where('name', 'partner')->first();
            $partners['data'] = User::role($partnerRole)->get()->count();
            $partners['route'] = 'admin.users.index';
            $motoboyRole = Role::where('name', 'motoboy')->first();
            $motoboys['data'] = User::role($motoboyRole)->get()->count();
            $motoboys['route'] = 'admin.users.index';
            $sells['data'] = "R$ " . "24.099,99";
            $sells['route'] = false;
            $negotiations['data'] = '34';
            $negotiations['route'] = false;
            $businessesPlans['data'] = [];
            foreach ($plans as $plan) {
                $businessesPlans['data'][] = [
                    'name' => $plan->name,
                    'entries' => count($this->companyService->filterCompanyFieldInArray('plan_id', [$plan->id], 9999999, 'id', 'desc', auth()->id())),
                ];
            }
            $businessesPlans['route'] = false;


        } else if (auth()->user()->hasRole('partner')) {
            $businesses['data']['active'] = count($this->companyService->filterCompanyFieldInArray('status', ['active'], 9999999, 'id', 'desc', auth()->id()));
            $businesses['data']['pending'] = count($this->companyService->filterCompanyFieldInArray('status', ['pending_approval'], 9999999, 'id', 'desc', auth()->id()));
            $businesses['route'] = 'partner.businesses.index';
            $products['data'] = count($this->productService->filterProductFieldInArray('status', ['DRAFT'], 9999999, 'id', 'desc', 'all', auth()->id()));
            $products['route'] = 'partner.products.index';
            $services['data'] = count($this->serviceService->filterServiceFieldInArray('status', ['DRAFT'], 9999999, 'id', 'desc', 'all', auth()->id()));
            $services['route'] = 'partner.services.index';
            $plans['data'] = "Free";
            $plans['route'] = false;
            $sells['data'] = "R$ " . "2.099,99";
            $sells['route'] = false;
            $negotiations['data'] = '4';
            $negotiations['route'] = false;

        } else {
            $businesses['data']['active'] = '#';
            $businesses['data']['pending'] = '#';
            $businesses['route'] = false;
            $products['data'] = '/';
            $products['route'] = false;
            $services['data'] = '/';
            $services['route'] = false;
            $plans['data'] = "Free";
            $plans['route'] = false;
            $sells['data'] = "R$ " . "2.099,99";
            $sells['route'] = false;
            $negotiations['data'] = '4';
            $negotiations['route'] = false;
        }

        $data = [
            "businesses" => $businesses,
            "products" => $products,
            "services" => $services,
            "plans" => $plans,
            "customers" => $customers,
            "partners" => $partners,
            "motoboys" => $motoboys,
            "sells" => $sells,
            "negotiations" => $negotiations,
            "businessesPlans" => $businessesPlans
        ];

        return view('pages/dashboard/dashboard', compact('data'));
    }
}