<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libs\GetUserInfo;
use App\Models\WipScore;

class WipScoreController extends Controller
{
    private $user_user_id;
    private $user_domain_id;
    private $user_perm_group_id;
    private $user_user_active;
    private $user_user_profile_active;
    private $user_group_ids;
    private $user_supervisor_group_ids;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next){
            $src_user_id = Auth::user()->user_id;
            $base_user_info = GetUserInfo::getBaseUserInfo($src_user_id);   // domain_id, user_active, perm_grouop_id, user_profile_active
            $this->user_user_id = $src_user_id;
            $this->user_group_ids = GetUserInfo::getUserGroups($src_user_id);    // group_ids (collection)
            $this->user_supervisor_group_ids = GetUserInfo::getSupervisorGroups($src_user_id);    // supervisor_group_ids (collection)
            $this->user_domain_id = $base_user_info['domain_id'];
            $this->user_perm_group_id = $base_user_info['perm_group_id'];
            $this->user_user_active = $base_user_info['user_active'];
            $this->user_user_profile_active = $base_user_info['user_profile_active'];
            // if ($this->user_perm_group_id > 99 || $this->user_perm_group_id == null) { // if User is not more than Supervisor, not allowed to execute WipSupervisorGroupController
            //         return redirect('/dashboard_noperm');
            // }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if($this->user_perm_group_id >= 90) {   // super admin
            $wip_scores = WipScore::orderBy('time', 'asc')->get();
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <=69) {  // domain admin
            $wip_scores = DB::table('wip_scores')
            ->select("*")
            ->join('wip_users', 'wip_users.user_id', '=', 'wip_scores.user_id')
            ->where('wip_users.domain_id', $this->user_domain_id)
            ->orderBy('time', 'asc')
            ->get();
        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) {   // supervisor
            $wip_scores = DB::table('wip_scores')
            ->select("*")
            ->join('wip_user_groups', 'wip_user_groups.user_id', '=', 'wip_scores.user_id')
            ->join('wip_supervisor_groups', 'wip_supervisor_groups.group_id', '=', 'wip_user_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('time', 'asc')->get();
        } elseif ($this->user_perm_group_id >= 0 && $this->user_perm_group_id <= 10) {   //regular user
            $wip_scores = WipScore::where('user_id', $this->user_user_id)->orderBy('time', 'asc')->get();
        } else {
            return redirect('/dashboard_noperm');
        }
        return view('wip_scores', ['wip_scores' => $wip_scores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WipScore $wipScore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WipScore $wipScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipScore $wipScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WipScore $wipScore)
    {
        //
    }
}
