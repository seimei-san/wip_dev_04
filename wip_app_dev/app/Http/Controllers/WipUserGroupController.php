<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libs\GetUserInfo;
use App\Models\WipUserGroup;
use App\Models\WipUser;
use App\Models\WipGroup;


class WipUserGroupController extends Controller
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
            if ($this->user_perm_group_id <= 39 || $this->user_perm_group_id == null) { // if User is not more than Supervisor, not allowed to execute WipSupervisorGroupController
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
        if ($this->user_perm_group_id >= 90){   // super admin
            $wip_users = WipUser::get();
            $wip_groups = WipGroup::get();
            $wip_user_groups = WipUserGroup::orderBy('user_id', 'asc')->get();
            
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <= 69) { // domain admin
            $wip_users = WipUser::where('domain_id', $this->user_domain_id)->get();
            $wip_groups = WipGroup::where('domain_id', $this->user_domain_id)->get();
            $wip_user_groups = DB::table('wip_user_groups')
            ->select("*")
            ->join('wip_groups', 'wip_groups.group_id', '=', 'wip_user_groups.group_id')
            ->where('wip_groups.domain_id', $this->user_domain_id)
            ->orderBy('user_id', 'asc')
            ->get();
        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) { // supervisor
            $wip_users = DB::table('wip_users')
            ->select("*")
            ->join('wip_user_groups', 'wip_users.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_user_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_users.user_id', 'asc')
            ->get();
            $wip_groups = DB::table('wip_groups')
            ->select("*")
            ->join('wip_supervisor_groups', 'wip_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->get();
            $wip_user_groups = DB::table('wip_user_groups')
            ->select("*")
            ->join('wip_supervisor_groups', 'wip_supervisor_groups.group_id', '=', 'wip_user_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_user_groups.user_id', 'asc')
            ->get();
        } else {        // others
            return redirect('/dashboard_noperm');
        }
        return view('wip_user_groups', ['wip_user_groups' => $wip_user_groups])
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
            'user_id' => 'required|min:20|max:20',
            'group_id' => 'required|min:12|max:12'
        ]);
        if ($validator->fails()) {
            return redirect('/user_groups')->withInput()->withErrors($validator);
        }
        $wip_user_group = new WipUserGroup();
        $wip_user_group->user_id = $request->user_id;
        $wip_user_group->group_id = $request->group_id;
        $wip_user_group->save();
        return redirect('/user_groups');
    }

    /**
     * Display the specified resource.
     */
    public function show(WipUserGroup $wipUserGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_group_id)
    {
        //
        if ($this->user_perm_group_id >= 90){   // super admin
            $wip_users = WipUser::get();
            $wip_groups = WipGroup::get();
            
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <= 69) { // domain admin
            $wip_users = WipUser::where('domain_id', $this->user_domain_id)->get();
            $wip_groups = WipGroup::where('domain_id', $this->user_domain_id)->get();

        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) { // supervisor
            $wip_users = DB::table('wip_users')
            ->select("*")
            ->join('wip_user_groups', 'wip_users.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_user_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_users.user_id', 'asc')
            ->get();
            $wip_groups = DB::table('wip_groups')
            ->select("*")
            ->join('wip_supervisor_groups', 'wip_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->get();

        } else {        // others
            return redirect('/dashboard_noperm');
        }
        $wip_user_groups = WipUserGroup::find($user_group_id);
        return view('wip_user_groupedit', ['wip_user_groups' => $wip_user_groups])
        ->with('wip_users', $wip_users)
        ->with('wip_groups', $wip_groups);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipUserGroup $wipUserGroup)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:20|max:20',
            'group_id' => 'required|min:12|max:12'
        ]);
        if ($validator->fails()) {
            return redirect('/user_groupedit'.$request->user_group_id)
            ->withInput()->withErrors($validator);
        }
        $wip_user_group = WipUserGroup::find($request->user_group_id);
        $wip_user_group->user_id = $request->user_id;
        $wip_user_group->group_id = $request->group_id;
        $wip_user_group->save();
        return redirect('/user_groups');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_group_id)
    {
        //
        $wip_user_group = WipUserGroup::find($user_group_id);
        $wip_user_group->delete();
        return redirect('/user_groups');
    }
}
