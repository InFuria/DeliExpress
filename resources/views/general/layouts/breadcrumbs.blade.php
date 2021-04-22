@if (count($breadcrumbs))
    <nav class="card rounded shadow-e-sm border-0 ml-3" style="height: 50px; max-width: 82%; width: 82%">
        <ol class="breadcrumb bg-white" style="margin-bottom: 0 !important; height: 100% !important;align-items: center !important;">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-item breadcrumb-title breadcrumb-inactive" href="{{ $breadcrumb->url }}" style="margin-right: 0 !important;">
                            <span class="material-icons breadcrumb-icon breadcrumb-inactive" style="margin-right: 0.5rem !important; margin-left: 0">{{ $breadcrumb->icon }}</span>

                            <label class="breadcrumb-inactive">{{ $breadcrumb->title }}</label>
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active d-flex align-items-center justify-content-center">
                        <span class="material-icons breadcrumb-icon breadcrumb-active">
                            {{ $breadcrumb->icon }}
                        </span>
                        <label class="breadcrumb-title breadcrumb-active">{{ $breadcrumb->title }}</label>
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endif

