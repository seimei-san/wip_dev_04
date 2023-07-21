<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\WipDomain;
use App\Models\WipGroup;
use App\Libs\GetUserInfo;


class WipGroupController extends Controller
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
            if ($this->user_perm_group_id <= 49 || $this->user_perm_group_id == null) { // if User is not more than Domain Admin, not allowed to execute WipGroupController
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

        if ($this->user_perm_group_id <= 69) {  //if User is Domain Admin
            $wip_domains = WipDomain::get()->where('domain_id', $this->user_domain_id);
            $wip_groups = WipGroup::orderBy('group_short_name', 'asc')->get()->where('domain_id', $this->user_domain_id);
        } else {    // if User is Super Admin
            $wip_domains = WipDomain::get();
            $wip_groups = WipGroup::orderBy('group_short_name', 'asc')->get();
        }
        return view('wip_groups', ['wip_groups' => $wip_groups])->with('wip_domains',$wip_domains);
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
            'group_short_name' => 'required|min:2|max:12',
            'group_display_name' => 'required|min:2|max:36'
        ]);
        if ($validator->fails()) {
            return redirect('/groups')->withInput()->withErrors($validator);
        }
        $tmpId = \App\Libs\Util::generateId('U', 12);
        $request['group_id'] = $tmpId;
        $wip_group = new WipGroup();
        $wip_group->group_id = $request->group_id;
        $wip_group->group_short_name = $request->group_short_name;
        $wip_group->group_display_name = $request->group_display_name;
        $wip_group->domain_id = $request->domain_id;
        $wip_group->group_active = $request->group_active;
        $wip_group->save();
        return redirect('/groups');
    }

    /**
     * Display the specified resource.
     */
    public function show(WipGroup $wipGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($group_id)
    {
        //
        if ($this->user_perm_group_id <= 69) {  //if User is Domain Admin
            $wip_domains = WipDomain::get()->where('domain_id', $this->user_domain_id);
            $wip_groups = WipGroup::find($group_id);
        } else {       // if User is Super Admin
            $wip_domains = WipDomain::get();
            $wip_groups = WipGroup::find($group_id);
        }
        return view('wip_groupedit', ['wip_groups' => $wip_groups])->with('wip_domains',$wip_domains);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WipGroup $wipGroup)
    {
        //
        $validator = Validator::make($request->all(), [
            'group_short_name' => 'required|min:2|max:12',
            'group_display_name' => 'required|min:2|max:36',
            'domain_id' => 'required|min:3|max:8'
        ]);
        if ($validator->fails()) {
            return redirect('/groupedit/'.$request->group_id)
            ->withInput()
            ->withErrors($validator);
        }
        $wip_group = WipGroup::find($request->group_id);
        $wip_group->group_short_name = $request->group_short_name;
        $wip_group->group_display_name = $request->group_display_name;
        $wip_group->domain_id = $request->domain_id;
        if (empty($request->group_active)) {
            $wip_group->group_active = 0;
        } else {
            $wip_group->group_active = 1;
        }
        $wip_group->save();
        return redirect('/groups');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($group_id)
    {
        //
        $wip_group = WipGroup::find($group_id);
        $wip_group->delete();
        return redirect(('/groups'));
    }
}
