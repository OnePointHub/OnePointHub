@section('title', __('Confirm Password'))

<x-auth-card>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    @include('errors.messages')

    <x-form wire:submit="confirmPassword">
        <x-form.input wire:model="password" type="password" :label="__('Password')" name="password" />
        <x-button class="justify-center w-full">{{ __('Confirm') }}</x-button>
    </x-form>

</x-auth-card>
