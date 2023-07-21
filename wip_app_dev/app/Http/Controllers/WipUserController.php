<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libs\GetUserInfo;
use App\Models\WipUser;
use App\Models\WipDomain;
use App\Models\WipPermGroup;

class WipUserController extends Controller
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
            $wip_users = WipUser::orderBy('name', 'asc')->get();
            $no_update = 0;
            $no_delete = 0;
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <=69) {  // domain admin
            $wip_users = WipUser::where('domain_id', $this->user_domain_id)
            ->orderBy('name', 'asc')->get();
            $no_update = 0;
            $no_delete = 0;
        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) {   // supervisor
            $wip_users = DB::table('wip_users')
            ->select("*")
            ->join('wip_user_groups', 'wip_users.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_supervisor_groups.group_id', '=', 'wip_user_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->get();
            $no_update = 0;
            $no_delete = 0;
        } elseif ($this->user_perm_group_id >= 0 && $this->user_perm_group_id <= 10) {   //regular user
            $wip_users = WipUser::where('user_id', $this->user_user_id)->get();
            $no_update = 1;
            $no_delete = 1;
        } else {
            return redirect('/dashboard_noperm');
        }
        return view('wip_users', ['wip_users' => $wip_users])
        ->with('no_update', $no_update)
        ->with('no_delete', $no_delete);        
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
    public function show(WipUser $wipUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id)
    {
        //

        if($this->user_perm_group_id >= 90) {   // super admin
            $wip_domains = WipDomain::get();
            $wip_perm_groups = WipPermGroup::get();
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <=69) {  // domain admin
            $wip_domains = WipDomain::where('domain_id', $this->user_domain_id)->get();
            $wip_perm_groups = WipPermGroup::where('perm_group_id', '<=', 69)->get();
        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) {   // supervisor
            $wip_domains = WipDomain::where('domain_id', $this->user_domain_id)->get();
            $wip_perm_groups = WipPermGroup::where('perm_group_id', '<=', 49)->get();
        } else {
            return redirect('/dashboard_noperm');
        }
        $wip_users = WipUser::find($user_id);
        return view('wip_useredit', ['wip_users' => $wip_users])
        ->with('wip_domains', $wip_domains)->with('wip_perm_groups', $wip_perm_groups);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipUser $wipUser)
    {
        //
        if ($this->user_perm_group_id < 40) {
            return redirect('/dashboard_noperm');
        }
        $validator = Validator::make($request->all(), [
            'domain_id' => 'required|min:8|max:8',
            'perm_group_id' => 'required|min:1|max:2'
        ]);
        if ($validator->fails()) {
            return redirect('/useredit/'.$request->user_id)
            ->withInput()
            ->withErrors($validator);
        }
        $wip_user = WipUser::find($request->user_id);
        $wip_user->domain_id = $request->domain_id;
        $wip_user->perm_group_id = $request->perm_group_id;
        if (empty($request->user_active)) {
            $wip_user->user_active = 0;
        } else {
            $wip_user->user_active = 1;
        }
        $wip_user->save();
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        //
        if ($this->user_perm_group_id < 40) {
            return redirect('/dashboard_noperm');
        }
        $wip_user = WipUser::find($user_id);
        $wip_user->delete();
        return redirect('/users');
    }
}
