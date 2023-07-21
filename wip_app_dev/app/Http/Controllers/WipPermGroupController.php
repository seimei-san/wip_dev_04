<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\WipPermGroup;
use App\Libs\GetUserInfo;

class WipPermGroupController extends Controller
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
            if ($this->user_perm_group_id <= 89 || $this->user_perm_group_id == null) { // if User is not Super Admin, not allowed to execute WipPermGroupController
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
        $wip_perm_groups = WipPermGroup::orderBy('perm_group_id', 'asc')->get();
        return view('wip_perm_groups', ['wip_perm_groups' => $wip_perm_groups]);
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
            'perm_group_id' => 'required|min:2|max:2',
            'perm_group_name' => 'required|min:3|max:20'
        ]);
        if ($validator->fails()) {
            return redirect('/perm_groups')->withInput()->withErrors($validator);
        }
        $wip_perm_group = new WipPermGroup();
        $wip_perm_group->perm_group_id = $request->perm_group_id;
        $wip_perm_group->perm_group_name = $request->perm_group_name;
        $wip_perm_group->save();
        return redirect('/perm_groups');
    }

    /**
     * Display the specified resource.
     */
    public function show(WipPermGroup $wipPermGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($perm_group_id)
    {
        //
        $wip_perm_groups = WipPermGroup::find($perm_group_id);
        return view('wip_perm_groupedit', ['wip_perm_groups' => $wip_perm_groups]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipPermGroup $wipPermGroup)
    {
        //
        $validator = Validator::make($request->all(), [
            'perm_group_name' => 'required|min:3|max:20'
        ]);
        if ($validator->fails()) {
            return redirect('/perm_groupedit/'.$request->perm_group_id)
            ->withInput()->withErrors($validator);
        }
        $wip_perm_group = WipPermGroup::find($request->perm_group_id);
        $wip_perm_group->perm_group_name = $request->perm_group_name;
        $wip_perm_group->save();
        return redirect('/perm_groups');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($perm_group_id)
    {
        //
        $wip_perm_group = WipPermGroup::find($perm_group_id);
        $wip_perm_group->delete();
        return redirect('/perm_groups');
    }
}
