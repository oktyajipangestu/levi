<x-guest-layout>
    <div class="flex w-full h-screen">
         <p class="text-white text-xl absolute top-16 left-16 font-light"><strong><em>Assure your confidence</em></strong></p>
        <div class="fixed left-0 bottom-8 ">
            <img class="opacity-40 w-full" src="{{ asset('images/image-login-min.png') }}" alt="" srcset="">
        </div>
        <div class="w-2/3 grid-rows-2 bg-primary p-10">
            <div class="row py-20"></div>
            <div class="row py-20 ps-40 text-white">
                <h1 class="text-5xl font-extrabold"><em>LEVI</em></h2>
                <h2 class="text-3xl font-bold"><em>Leave and Overtime Input</em></h4>
            </div>
        </div>
        <div class="w-full flex items-center justify-center">
            <div class="flex flex-col justify-start w-1/2">
                <img class="w-28 my-12" src="{{ asset('images/logo.png') }}" alt="">
                <p class="font-bold text-xl mb-2">Welcome Back!</p>
                <h3 class="font-bold text-3xl">Please Login.</h3>
                <form class="my-12" method="POST" action="{{ route('signin') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Username')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        required autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    {{-- <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div> --}}

                    <div class="flex items-center justify-end mt-4">
                        <button class="w-full text-center bg-primary py-3 rounded-lg text-white font-bold my-3" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
