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
                    ユーザー管理
                </div>
            </div>
            <!-- ++++ USER_FORM::START -->
            <form action="{{ url('user') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- +++ COL::name +++ -->
                    <div class="w-full md:w-1/1 px-3 py2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            ユーザー名
                        </label>
                        <!-- <input name="name" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder=""> -->
                    </div>
                    <!-- +++ COL::email +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            Email
                        </label>
                        <!-- <input name="email" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>
                    <!-- +++ COL::perm_group_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            権限グループ
                        </label>
                        <!-- <input name="domain_id" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>                    
                    <!-- +++ COL::domain_id +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            組織名
                        </label>
                        <!-- <input name="domain_id" class="appearance-none block w-full text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder=""> -->
                    </div>

                    <!-- +++ COL::user_active +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-blue-900 text-xs font-bold mb-2">
                            有効
                        </label>
                        <!-- <input type="hidden" name="user_active" value=0> -->
                        <!-- <input name="user_active" type="checkbox" value=1 class="appearance-none block text-blue-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500"> -->
                    </div>
                </div>
                <!-- +++ COL::BUTTON +++ -->
                <!-- <div class="flex flex-col">
                    <div class="text-blue-900 text-center px-4 py-2 m-2">
                        <x-button class="bg-yellow-900 rounded-lg">送信</x-button>
                    </div>
                </div> -->
            </form>
            <!-- ++++ USER_FORM::EMD -->
        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-blue-100 px-1 py-1 m-1">
            <div class="flex flox-grow">
                <div class="w-auto flex">
                    <div class="w-64 underline font-bold text-blue-800">ユーザーID</div>
                    <div class="w-36 underline font-bold text-blue-800">ユーザー名</div>
                    <div class="w-64 underline font-bold text-blue-800">Email</div>
                    <div class="w-36 underline font-bold text-blue-800">権限</div>
                    <div class="w-40 underline font-bold text-blue-800">組織名</div>
                    <div class="underline font-bold text-blue-800">有効</div>
                </div>
                <div class=""></div>
            </div>
            @if (count($wip_users) > 0)
                @foreach ($wip_users as $wip_user)
                
                    <x-wip-user-collection id="{{ $wip_user->user_id }}">
                        <div class="flex">
                            <div class="w-60">{{ $wip_user->user_id }}</div>
                            <div class="w-36">{{ $wip_user->name }}</div> 
                            <div class="w-64">{{ $wip_user->email }}</div> 
                            <div class="w-36">{{ $wip_user->perm_group_id }}</div> 
                            <div class="w-40">{{ $wip_user->domain_id }}</div> 
                            <div class="">{{ $wip_user->user_active }}</div> 
                        </div>
                    </x-wip-user-collection>
                @endforeach
            @else
                <div>データがありません</div>
            @endif
        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>