<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

class ManagerDashboardController
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        return redirect()->route('manager.entity.index', ['entity' => 'orders']);

    }
}
