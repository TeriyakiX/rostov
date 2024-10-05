<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        return redirect()->route('admin.entity.index', ['entity' => 'orders']);
//        return view('admin.dashboard.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function excelShow(Request $request)
    {
        
        return view('admin.dashboard.import_excel');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excelImport(Request $request)
    {
        Excel::import(new ProductsImport(), $request->file('file'));
        return back();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excelExport()

    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }
}
