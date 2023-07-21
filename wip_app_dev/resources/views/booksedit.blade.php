<x-app-layout>
    <!-- HEADER::START -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <form action="{{ route('book_index') }}" method="GET" class="w-full max-w-lg">
                <x-button class="bg-gray-100 text-gray-900">{{ __('Dashboard') }}：更新画面</x-button>
            </form>
        </h2>
    </x-slot>
    <!-- HEADER::END -->

    <x-errors id="errors" class="bg-blue-500 rounded-lg">{{$errors}}</x-errors>
    
    <!-- ALL_AREA::START -->
    <div class="flex bg-gray-100">
        <!-- LEFT_AREA::START -->
        <div class="text-gray-700 text-left px-4 py-4 m-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-500 font-bold">
                    本を管理する
                </div>
            </div>
            <form action="{{ url('books/update') }}" method="POST" class="w-full max-w-lg">
                @csrf
                <div class="flex flex-col px-2 py-2">
                    <!-- COL1 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Book Name
                        </label>
                        <input name="item_name" value="{{$book->item_name}}" class="appearance-none block w-full text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="">
                    </div>
                    <!-- COL2 -->
                    <div class="w-full md:w-1/1 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            金額
                        </label>
                        <input name="item_amount" value="{{$book->item_amount}}" class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="">
                    </div>
                    <!-- COL3 -->
                    <div class="w-full md:w-1/1 px-3 mb-2 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            数
                        </label>
                        <input name="item_number" value="{{$book->item_number}}" class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="">
                    </div>
                    <!-- COL4 -->
                    <div class="w-full md:w-1/1 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            発売日
                        </label>
                        <input name="published" type="datetime-local" value="{{$book->published}}" class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"  placeholder="">
                    </div>
                </div>
                <!-- COL5 -->
                <div class="flex flex-col">
                    <div class="text-gray-700 text-center px-4 py-2 m-2">
                        <x-button class="bg-blue-500 rounded-lg">更新</x-button>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$book->id}}">

            </form>
        </div>
        <!-- LEFT_AREA::END -->
        <!-- RIGHT_AREA::START -->
        <div class="flex-1 text-gray-700 text-left bg-blue-100 px-4 py-2 m-2">

        </div>
        <!-- RIGHT_AREA::END -->
    </div>
    <!-- ALL_AREA::EMD -->

</x-app-layout>