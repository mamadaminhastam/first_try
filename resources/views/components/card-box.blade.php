@props([
'icon' => 'fas fa-box', // کلاس آیکون
'title' => 'Title',
'value' => '0',
'link' => null, // مسیر لینک (اختیاری)
'color' => 'primary' // primary, success, danger, warning, info
])

@php
$iconBgColor = match($color) {
'success' => 'bg-success',
'danger' => 'bg-danger',
'warning' => 'bg-warning text-dark',
'info' => 'bg-info',
default => 'bg-primary'
};
@endphp

<div class="card h-100">
    <div class="card-body d-flex align-items-center">
        <div class="rounded-circle {{ $iconBgColor }} p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
            <i class="{{ $icon }} text-white"></i>
        </div>
        <div>
            <div class="text-secondary small">{{ $title }}</div>
            <div class="fw-bold fs-5">{{ $value }}</div>
            @if($link)
            <a href="{{ $link }}" class="btn btn-sm btn-outline-light mt-1">View</a>
            @endif
        </div>
    </div>
</div>