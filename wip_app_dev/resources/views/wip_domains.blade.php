<x-app-layout>
    <x-slot name='header'>
    <x-wip-header-menu></x-wip-header-menu>
    </x-slot>
    <x-errors id="errors" class='bg-blue-500 roundted-lg'>{{ $errors }}</x-errors>

    <!-- ####### ALL_AREA::START ########-->
    <div class="flex bg-emerald-100">
        <!-- ######## LEFT_AREA::START ########## -->
        <div class="text-indigo-800 text-left px-4 py-4 mg-2">
            <div class="bg-indigo-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-indigo-50 border-b border-lime-800 font-bold">
                    組織管理 (追加)
                </div>
            </div>
            <!-- ++++ DOMAIN_FORM::START -->
            <form action="{{ url('domain') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- +++ COL::domain_id +++ -->
                    <!-- <div class="w-full md:w-1/1 px-2 py-2"> -->
                        <!-- <label class="block uppercase tracking-wide text-lime-800 text-xs font-bold mb-2"> -->
                            <!-- 組織ID -->
                        <!-- </label> -->
                        <!-- <input name="domain_id" class="appearance-none block w-full text-lime-900 border border-yellow-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder=""> -->
                    <!-- </div> -->
                    <!-- +++ COL::domain_short_name +++ -->
                    <div class="w-full md:w-1/1 px-3 py2">
                        <label class="block uppercase tracking-wide text-lime-900 text-xs font-bold mb-2">
                            組織略称
                        </label>
                        <input name="domain_short_name" class="appearance-none block w-full text-lime-900 border border-yellow-600 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                    <!-- +++ COL::domain_display_name +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-lime-900 text-xs font-bold mb-2">
                            組織名
                        </label>
                        <input name="domain_display_name" class="appearance-none block w-full text-lime-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500" type="text" placeholder="">
                    </div>
                    <!-- +++ COL::domain_active +++ -->
                    <div class="w-full md:w-1/1 px-3 py-2">
                        <label class="block uppercase tracking-wide text-lime-900 text-xs font-bold mb-2">
                            有効
                        </label>
                        <input type="hidden" name="domain_active" value=0>
                        <input name="domain_active" type="checkbox" value=1 class="appearance-none block text-lime-900 border border-yellow-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-yellow-500">
                    </div>
                </div>
                <!-- +++ COL::BUTTON +++ -->
                <div class="flex flex-col">
                    <div class="text-lime-900 text-center px-4 py-2 m-2">
                        <x-button class="bg-yellow-900 rounded-lg">追加</x-button>
                    </div>
                </div>
            </form>
            <!-- ++++ DOMAIN_FORM::EMD -->
        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-lime-100 px-1 py-1 m-1">
            <div class="flex flox-grow">
                <div class="w-auto flex">
                    <div class="w-32 underline font-bold text-green-800">組織ID</div>
                    <div class="w-40 underline font-bold text-green-800">組織略称</div>
                    <div class="w-64 underline font-bold text-green-800">組織名</div>
                    <div class="underline font-bold text-green-800">有効</div>
                </div>
                <div class=""></div>
            </div>
            @if (count($wip_domains) > 0)
                @foreach ($wip_domains as $wip_domain)
                
                    <x-wip-domain-collection id="{{ $wip_domain->domain_id }}">
                        <div class="flex">
                            <div class="w-28">{{ $wip_domain->domain_id }}</div>
                            <div class="w-40">{{ $wip_domain->domain_short_name }}</div> 
                            <div class="w-64">{{ $wip_domain->domain_display_name }}</div> 
                            <div class="">{{ $wip_domain->domain_active }}</div> 
                        </div>
                    </x-wip-domain-collection>
                @endforeach
            @else
                <div>データがありません</div>
            @endif
        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>