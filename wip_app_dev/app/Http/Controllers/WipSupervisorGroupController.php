<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\WipSupervisorGroup;
use App\Models\WipUser;
use App\Models\WipGroup;
use App\Libs\GetUserInfo;


class WipSupervisorGroupController extends Controller
{
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
            $this->user_group_ids = GetUserInfo::getUserGroups($src_user_id);    // group_ids (collection)
            $this->user_supervisor_group_ids = GetUserInfo::getSupervisorGroups($src_user_id);    // supervisor_group_ids (collection)
            $this->user_domain_id = $base_user_info['domain_id'];
            $this->user_perm_group_id = $base_user_info['perm_group_id'];
            $this->user_user_active = $base_user_info['user_active'];
            $this->user_user_profile_active = $base_user_info['user_profile_active'];
            if ($this->user_perm_group_id <= 49 || $this->user_perm_group_id == null) { // if User is not more than Domain Admin, not allowed to execute WipSupervisorGroupController
                    return redirect('/dashboard_noperm');
            }
            return $next($request);
        });
    }


  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supervisor_key = config('spv.key', 40);
        if ($this->user_perm_group_id <= 69) {  //if User is Domain Admin
            $wip_users = WipUser::where('perm_group_id', $supervisor_key)
            ->where('domain_id', $this->user_domain_id)
            ->get();
            $wip_groups = WipGroup::where('domain_id', $this->user_domain_id)->get();
            $wip_supervisor_groups = DB::table('wip_supervisor_groups')
            ->select('*')
            ->join('wip_groups', 'wip_supervisor_groups.group_id', '=', 'wip_groups.group_id')
            ->where('wip_groups.domain_id', $this->user_domain_id)
            ->orderBy('supervisor_user_id', 'asc')
            ->get();

        } else {    // if User is Super Admin
            $wip_users = WipUser::where('perm_group_id', $supervisor_key)->get();
            $wip_groups = WipGroup::get();
            $wip_supervisor_groups = WipSupervisorGroup::orderBy('supervisor_user_id', 'asc')->get();
        }
        return view('wip_supervisor_groups', ['wip_supervisor_groups' => $wip_supervisor_groups])
        ->with('wip_users', $wip_users)
        ->with('wip_groups', $wip_groups);
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
        $validator = Validator::make($request->all(),[
            'supervisor_user_id' => 'required|min:20|max:20',
            'group_id' => 'required|min:12|max:12'
        ]);
        if ($validator->fails()) {
            return redirect('/supervisor_groups')->withInput()->withErrors($validator);
        }
        $wip_supervisor_group = new WipSupervisorGroup();
        $wip_supervisor_group->supervisor_user_id = $request->supervisor_user_id;
        $wip_supervisor_group->group_id = $request->group_id;
        $wip_supervisor_group->save();
        return redirect('/supervisor_groups');
    }

    /**
     * Display the specified resource.
     */
    public function show(WipSupervisorGroup $wipSupervisorGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($supervisor_group_id)
    {
        //
        $supervisor_key = config('spv.key', 40);
        if ($this->user_perm_group_id <= 69) {  //if User is Domain Admin
            $wip_users = WipUser::where('perm_group_id', $supervisor_key)
            ->where('domain_id', $this->user_domain_id)
            ->get();
            $wip_groups = WipGroup::where('domain_id', $this->user_domain_id)->get();
        } else {       // if User is Super Admin
            $wip_users = WipUser::where('perm_group_id', $supervisor_key)->get();
            $wip_groups = WipGroup::get();
        }
        $wip_supervisor_groups = WipSupervisorGroup::find($supervisor_group_id);
        return view('wip_supervisor_groupedit', ['wip_supervisor_groups' => $wip_supervisor_groups])
        ->with('wip_users', $wip_users)
        ->with('wip_groups', $wip_groups);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipSupervisorGroup $wipSupervisorGroup)
    {
        //
        $validator = Validator::make($request->all(), [
            'supervisor_user_id' => 'required|min:20|max:20',
            'group_id' => 'required|min:12|max:12'
        ]);
        if ($validator->fails()) {
            return redirect('/supervisor_groupedit'.$request->supervisor_group_id)
            ->withInput()->withErrors($validator);
        }
        $wip_supervisor_group = WipSupervisorGroup::find($request->supervisor_group_id);
        $wip_supervisor_group->supervisor_user_id = $request->supervisor_user_id;
        $wip_supervisor_group->group_id = $request->group_id;
        $wip_supervisor_group->save();
        return redirect('/supervisor_groups');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($supervisor_group_id)
    {
        //
        $wip_supervisor_group = WipSupervisorGroup::find($supervisor_group_id);
        $wip_supervisor_group->delete();
        return redirect('/supervisor_groups');
    }
}
