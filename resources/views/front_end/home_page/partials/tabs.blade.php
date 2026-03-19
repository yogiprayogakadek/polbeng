<div class="row g-4">
    @if ($totalProjects->count() > 0)
        @php
            $categoryImages = [
                'Aplikasi Web' => '1498050108023-c5249f4df085',
                'Aplikasi Mobile' => '1512941937669-90bcdf591782',
                'Keamanan Siber' => '1550751827-4bd374c3f58b',
                '3D Aset' => '1616469829581-73993eb86b02',
                'Animasi 2D 3D' => '1550745165-9bc0b252726f',
                'Motion Graphic' => '1558655146-d09347e92766',
                'Augmented Reality' => '1478416272538-5f7e51dc5400',
                'Virtual Reality' => '1592477342004-bd7ba780f2b3',
                'Game' => '1493711662062-fa541adb3fc8',
                'ERP & Pengembangan Aplikasi' => '1460925895917-afdab827c52f',
                'Data Mining' => '1551288049-bbda48336202',
                'Desain Grafis' => '1626785774573-4b799315f30d',
                'Ilustrasi' => '1618005182384-a83a8bd57fbe',
                'Video Live-Action' => '1492724441997-5dc865305da7',
                'Concept Art' => '1605301091855-d60dec69e8bb',
            ];
        @endphp
        @foreach ($totalProjects as $category)
            <div class="col-xl-3 col-lg-4 col-md-6 animate__animated animate__fadeInUp">
                <div class="category-card h-100">
                    <div class="position-relative" style="height: 180px; overflow: hidden;">
                        @php
                            $photoId = $categoryImages[$category->project_category_name] ?? '1451187580459-43490279c0fa'; // Default tech image
                            $imageUrl = "https://images.unsplash.com/photo-{$photoId}?auto=format&fit=crop&w=500&q=80";
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $category->project_category_name }}"
                            class="w-100 h-100 object-fit-cover transition-all" style="transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                        <span class="category-badge shadow-sm">{{ $category->total }} Projects</span>
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
        <div class="col-12 py-5 text-center animate__animated animate__fadeIn">
            <div class="py-5">
                <iconify-icon icon="solar:folder-error-bold-duotone" class="text-muted mb-3"
                    style="font-size: 5rem;"></iconify-icon>
                <h4 class="fw-bold text-muted">No Projects Yet</h4>
                <p class="text-muted mx-auto" style="max-width: 400px;">
                    Our students are currently crafting amazing projects in this department. Stay tuned for future
                    innovations!
                </p>
            </div>
        </div>
    @endif
</div>
