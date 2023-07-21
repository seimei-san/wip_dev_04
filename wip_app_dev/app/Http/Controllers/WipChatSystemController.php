<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Libs\GetUserInfo;
use App\Models\WipChatSystem;

class WipChatSystemController extends Controller
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
            if ($this->user_perm_group_id <= 89 || $this->user_perm_group_id == null) { // if User is not more than Super Admin, not allowed to execute WipChatSystemController
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
        $wip_chat_systems = WipChatSystem::orderBy('chat_sys', 'asc')->get();
        return view('wip_chat_systems', ['wip_chat_systems' => $wip_chat_systems]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**orderBy
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
           'chat_sys' => 'required|min:3|max:3',
           'chat_sys_name'  => 'required|min:3|max:30'
        ]);
        if ($validator->fails()) {
            return redirect('/chat_systems')->withInput()->withErrors($validator);
        }
        $wip_chat_system = new WipChatSystem();
        $wip_chat_system->chat_sys = $request->chat_sys;
        $wip_chat_system->chat_sys_name = $request->chat_sys_name;
        $wip_chat_system->save();
        return redirect('/chat_systems');

    }

    /**
     * Display the specified resource.
     */
    public function show(WipChatSystem $wipChatSystem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($chat_sys)
    {
        //
        $wip_chat_systems = WipChatSystem::find($chat_sys);
        return view('wip_chat_systemedit', ['wip_chat_systems' => $wip_chat_systems]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipChatSystem $wipChatSystem)
    {
        //
        $validator = Validator::make($request->all(), [
            // 'chat_sys' => 'required|min:3|max:3',
            'chat_sys_name' => 'required|min:3|max:30'
        ]);
        if ($validator->fails()) {
            return redirect('/chat_systemedit/'.$request->chat_sys)
            ->withInput()->withErrors($validator);
        }
        $wip_chat_system = WipChatSystem::find($request->chat_sys);
        $wip_chat_system->chat_sys = $request->chat_sys;
        $wip_chat_system->chat_sys_name = $request->chat_sys_name;
        $wip_chat_system->save();
        return redirect(('/chat_systems'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($chat_sys)
    {
        //
        $wip_chat_system = WipChatSystem::find($chat_sys);
        $wip_chat_system->delete();
        return redirect('/chat_systems');
    }
}
