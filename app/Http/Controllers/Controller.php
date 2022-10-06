<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $data = [];
    protected $perpage = 10;
    protected $mhspt;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->mhspt = Auth::user()->siakad_mhspt()->exists() ? Auth::user()->siakad_mhspt->id_mhs_pt : '';
            return $next($request);
        });
    }
}
