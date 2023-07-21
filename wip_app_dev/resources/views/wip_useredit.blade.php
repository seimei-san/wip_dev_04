<x-app-layout>
    <x-slot name='header'>
        <x-wip-header-menu></x-wip-header-menu>
    </x-slot>
    <x-errors id="errors" class='bg-blue-500 roundted-lg'>{{ $errors }}</x-errors>

    <!-- ####### ALL_AREA::START ########-->
    <div class="flex bg-blue-100">
        <!-- ######## LEFT_AREA::START ########## -->
        <div class="text-indigo-800 text-left px-4 py-4 mg-2">
            <div class="bg-indigo-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-indigo-50 border-b border-lime-800 font-bold">
                    ユーザー管理 (更新)
                </div>
            </div>
            <!-- ++++ USER_FORM::START -->
            <form action="{{ url('user/update') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- +++ COL::name +++ -->
                    <div class="w-full md:w-1/1 px-3 py2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            ユーザー名
                        </label>
                        <div class="px-2 py-2 mb-2 border border-blue-400 rounted">{{$wip_users->name}}</div>
                        <!-- <input name="name" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder=""> -->
                    </div>
                    <!-- +++ COL::email +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            Email
                        </label>
                        <div class="px-2 py-2 mb-2 border border-blue-400 rounted">{{$wip_users->email}}<</div>
                        <!-- <input name="email" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>
                    <!-- +++ COL::perm_group_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            権限グループ
                        </label>
                        <div class="form-group">
                            <select name="perm_group_id" id="perm_group_id-id" class="form-control">
                                <option value="{{$wip_users->perm_group_id}}">{{ $wip_users->perm_group_id }}</option>
                                @foreach($wip_perm_groups as $wip_perm_group)
                                    <option value="{{$wip_perm_group->perm_group_id}}">{{ $wip_perm_group->perm_group_name . "(" . $wip_perm_group->perm_group_id . ")" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <input name="perm_group_id" value="{{$wip_users->perm_group_id}}" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>                       
                    <!-- +++ COL::domain_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            組織名
                        </label>
                        <div class="form-group">
                            <select name="domain_id" id="domain-id" class="form-control">
                                <option value="{{$wip_users->domain_id}}">{{ $wip_users->domain_id }}</option>
                                @foreach($wip_domains as $wip_domain)
                                    <option value="{{$wip_domain->domain_id}}">{{ $wip_domain->domain_display_name . "(" . $wip_domain->domain_id . ")" }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <!-- <input name="domain_id" value="{{$wip_users->domain_id}}" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>

                    <!-- +++ COL::user_active +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            有効
                        </label>
                        <input name="user_active" type="checkbox" @if( $wip_users['user_active'] == true ) checked @endif class="appearance-none block text-lime-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500">
                    </div>
                </div>
                <!-- +++ COL::BUTTON +++ -->
                <div class="flex flex-col">
                    <div class="text-blue-900 text-center px-4 py-2 m-2">
                        <x-button class="bg-yellow-900 rounded-lg">更新</x-button>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{$wip_users->user_id}}">
            </form>
            <!-- ++++ USER_FORM::EMD -->
        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-blue-100 px-1 py-1 m-1">

        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>