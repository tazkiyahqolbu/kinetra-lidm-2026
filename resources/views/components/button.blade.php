<button class="px-6 py-3 rounded-lg font-semibold transition duration-300 flex items-center justify-center space-x-2
    @if($variant === 'secondary')
        bg-emerald-500 hover:bg-emerald-600 text-white
    @elseif($variant === 'danger')
        bg-red-600 hover:bg-red-700 text-white
    @elseif($variant === 'ghost')
        bg-transparent border-2 border-blue-600 text-blue-600 hover:bg-blue-50
    @else
        bg-blue-600 hover:bg-blue-700 text-white
    @endif
    {{ $class ?? '' }}
" {{ $attributes }}>
    @if($icon ?? false)
        <span>{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
