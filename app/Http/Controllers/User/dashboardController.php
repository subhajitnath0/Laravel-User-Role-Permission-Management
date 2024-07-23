<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class dashboardController extends Controller
{
    public function index()
    {
        
        if(!hasPermissions('Dashboard')){
            abort(404, 'Page Not Found');
        }
        return view('user.dashboard.Dashboard');
    }
}
