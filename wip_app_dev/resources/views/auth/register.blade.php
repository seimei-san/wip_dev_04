
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        

        <!-- wip_id -->
        <!-- <div> -->
            <!-- <x-input-label for="wip_id" :value="__('WIP ID')" /> -->
            <!-- <x-text-input id="wip_id" class="block mt-1 w-full" type="text" name="wip_id" :value="old('wip_id')" required autofocus /> -->
            <!-- <x-input-error :messages="$errors->get('wip_id')" class="mt-2" /> -->
        <!-- </div> -->

        <!-- domain_id -->
        <!-- <div> -->
            <!-- <x-input-label for="domain_id" :value="__('Domain ID')" /> -->
            <x-text-input id="domain_id" class="block mt-1 w-full" type="hidden" name="domain_id" value="(NONE)" required autofocus />
            <!-- <x-input-error :messages="$errors->get('domain_id')" class="mt-2" /> -->
        <!-- </div>      -->

        <!-- user_active -->
        <!-- <div> -->
            <!-- <x-input-label for="user_active" :value="__('Active')" /> -->
            <x-text-input id="user_active" class="block mt-1 w-full" type="hidden" name="user_active" value=0 />
            <!-- <x-text-input id="user_active" class="block mt-1 w-full" type="checkbox" name="user_active" value=1 required autofocus /> -->
            <!-- <x-input-error :messages="$errors->get('user_active')" class="mt-2" /> -->
        <!-- </div>      -->

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
