@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'rounded-md shadow-sm
                border border-white/20
                bg-transparent text-inherit
                focus:outline-none focus:ring-0'
    ]) !!}
>