<x-app-layout>
    <x-slot name='header'>
    <x-wip-header-menu></x-wip-header-menu>
    </x-slot>
    <x-errors id="errors" class='bg-blue-500 roundted-lg'>{{ $errors }}</x-errors>

    <!-- ####### ALL_AREA::START ########-->
    <div class="flex bg-yellow-100">
        <!-- ######## LEFT_AREA::START ########## -->
        <div class="text-indigo-800 text-left px-4 py-4 mg-2">
            <div class="bg-indigo-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-indigo-50 border-b border-lime-800 font-bold">
                    グループ管理 (追加)
                </div>
            </div>
            <!-- ++++ GROUP_FORM::START -->
            <form action="{{ url('group') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- +++ COL::domain_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            組織名
                        </label>
                        <div class="form-group">
                            <select name="domain_id" id="domain-id" class="form-control">
                                <option value=""></option>
                                @foreach($wip_domains as $wip_domain)
                                    <option value="{{$wip_domain->domain_id}}">{{ $wip_domain->domain_display_name . "(" . $wip_domain->domain_id . ")" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <input name="domain_id" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>                    
                    <!-- +++ COL::group_short_name +++ -->
                    <div class="w-full md:w-1/1 px-3 py2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            グループ略称
                        </label>
                        <input name="group_short_name" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                    <!-- +++ COL::group_display_name +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            グループ名
                        </label>
                        <input name="group_display_name" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder="">
                    </div>
                    <!-- +++ COL::group_active +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            有効
                        </label>
                        <input type="hidden" name="group_active" value=0>
                        <input name="group_active" type="checkbox" value=1 class="appearance-none block text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500">
                    </div>
                </div>
                <!-- +++ COL::BUTTON +++ -->
                <div class="flex flex-col">
                    <div class="text-yellow-900 text-center px-4 py-2 m-2">
                        <x-button class="bg-yellow-900 rounded-lg">追加</x-button>
                    </div>
                </div>
            </form>
            <!-- ++++ GROUP_FORM::EMD -->
        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-blue-100 px-1 py-1 m-1">
            <div class="flex flox-grow">
                <div class="w-auto flex">
                    <div class="w-64 underline font-bold text-blue-800">グループID</div>
                    <div class="w-40 underline font-bold text-blue-800">グループ略称</div>
                    <div class="w-64 underline font-bold text-blue-800">グループ名</div>
                    <div class="w-64 underline font-bold text-blue-800">組織名</div>
                    <div class="underline font-bold text-blue-800">有効</div>
                </div>
                <div class=""></div>
            </div>
            @if (count($wip_groups) > 0)
                @foreach ($wip_groups as $wip_group)
                
                    <x-wip-group-collection id="{{ $wip_group->group_id }}">
                        <div class="flex">
                            <div class="w-64">{{ $wip_group->group_id }}</div>
                            <div class="w-40">{{ $wip_group->group_short_name }}</div> 
                            <div class="w-64">{{ $wip_group->group_display_name }}</div> 
                            <div class="w-64">{{ $wip_group->domain_id }}</div> 
                            <div class="">{{ $wip_group->group_active }}</div> 
                        </div>
                    </x-wip-group-collection>
                @endforeach
            @else
                <div>データがありません</div>
            @endif
        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>