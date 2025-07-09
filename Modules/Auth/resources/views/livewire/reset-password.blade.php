@section('title', __('Reset Password'))

<x-auth-card>

    <x-form wire:submit="resetPassword">

        @include('errors.messages')

        <x-form.input wire:model="email" name="email" :label="__('Email')"/>
        <x-form.input wire:model="password" type="password" name="password" :label="__('Password')" />
        <x-form.input wire:model="password_confirmation" type="password" name='password_confirmation' :label="__('Confirm Password')" />
        <x-button>{{ __('Reset Password') }}</x-button>

    </x-form>

</x-auth-card>
