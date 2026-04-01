@props(['label', 'name', 'type' => 'text', 'placeholder' => '', 'required' => true, 'value' => null])

@php
    $inputValue = $value ?? old($name);
@endphp

<div>
    <label class="block text-sm font-semibold text-slate-700 mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $inputValue }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error($name) border-red-400 bg-red-50 @else border-slate-300 @enderror"
        style="border-radius:0"
    >
    @error($name)
        <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>
    @enderror
</div>
