@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-3 sm:gap-4 w-full my-8">

        {{-- Previous Page Button (Newer) --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-3.5 rounded-full bg-slate-100 dark:bg-slate-800/50 text-slate-400 dark:text-slate-600 font-bold cursor-not-allowed transition-all shadow-inner">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden sm:block text-sm sm:text-base">Newer</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="group flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-3.5 rounded-full bg-white dark:bg-slate-800 text-brand font-bold shadow-[0_8px_20px_rgba(249,115,22,0.1)] dark:shadow-[0_8px_20px_rgba(0,0,0,0.3)] hover:shadow-[0_12px_25px_rgba(249,115,22,0.25)] dark:hover:shadow-[0_12px_25px_rgba(249,115,22,0.15)] border border-slate-100 dark:border-slate-700 hover:border-brand/30 dark:hover:border-brand/30 hover:-translate-y-1 hover:bg-brand-light/30 dark:hover:bg-brand/10 transition-all duration-300">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden sm:block text-sm sm:text-base">Newer</span>
            </a>
        @endif

        {{-- Page Numbers (Desktop) --}}
        <div class="hidden md:flex items-center gap-1.5 bg-white dark:bg-slate-800 p-1.5 rounded-full shadow-[0_8px_20px_rgba(0,0,0,0.04)] dark:shadow-[0_8px_20px_rgba(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/80">
            @foreach ($elements as $element)
                {{-- Ellipsis --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="w-10 h-10 flex items-center justify-center text-slate-400 dark:text-slate-500 font-bold tracking-widest">
                        {{ $element }}
                    </span>
                @endif

                {{-- Page Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="w-11 h-11 flex items-center justify-center rounded-full bg-gradient-to-tr from-brand to-yellow-400 text-white font-black shadow-[0_8px_15px_rgba(249,115,22,0.4)] transform scale-110 transition-all cursor-default relative z-10">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-transparent text-slate-600 dark:text-slate-400 font-bold hover:bg-brand/10 hover:text-brand dark:hover:bg-brand/20 transition-all duration-300 text-sm hover:scale-110">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Page Indicator (Mobile) --}}
        <div class="md:hidden flex items-center px-6 py-3 bg-white dark:bg-slate-800 rounded-full shadow-[0_8px_20px_rgba(0,0,0,0.04)] dark:shadow-[0_8px_20px_rgba(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/80 font-black text-slate-700 dark:text-slate-300 text-sm tracking-wide">
            {{ $paginator->currentPage() }} <span class="mx-1.5 text-slate-400 font-medium">/</span> {{ $paginator->lastPage() }}
        </div>

        {{-- Next Page Button (Older) --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="group flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-3.5 rounded-full bg-white dark:bg-slate-800 text-brand font-bold shadow-[0_8px_20px_rgba(249,115,22,0.1)] dark:shadow-[0_8px_20px_rgba(0,0,0,0.3)] hover:shadow-[0_12px_25px_rgba(249,115,22,0.25)] dark:hover:shadow-[0_12px_25px_rgba(249,115,22,0.15)] border border-slate-100 dark:border-slate-700 hover:border-brand/30 dark:hover:border-brand/30 hover:-translate-y-1 hover:bg-brand-light/30 dark:hover:bg-brand/10 transition-all duration-300">
                <span class="hidden sm:block text-sm sm:text-base">Older</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-3.5 rounded-full bg-slate-100 dark:bg-slate-800/50 text-slate-400 dark:text-slate-600 font-bold cursor-not-allowed transition-all shadow-inner">
                <span class="hidden sm:block text-sm sm:text-base">Older</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif

    </nav>
@endif
