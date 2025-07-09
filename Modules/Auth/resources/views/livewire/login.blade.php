@section('title', __('Login'))

<x-auth-card>

    <x-form wire:submit="login">

        @include('errors.messages')

        <x-form.input wire:model="email" name="email" :label="__('Email')">{{ old('email') }}</x-form.input>
        <x-form.input wire:model="password" name="password" :label="__('Password')" type="password" />
        <x-form.checkbox wire:model="remember" name="remember" :label="__('Remember me')" />

        <div class="flex justify-between">
            @if (Route::has('password.request'))
                <p><a href="{{ route('password.request') }}" wire:navigate>{{ __('Forgot your password?') }}</a></p>
            @endif
            @if (Route::has('register'))
                <p><a href="{{ route('register') }}" wire:navigate>{{ __('Register') }}</a></p>
            @endif
        </div>

        <p>
            <x-button class="w-full justify-center">Login</x-button>
        </p>

    </x-form>

</x-auth-card>
