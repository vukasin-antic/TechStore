@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Strelica za nazad --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a></li>
        @endif

        {{-- Logika za izračunavanje raspona brojeva --}}
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
            $onEachSide = 1; // Broj elemenata levo i desno od trenutnog

            $start = $current - $onEachSide;
            $end = $current + $onEachSide;

            // Korekcija ako smo na prvoj ili drugoj stranici (prikazuje 1 2 3)
            if ($current <= 2) {
                $end = 3;
            }
            // Korekcija ako smo na poslednjoj ili pretposlednjoj (prikazuje npr. 18 19 20)
            if ($current >= $last - 1) {
                $start = $last - 2;
            }

            // Osiguravamo da ne idemo ispod 1 ili iznad poslednje stranice
            $start = max(1, $start);
            $end = min($last, $end);
        @endphp

        {{-- Prva stranica i tačkice sa leve strane --}}
        @if ($start > 1)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @if ($start > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endif

        {{-- Brojevi u sredini (na osnovu $start i $end) --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
                <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor

        {{-- Tačkice sa desne strane i poslednja stranica --}}
        @if ($end < $last)
            @if ($end < $last - 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($last) }}">{{ $last }}</a></li>
        @endif

        {{-- Strelica za napred --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
        @endif
    </ul>
@endif
