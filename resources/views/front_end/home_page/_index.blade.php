@extends('front_end.template.master')

@section('page-title', 'PBL Excellence - Showcase')

@push('css')
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        brand: {
                            light: '#8B5CF6',
                            dark: '#6D28D9',
                        }
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            scroll-behavior: smooth;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .text-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-brand {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }

        .video-container {
            perspective: 1000px;
        }

        .video-inner {
            transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            transform-style: preserve-3d;
        }

        .video-container:hover .video-inner {
            transform: rotateX(5deg) rotateY(-5deg);
        }

        #search-results-dropdown {
            display: none;
            max-height: 400px;
            overflow-y: auto;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.5);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endpush

@section('content')
    <div class="relative overflow-hidden bg-slate-50 selection:bg-indigo-100 selection:text-indigo-900">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Hero Section -->
        <section class="relative z-10 pt-20 pb-32 lg:pt-32 lg:pb-48">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="w-full lg:w-1/2 space-y-8">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-full text-indigo-600 text-sm font-semibold tracking-wide uppercase animate-fade-in">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                            <span>Project-Based Learning Showcase</span>
                        </div>
                        
                        <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight tracking-tight text-slate-900">
                            Where <span class="text-gradient">Ideas</span> Meet <span class="relative">
                                Innovation
                                <svg class="absolute -bottom-2 left-0 w-full h-3 text-indigo-400/30" viewBox="0 0 100 12" preserveAspectRatio="none">
                                    <path d="M0 10c20-5 40-5 60-5s40 5 40 5" stroke="currentColor" stroke-width="8" fill="none" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </h1>
                        
                        <p class="text-lg lg:text-xl text-slate-600 leading-relaxed max-w-xl font-medium">
                            Explore a collection of inspiring IT projects showcased in our Project-Based Learning exhibitions since 2020. 
                            From mobile apps to IoT, witness the future built by students.
                        </p>

                        <!-- Search Bar -->
                        <div class="relative max-w-lg group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                            <div class="relative flex items-center bg-white rounded-2xl shadow-xl overflow-hidden p-1 border border-slate-100">
                                <div class="pl-5 pr-3 text-slate-400">
                                    <iconify-icon icon="solar:magnifer-linear" width="24" height="24"></iconify-icon>
                                </div>
                                <input type="text" id="global-search-input" 
                                    class="w-full py-4 text-slate-700 placeholder-slate-400 focus:outline-none font-medium bg-transparent"
                                    placeholder="Search projects, teams, tech...">
                                <div id="search-results-dropdown" class="absolute top-full left-0 right-0 mt-4 bg-white/90 backdrop-blur-xl border border-slate-100 rounded-2xl shadow-2xl z-50 overflow-hidden hidden"></div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#projects" class="px-8 py-4 bg-gradient-brand text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transform transition-all hover:-translate-y-1 active:scale-95">
                                Discover More
                            </a>
                            <a href="#contact" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
                                Get Involved
                            </a>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 relative">
                        <div class="video-container group">
                            <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 rounded-[2.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                            <div class="video-inner relative rounded-4xl overflow-hidden shadow-2xl border-4 border-white aspect-video bg-slate-900 group">
                                @php
                                    $thumbnailUrl = 'https://img.youtube.com/vi/omgUq6hwrdw/maxresdefault.jpg';
                                @endphp
                                <div id="player" class="absolute inset-0 w-full h-full hidden"></div>
                                <div id="video-poster" class="absolute inset-0 w-full h-full bg-cover bg-center cursor-pointer group"
                                    style="background-image: url('{{ $thumbnailUrl }}')">
                                    <div class="absolute inset-0 bg-indigo-900/40 mix-blend-multiply group-hover:bg-indigo-900/20 transition-all"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl transform transition-all group-hover:scale-110 group-active:scale-90">
                                            <iconify-icon icon="solar:play-bold" width="32" height="32" class="text-indigo-600 ml-1"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Badges -->
                        <div class="absolute -bottom-8 -left-8 glass p-4 rounded-2xl shadow-xl animate-float">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                    <iconify-icon icon="solar:check-circle-bold" width="24" height="24"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Projects</p>
                                    <p class="text-lg font-extrabold text-slate-900">{{ $stats['total'] }}+</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-8 -right-8 glass p-4 rounded-2xl shadow-xl animate-float animation-delay-1500">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                    <iconify-icon icon="solar:users-group-rounded-bold" width="24" height="24"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Active Teams</p>
                                    <p class="text-lg font-extrabold text-slate-900">50+</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Grid Section -->
        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row justify-between items-end gap-8 mb-16">
                    <div class="max-w-2xl space-y-4">
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight">
                            Empowering Innovation <br>Through <span class="text-indigo-600">PBL</span>
                        </h2>
                        <p class="text-lg text-slate-500 font-medium">
                            Since 2020, our students have successfully delivered impactful IT projects, 
                            showcasing creativity and industry-ready skills.
                        </p>
                    </div>
                    <div>
                        <a href="#contact" class="inline-flex items-center text-indigo-600 font-bold group">
                            Explore our ecosystem
                            <iconify-icon icon="solar:arrow-right-linear" class="ml-2 group-hover:translate-x-1 transition-transform"></iconify-icon>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Stat Card 1 -->
                    <div class="group bg-slate-50 hover:bg-indigo-600 rounded-3xl p-8 transition-all duration-500 border border-slate-100 hover:border-indigo-600 shadow-sm hover:shadow-2xl hover:shadow-indigo-200">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                            <iconify-icon icon="solar:lightbulb-bolt-bold-duotone" width="32" height="32"></iconify-icon>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white">Innovative Solutions</h3>
                        <p class="text-slate-500 group-hover:text-indigo-50 font-medium">Real-world projects tackling current industry challenges.</p>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="group bg-slate-50 hover:bg-purple-600 rounded-3xl p-8 transition-all duration-500 border border-slate-100 hover:border-purple-600 shadow-sm hover:shadow-2xl hover:shadow-purple-200">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <iconify-icon icon="solar:users-group-two-rounded-bold-duotone" width="32" height="32"></iconify-icon>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white">Collaboration</h3>
                        <p class="text-slate-500 group-hover:text-purple-50 font-medium">Multidisciplinary teams working towards common goals.</p>
                    </div>

                    <!-- Stat Card 3 -->
                    <div class="group bg-slate-50 hover:bg-pink-600 rounded-3xl p-8 transition-all duration-500 border border-slate-100 hover:border-pink-600 shadow-sm hover:shadow-2xl hover:shadow-pink-200">
                        <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                            <iconify-icon icon="solar:layers-bold-duotone" width="32" height="32"></iconify-icon>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white">Diverse Scope</h3>
                        <p class="text-slate-500 group-hover:text-pink-50 font-medium">IT, Multimedia, IoT, Networking, and many more.</p>
                    </div>

                    <!-- Stat Card 4 -->
                    <div class="group bg-slate-50 hover:bg-blue-600 rounded-3xl p-8 transition-all duration-500 border border-slate-100 hover:border-blue-600 shadow-sm hover:shadow-2xl hover:shadow-blue-200">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <iconify-icon icon="solar:chart-square-bold-duotone" width="32" height="32"></iconify-icon>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white">Industry Focused</h3>
                        <p class="text-slate-500 group-hover:text-blue-50 font-medium">Aligned with real-world business and social needs.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Explorer Section -->
        <section class="py-24 bg-slate-50" id="projects">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900">Explore by Department</h2>
                    <p class="text-lg text-slate-500 font-medium">Browse through our diverse collection of student projects across different faculties and programs.</p>
                </div>

                <!-- Horizontal Tabs -->
                <div class="flex overflow-x-auto pb-4 no-scrollbar -mx-6 px-6">
                    <div class="flex space-x-4">
                        @foreach ($departments as $index => $department)
                            <button 
                                class="tab-btn whitespace-nowrap px-8 py-5 rounded-2xl font-bold text-lg flex items-center space-x-3 transition-all transform hover:-translate-y-1 {{ $index === 0 ? 'active' : 'bg-white text-slate-600 border border-slate-200 shadow-sm' }}"
                                id="tab-{{ $department->id }}"
                                data-url="{{ route('frontend.project.category', $department->id) }}"
                                data-department-id="{{ $department->id }}">
                                <iconify-icon icon="{{ $department->icon ?? 'solar:case-round-bold' }}" width="24" height="24"></iconify-icon>
                                <span>{{ $department->department_name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Tab Content Container -->
                <div id="departments-tabContent" class="mt-12 min-h-[400px]">
                    {{-- AJAX Content --}}
                    <div class="flex items-center justify-center py-20">
                        <div class="relative w-12 h-12">
                            <div class="absolute inset-0 border-4 border-indigo-200 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <!-- YouTube API & GLightbox -->
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    
    <script>
        let player;
        const videoId = 'omgUq6hwrdw';
        const videoPoster = document.getElementById('video-poster');

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '100%', width: '100%', videoId: videoId,
                playerVars: { 'autoplay': 0, 'controls': 1, 'rel': 0, 'modestbranding': 1 },
                events: { 'onReady': (e) => {
                    videoPoster.addEventListener('click', () => {
                        videoPoster.classList.add('opacity-0', 'pointer-events-none');
                        document.getElementById('player').classList.remove('hidden');
                        player.playVideo();
                    });
                }}
            });
        }

        $(document).ready(function() {
            const lightbox = GLightbox({ selector: '.glightbox', touchNavigation: true });

            // Search Logic
            let searchTimeout;
            $('#global-search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val().trim();
                const dropdown = $('#search-results-dropdown');
                if (query.length < 2) { dropdown.hide().empty(); return; }
                searchTimeout = setTimeout(() => {
                    $.get("{{ route('frontend.global.search') }}", { query: query }, (res) => {
                        dropdown.html(res.html).fadeIn(200);
                    });
                }, 300);
            });

            $(document).on('click', (e) => {
                if (!$(e.target).closest('.group').length) $('#search-results-dropdown').fadeOut(200);
            });

            // Tabs Logic
            function loadDept(id) {
                const container = $('#departments-tabContent');
                container.html(`
                    <div class="flex items-center justify-center py-20">
                        <div class="relative w-12 h-12">
                            <div class="absolute inset-0 border-4 border-indigo-200 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
                        </div>
                    </div>
                `);
                
                $.get('homepage/project-category/' + id, (res) => {
                    container.hide().html(res.html).fadeIn(500);
                });
            }

            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active bg-gradient-brand text-white shadow-lg shadow-indigo-200')
                            .addClass('bg-white text-slate-600 border border-slate-200 shadow-sm');
                $(this).addClass('active bg-gradient-brand text-white shadow-lg shadow-indigo-200')
                       .removeClass('bg-white text-slate-600 border border-slate-200 shadow-sm');
                loadDept($(this).data('department-id'));
            });

            // Initial Load
            loadDept($('.tab-btn').first().data('department-id'));
        });
    </script>
@endpush
