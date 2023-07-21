<div class="flex">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('user_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-blue-800 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">ユーザー<br>管理</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('domain_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-green-800 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">組織<br>管理</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('group_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-yellow-800 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">グループ<br>管理</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('user_profile_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-purple-800 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">ユーザー<br>属性管理</button>
        </form>
    </h2>
    <div class="px-2">|</div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('chat_system_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-gray-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">チャット<br>システム</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight px-2">
        <form action="<?= route('perm_group_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-gray-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">権限<br>グループ</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight w-36">
        <form action="<?= route('user_group_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-gray-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">ユーザー<br>グループ</button>
        </form>
    </h2>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight w-36">
        <form action="<?= route('supervisor_group_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-gray-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">監督<br>グループ</button>
        </form>
    </h2>
    <div class="px-2">|</div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight w-36">
        <form action="<?= route('score_index') ?>" method="GET" class="w-full max-w-lg">
            <button type="submit" class="bg-red-800 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">スコア</button>
        </form>
    </h2>

</div>