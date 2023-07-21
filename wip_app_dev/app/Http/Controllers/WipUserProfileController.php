<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libs\GetUserInfo;
use App\Models\WipUserProfile;
use App\Models\WipUser;
use App\Models\WipChatSystem;

class WipUserProfileController extends Controller
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
            $wip_user_profiles = WipUserProfile::orderBy('user_id', 'asc')->get();
            
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <= 69) { // domain admin
            $wip_users = WipUser::where('domain_id', $this->user_domain_id)->get();
            $wip_user_profiles = DB::table('wip_user_profiles')
            ->select("*")
            ->join('wip_users', 'wip_user_profiles.user_id', '=', 'wip_users.user_id')
            ->where('wip_users.domain_id', $this->user_domain_id)
            ->orderBy('wip_user_profiles.user_id', 'asc')
            ->get();
        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) { // supervisor
            $wip_users = DB::table('wip_users')
            ->select("*")
            ->join('wip_user_groups', 'wip_users.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_user_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_users.user_id', 'asc')
            ->get();
            $wip_user_profiles = DB::table('wip_user_profiles')
            ->select("*")
            ->join('wip_user_groups', 'wip_user_profiles.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_user_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_user_profiles.user_id', 'asc')
            ->get();
        } else {        // others
            return redirect('/dashboard_noperm');
        }
        $wip_chat_systems = WipChatSystem::get();
        return view('wip_user_profiles', ['wip_user_profiles' => $wip_user_profiles])
        ->with('wip_users', $wip_users)
        ->with('wip_chat_systems', $wip_chat_systems);
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:20|max:20',
            'chat_user_id' => 'required|min:3|max:20',
            'chat_sys' => 'required|min:3|max:3',
            'chat_interval' => 'required|min:1|max:4',
            'chat_limit' => 'required|min:1|max:4',
        ]);
        if ($validator->fails()) {
            return redirect('/user_profiles')->withInput()->withErrors($validator);
        }
        $wip_user_profile = new WipUserProfile();
        $wip_user_profile->user_id = $request->user_id;
        $wip_user_profile->chat_user_id = $request->chat_user_id;
        $wip_user_profile->chat_sys = $request->chat_sys;
        $wip_user_profile->chat_interval = $request->chat_interval;
        $wip_user_profile->chat_limit = $request->chat_limit;
        $wip_user_profile->user_profile_active = $request->user_profile_active;
        $wip_user_profile->user_note = $request->user_note;
        $wip_user_profile->save();
        return redirect('/user_profiles');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(WipUserProfile $wipUserProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_profile_id)
    {
        //
        if ($this->user_perm_group_id >= 90){   // super admin
            $wip_users = WipUser::get();
            
        } elseif ($this->user_perm_group_id >= 60 && $this->user_perm_group_id <= 69) { // domain admin
            $wip_users = WipUser::where('domain_id', $this->user_domain_id)->get();

        } elseif ($this->user_perm_group_id >= 40 && $this->user_perm_group_id <= 49) { // supervisor
            $wip_users = DB::table('wip_users')
            ->select("*")
            ->join('wip_user_groups', 'wip_users.user_id', '=', 'wip_user_groups.user_id')
            ->join('wip_supervisor_groups', 'wip_user_groups.group_id', '=', 'wip_supervisor_groups.group_id')
            ->where('wip_supervisor_groups.supervisor_user_id', $this->user_user_id)
            ->orderBy('wip_users.user_id', 'asc')
            ->get();

        } else {        // others
            return redirect('/dashboard_noperm');
        }

        $wip_user_profiles = WipUserProfile::find($user_profile_id);
        $wip_chat_systems = WipChatSystem::get();
        return view('wip_user_profileedit', ['wip_user_profiles' => $wip_user_profiles])
        ->with('wip_users', $wip_users)
        ->with('wip_chat_systems', $wip_chat_systems);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipUserProfile $wipUserProfile)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|min:20|max:20',
            'chat_user_id' => 'required|min:3|max:20',
            'chat_sys' => 'required|min:3|max:3',
            'chat_interval' => 'required|min:1|max:4',
            'chat_limit' => 'required|min:1|max:4',
        ]);
        if ($validator->fails()) {
            return redirect('/user_profileedit/'.$request->user_profile_id)
            ->withInput()
            ->withError($validator);
        }
        $wip_user_profile = WipUserProfile::find($request->user_profile_id);
        $wip_user_profile->user_id = $request->user_id;
        $wip_user_profile->chat_user_id = $request->chat_user_id;
        $wip_user_profile->chat_sys = $request->chat_sys;
        $wip_user_profile->chat_interval = $request->chat_interval;
        $wip_user_profile->chat_limit = $request->chat_limit;
        if (empty($request->user_profile_active)) {
            $wip_user_profile->user_profile_active = 0;
        } else {
            $wip_user_profile->user_profile_active = 1;
        }
        $wip_user_profile->user_note = $request->user_note;
        $wip_user_profile->save();
        return redirect('/user_profiles');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_profile_id)
    {
        //
        $wip_user_profile = WipUserProfile::find($user_profile_id);
        $wip_user_profile->delete();
        return redirect('/user_profiles');
    }
}
