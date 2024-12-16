<x-guest-layout>
    <x-authentication-card>


        <x-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row d-flex flex-column">
                <div class="row">
                    <x-slot name="logo">
                        <x-authentication-card-logo/>
                    </x-slot>
                </div>
                <div>
                    <x-label for="email" value="{{ __('Email') }}"/>
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required autofocus autocomplete="username"/>
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}"/>
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="current-password"/>
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

            </div>
            <div class="flex justify-end mt-4 flex-column">
                <div class="row flex-row-reverse justify-content-between">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           href="{{ route('password.request') }}">
                            {{ __('رمز خود را فراموش کرده اید؟') }}
                        </a>
                    @endif
                        <x-button class="ml-4 btn">
                            {{ __('ورود') }}
                        </x-button>
                </div>


            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>