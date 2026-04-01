@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-6">
        {{-- Mobile --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 border border-slate-200 bg-slate-50 text-slate-400 text-xs font-semibold cursor-not-allowed">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold transition-colors">Anterior</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold transition-colors">Siguiente</a>
            @else
                <span class="px-3 py-1.5 border border-slate-200 bg-slate-50 text-slate-400 text-xs font-semibold cursor-not-allowed">Siguiente</span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
            <div>
                <p class="text-xs text-slate-500">
                    Mostrando
                    <span class="font-semibold text-slate-700">{{ $paginator->firstItem() }}</span>
                    –
                    <span class="font-semibold text-slate-700">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex border border-slate-200" style="border-radius:0">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-3 py-1.5 border-r border-slate-200 text-xs text-slate-400 cursor-not-allowed select-none">&#8249;</span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 border-r border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition-colors">&#8249;</a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-1.5 border-r border-slate-200 text-xs text-slate-400">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-3 py-1.5 border-r border-slate-200 text-xs font-bold bg-indigo-600 text-white">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 border-r border-slate-200 text-xs text-slate-600 hover:bg-slate-50 hover:text-indigo-600 font-semibold transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50 transition-colors">&#8250;</a>
                    @else
                        <span class="px-3 py-1.5 text-xs text-slate-400 cursor-not-allowed select-none">&#8250;</span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
