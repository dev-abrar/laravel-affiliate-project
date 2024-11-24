<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthVisitor = Visitor::whereMonth('updated_at', $currentMonth)
                           ->whereYear('updated_at', $currentYear)
                           ->paginate(20);

        $visitors = DB::table('visitors')
        ->select('id', 'ip_address', 'location', 'month')
        ->whereIn('id', function($query) {
            $query->selectRaw('MAX(id)')
                    ->from('visitors')
                    ->groupBy('ip_address');
        })
        ->orderBy('updated_at', 'desc')
        ->paginate(20); 
                       
                       
        $monthly_count = Visitor::whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->count();

        $total_count = DB::table('visitors')
        ->select('id', 'ip_address', 'location', 'month')
        ->whereIn('id', function($query) {
        $query->selectRaw('MAX(id)')
        ->from('visitors')
        ->groupBy('ip_address');
        })
        ->orderBy('updated_at', 'desc')
        ->count(); 

        
        
        return view('pages.dashboard.dashboard',[
            'visitors'=>$visitors,
            'monthVisitor'=>$monthVisitor,
            'monthly_count'=>$monthly_count,
            'total_count'=>$total_count,
        ]);
    }

    
    function delete_visitor($id){
        // Delete the visitor by id and return the number of rows affected
        // return Visitor::where('id', $id)->delete();
        Visitor::where('id', $id)->delete();
        return back();
    }
    
    function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
