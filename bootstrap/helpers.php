<?php

use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (! function_exists('toast')) {
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function toast(string $type, string $message, ?RedirectResponse $response = null)
    {
        $toasts = session()->get('toasts', []);
        $toasts[] = [
            'id' => Str::uuid(),
            'type' => $type,
            'message' => $message,
        ];
        if ($response) {
            return $response->with('toasts', $toasts);
        } else {
            session()->flash('toasts', $toasts);
        }
    }
}
