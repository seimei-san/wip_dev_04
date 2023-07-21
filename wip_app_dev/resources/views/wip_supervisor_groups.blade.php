<x-app-layout>
    <x-slot name='header'>
        <x-wip-header-menu></x-wip-header-menu>
    </x-slot>
    <x-errors id="errors" class='bg-blue-500 roundted-lg'>{{ $errors }}</x-errors>

    <!-- ####### ALL_AREA::START ########-->
    <div class="flex bg-gray-100">
        <!-- ######## LEFT_AREA::START ########## -->
        <div class="text-indigo-800 text-left px-4 py-4 mg-2">
            <div class="bg-indigo-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-indigo-50 border-b border-lime-800 font-bold">
                    監督グループ (追加)
                </div>
            </div>
            <!-- ++++ GROUP_FORM::START -->
            <form action="{{ url('supervisor_group') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- +++ COL::supervisor_user_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            監督ユーザーID
                        </label>
                        <div class="form-group">
                            <select name="supervisor_user_id" id="supervisor-user-id" class="form-control">
                                <option value=""></option>
                                @foreach($wip_users as $wip_user)
                                    <option value="{{$wip_user->user_id}}">{{ $wip_user->name . "(" . $wip_user->user_id . ")" }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <!-- <input name="supervisor_user_id" class="appearance-none block w-full text-blue-900 border border-gray-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder=""> -->
                    </div>
                    <!-- +++ COL::group_id+++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            グループID
                        </label>
                        <div class="form-group">
                            <select name="group_id" id="group-id" class="form-control">
                                <option value=""></option>
                                @foreach($wip_groups as $wip_group)
                                    <option value="{{$wip_group->group_id}}">{{ $wip_group->group_display_name . "(" . $wip_group->domain_id . ")" }}</option>
                                @endforeach
                            </select>
                        </div>  
                        <!-- <input name="group_id" class="appearance-none block w-full text-blue-900 border border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder=""> -->
                    </div>
                </div> 
                <!-- +++ COL::BUTTON +++ -->
                <div class="flex flex-col">
                    <div class="text-gray-900 text-center px-4 py-2 m-2">
                        <x-button class="bg-gray-900 rounded-lg">追加</x-button>
                    </div>
                </div>
            </form>
            <!-- ++++ GROUP_FORM::EMD -->
        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-gray-100 px-1 py-1 m-1">
            <div class="flex flox-grow">
                <div class="w-auto flex">
                    <div class="w-24 underline font-bold text-blue-800 align-text-bottom">ID</div>
                    <div class="w-60 underline font-bold text-blue-800 align-text-bottom">監督ユーザーID</div>
                    <div class="w-32 underline font-bold text-blue-800">グループID</div>
                </div>
                <div class=""></div>
            </div>
            @if (count($wip_supervisor_groups) > 0)
                @foreach ($wip_supervisor_groups as $wip_supervisor_group)
                    <x-wip-supervisor-group-collection id="{{ $wip_supervisor_group->supervisor_group_id }}">
                        <div class="flex">
                            <div class="w-20">{{ $wip_supervisor_group->supervisor_group_id }}</div>
                            <div class="w-60">{{ $wip_supervisor_group->supervisor_user_id }}</div> 
                            <div class="w-36">{{ $wip_supervisor_group->group_id }}</div> 
                        </div>
                    </x-wip-supervisor-group-collection>
                @endforeach
            @else
                <div>データがありません</div>
            @endif
        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>