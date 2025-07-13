<div class="row g-4">
    @if ($totalProjects->count() > 0)
        @foreach ($totalProjects as $category)
            <div class="col-xl-3 col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                <div class="category-card bg-white shadow-sm h-100">
                    <div class="position-relative" style="height: 180px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="{{ $category->project_category_name }}" class="w-100 h-100 object-fit-cover">
                        <span class="category-badge">{{ $category->total }} Projects</span>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-3">{{ $category->project_category_name }}</h5>
                        <a href="{{ route('frontend.project.index', $category->uuid) }}"
                            class="btn btn-outline-primary stretched-link">
                            View Projects
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12 py-5 text-center">
            <div class="alert alert-info">
                <iconify-icon icon="mdi:information-outline" class="me-2"></iconify-icon>
                No project categories found for this department
            </div>
        </div>
    @endif
</div>
