@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link">Previous</span></li>
        @else
        <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="disabled page-item" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}" class = "page-item"><span class="page-link">{{ $page }}</span></a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a></li>
        @else
        <li class="page-item disabled"><span class="page-link">Next</span></li>
        @endif
    </ul>
</nav>
@endif