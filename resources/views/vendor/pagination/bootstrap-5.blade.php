@if ($paginator->hasPages())
    <div class="sena-pagination">
        <div class="sena-pagination-info">
            <span>
                Mostrando <strong>{{ $paginator->firstItem() }}</strong>
                a <strong>{{ $paginator->lastItem() }}</strong>
                de <strong>{{ $paginator->total() }}</strong> resultados
            </span>
        </div>

        <div class="sena-pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="sena-page sena-page-disabled" aria-disabled="true">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="sena-page" rel="prev">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="sena-page sena-page-disabled" aria-disabled="true">...</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="sena-page sena-page-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="sena-page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="sena-page" rel="next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="sena-page sena-page-disabled" aria-disabled="true">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
@endif
