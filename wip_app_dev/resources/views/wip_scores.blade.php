<x-app-layout>
    <x-slot name='header'>
        <x-wip-header-menu></x-wip-header-menu>
    </x-slot>
    <x-errors id="errors" class='bg-blue-500 roundted-lg'>{{ $errors }}</x-errors>

    <!-- ####### ALL_AREA::START ########-->
    <div class="flex bg-gray-100">
        <!-- ######## LEFT_AREA::START ########## -->
        <div class="text-indigo-800 text-left px-4 py-4 mg-2">

        </div>
        <!-- ######## LEFT_AREA::END ########## -->
        <!-- ######## RIGHT_AREA::START ########## -->

        <div class="flex-1 text-gray-700 text-left bg-gray-100 px-1 py-1 m-1">
            <div class="flex flox-grow">
                <div class="w-auto flex">
                    <div class="w-64 underline font-bold text-blue-800 align-text-bottom">ユーザーID</div>
                    <div class="w-60 underline font-bold text-blue-800 align-text-bottom">DOC ID</div>
                    <div class="w-24 underline font-bold text-blue-800">TIME</div>
                    <div class="w-20 underline font-bold text-blue-800">WHO</div>
                    <div class="w-20 underline font-bold text-blue-800">B_WHN</div>
                    <div class="w-20 underline font-bold text-blue-800">F_WHN</div>
                    <div class="w-20 underline font-bold text-blue-800">U_WHN</div>
                    <div class="w-20 underline font-bold text-blue-800">A_WHR</div>
                    <div class="w-20 underline font-bold text-blue-800">I_WHR</div>
                    <div class="w-20 underline font-bold text-blue-800">F_WHR</div>
                    <div class="w-20 underline font-bold text-blue-800">T_WHR</div>
                    <div class="w-20 underline font-bold text-blue-800">HOW</div>
                    <div class="w-20 underline font-bold text-blue-800">HW_MC</div>
                    <div class="w-20 underline font-bold text-blue-800">HW_MY</div>
                    <div class="w-20 underline font-bold text-blue-800">WHAT</div>
                    <div class="w-20 underline font-bold text-blue-800">WHY</div>
                </div>
                <div class=""></div>
            </div>
            @if (count($wip_scores) > 0)
                @foreach ($wip_scores as $wip_score)
                    <x-wip-score-collection id="{{ $wip_score->score_id }}">
                        <div class="flex">
                            <div class="w-60">{{ $wip_score->user_id }}</div>
                            <div class="w-60">{{ $wip_score->doc_id }}</div>
                            <div class="w-24">{{ $wip_score->time }}</div>
                            <div class="w-20">{{ $wip_score->who_to_do }}</div>
                            <div class="w-20">{{ $wip_score->by_when }}</div>
                            <div class="w-20">{{ $wip_score->from_when }}</div>
                            <div class="w-20">{{ $wip_score->until_when }}</div>
                            <div class="w-20">{{ $wip_score->at_where }}</div>
                            <div class="w-20">{{ $wip_score->in_where }}</div>
                            <div class="w-20">{{ $wip_score->from_where }}</div>
                            <div class="w-20">{{ $wip_score->to_where }}</div>
                            <div class="w-20">{{ $wip_score->how_to_do }}</div>
                            <div class="w-20">{{ $wip_score->how_much }}</div>
                            <div class="w-20">{{ $wip_score->how_many }}</div>
                            <div class="w-20">{{ $wip_score->what_to_do }}</div>
                            <div class="w-20">{{ $wip_score->why }}</div>
                        </div>
                    </x-wip-score-collection>
                @endforeach
            @else
                <div>データがありません</div>
            @endif
        </div>
        <!-- ######## RIGHT_AREA::END ########## -->

    </div>
    <!-- ####### ALL_AREA::END ########-->







</x-app-layout>