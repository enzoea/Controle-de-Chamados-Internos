@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'field-base']) }}>{{ $slot }}</textarea>
