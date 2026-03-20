@php
    $icon = $icon ?? 'solar:gallery-wide-bold-duotone';
    $title = $title ?? 'No Results Found';
    $description = $description ?? "We couldn't find what you're looking for. Try adjusting your search or filters.";
    $actionUrl = $actionUrl ?? null;
    $actionText = $actionText ?? null;
@endphp

<div class="empty-state-wrapper py-5 px-4 text-center animate__animated animate__fadeIn">
    <div class="glass-panel d-inline-block p-5 rounded-5 border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div class="icon-container mb-4 position-relative d-inline-block">
            <div class="icon-blob position-absolute top-50 start-50 translate-middle" 
                 style="width: 120px; height: 120px; background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%); z-index: 0;"></div>
            <iconify-icon icon="{{ $icon }}" class="display-1 text-primary position-relative z-1" 
                          style="filter: drop-shadow(0 10px 15px rgba(59, 130, 246, 0.2));"></iconify-icon>
        </div>
        
        <h3 class="fw-bold text-dark mt-2 mb-2 tracking-tight">{{ $title }}</h3>
        <p class="text-muted mb-4 mx-auto" style="max-width: 400px; line-height: 1.6;">
            {{ $description }}
        </p>
        
        @if($actionUrl && $actionText)
            <a href="{{ $actionUrl }}" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm transition-all hover-scale">
                {{ $actionText }}
            </a>
        @endif
    </div>
</div>

<style>
    .empty-state-wrapper .glass-panel {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .empty-state-wrapper:hover .glass-panel {
        transform: translateY(-5px);
    }
    .hover-scale {
        transition: all 0.3s ease;
    }
    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.25) !important;
    }
</style>
