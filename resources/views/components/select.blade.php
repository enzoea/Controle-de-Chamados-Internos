@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) }}>
    {{ $slot }}
</select>
