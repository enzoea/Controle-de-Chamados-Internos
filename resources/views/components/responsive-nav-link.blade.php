@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-3 text-start text-base font-semibold text-[#d72638] transition duration-150 ease-in-out hover:text-[#251b1e] focus:text-[#251b1e] focus:outline-none'
            : 'block w-full px-4 py-3 text-start text-base font-medium text-[#251b1e] transition duration-150 ease-in-out hover:text-[#d72638] focus:text-[#d72638] focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
