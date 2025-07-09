@section('title', __('Register'))

<x-auth-card>

    @include('errors.messages')

    <x-form wire:submit="register">

        <x-form.input
            wire:model="name"
            type="text"
            :label="__('Name')"
            name="name"
        >
            {{ old('name') }}
        </x-form.input>
        <x-form.input
            wire:model="email"
            type="email"
            :label="__('Email')"
            name="email"
        >
            {{ old('email') }}
        </x-form.input>
        <x-form.input
            wire:model="password"
            type="password"
            :label="__('Password')"
            name='password'
        />
        <x-form.input
            wire:model="password_confirmation"
            type="password"
            :label="__('Confirm Password')"
            name='confirmPassword'
        />

        <div class="flex items-center justify-end mt-4">
            <p>
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="pt-2 mr-5 underline"
                >
                    {{ __('Already registered?') }}
                </a>
            </p>
            <x-button>{{ __('Register') }}</x-button>
        </div>

    </x-form>

</x-auth-card>
