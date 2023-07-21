<?php

namespace App\libs;

use App\Models\WipUser;
use App\Models\WipUserProfile;
use App\Models\WipUserGroup;
use App\Models\WipSupervisorGroup;


class GetUserInfo
{
    public static function getBaseUserInfo($user_id) {
        $base_user_info = [];
        $tmp_user_info = WipUser::find($user_id);
        if ($tmp_user_info == null) {
            $base_user_info = ['domain_id'=>null, 'user_active'=>null, 'perm_user_id'=>null];
        } else {
            $base_user_info['domain_id'] = $tmp_user_info['domain_id'];
            $base_user_info['user_active'] = $tmp_user_info['user_active'];
            $base_user_info['perm_group_id'] = $tmp_user_info['perm_group_id'];
        }
        $tmp_user_profile = WipUserProfile::get()->where('user_id', $user_id)->first();
        if ($tmp_user_profile == null) {
            $base_user_info['user_profile_active'] = null;
        } else {
            $base_user_info['user_profile_active'] = $tmp_user_profile['user_profile_active'];
        }
        return $base_user_info;
    }

    public static function getUserInfo($user_id){
        $wip_user_info = [];
        $tmp_user_info = WipUser::find($user_id);
        if ($tmp_user_info == null) {
            return null;
        }
        // dd($user_id);
        // dd($tmp_user_info['domain_id']);
        $wip_user_info['domain_id'] = $tmp_user_info['domain_id'];
        $wip_user_info['user_active'] = $tmp_user_info['user_active'];
        $wip_user_info['perm_group_id'] = $tmp_user_info['perm_group_id'];
        return $wip_user_info;

    }
    public static function getUserProfile($user_id){
        $wip_user_profile = [];
        $tmp_user_profile = WipUserProfile::get()->where('user_id', $user_id)->first();
        if ($tmp_user_profile == null) {
            return null;
        }
        // dd($tmp_user_profile);
        $wip_user_profile['chat_user_id'] = $tmp_user_profile['chat_user_id'];
        $wip_user_profile['chat_sys'] = $tmp_user_profile['chat_sys'];
        $wip_user_profile['chat_interval'] = $tmp_user_profile['chat_interval'];
        $wip_user_profile['chat_limit'] = $tmp_user_profile['chat_limit'];
        $wip_user_profile['user_profile_active'] = $tmp_user_profile['user_profile_active'];
        return $wip_user_profile;
    }
    
    public static function getUserGroups($user_id){
        $wip_user_groups = [];
        $tmp_user_groups = WipUserGroup::get()->where('user_id', $user_id);
        if ($tmp_user_groups == null) {
            return null;
        }
        // dd($tmp_user_groups);
        foreach($tmp_user_groups as $tmp_user_group) {
            // dd($tmp_user_group);
            $wip_user_groups[] = $tmp_user_group['group_id'];
        }
        return $wip_user_groups;
    }
    public static function getSupervisorGroups($user_id){
        $wip_supervisor_groups = [];
        $tmp_supervisor_groups = WipSupervisorGroup::get()->where('supervisor_user_id', $user_id);
        if ($tmp_supervisor_groups == null) {
            return null;
        }
        foreach($tmp_supervisor_groups as $tmp_supervisor_group) {
            $wip_supervisor_groups[] = $tmp_supervisor_group;
        }
        return $wip_supervisor_groups;
    }

}

