<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">{{ $title }}</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @foreach($breadcrumbs as $label => $url)
            @if($loop->last)
                <li class="breadcrumb-item active text-white">{{ $label }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
            @endif
        @endforeach
    </ol>
</div>
