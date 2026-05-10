@extends('front_end.template.master')

@section('page-title', 'PBL Excellence - Showcase')

@push('css')
    <!-- Tailwind CSS Play CDN with important: true to override Bootstrap -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: true,
            corePlugins: {
                preflight: false, // Disable preflight to avoid breaking Bootstrap Header/Footer
            },
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
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Manually apply Outfit font to tailwind elements to avoid font-reset issues */
        .tw-scope {
            font-family: 'Outfit', sans-serif !important;
        }
        
        .tw-scope h1, .tw-scope h2, .tw-scope h3, .tw-scope h4 {
            margin: 0;
            line-height: 1.2;
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

        #search-results-dropdown {
            display: none;
            max-height: 400px;
            overflow-y: auto;
            z-index: 9999;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%) !important;
            color: white !important;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.5) !important;
        }
        
        /* Fix Bootstrap conflicts */
        .tw-scope .row { margin: 0; }
        .tw-scope .container { max-width: none; padding: 0; }
    </style>
@endpush

@section('content')
    <div class="tw-scope relative overflow-hidden bg-slate-50">
        <!-- Background Decorative Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <!-- Hero Section -->
        <section class="relative pt-16 pb-24 lg:pt-24 lg:pb-32">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                    <div class="flex-1 space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-slate-100 text-indigo-600 text-sm font-bold tracking-wide uppercase">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 mr-2 animate-pulse"></span>
                            Showcase Excellence
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight text-slate-900 leading-[1.1]">
                            Where <span class="text-gradient">Ideas</span> <br>Meet <span class="text-indigo-600">Innovation</span>
                        </h1>
                        
                        <p class="text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Explore inspiring IT projects since 2020. Witness the future built by students through creativity and technology.
                        </p>

                        <!-- Search Bar -->
                        <div class="relative max-w-lg mx-auto lg:mx-0">
                            <div class="flex items-center bg-white rounded-2xl shadow-xl p-1 border border-slate-200">
                                <div class="pl-4 pr-2 text-slate-400">
                                    <iconify-icon icon="solar:magnifer-linear" width="24" height="24"></iconify-icon>
                                </div>
                                <input type="text" id="global-search-input" 
                                    class="w-full py-3 text-slate-700 placeholder-slate-400 border-0 focus:ring-0 font-medium bg-transparent"
                                    placeholder="Search projects, teams, tech...">
                                <div id="search-results-dropdown" class="absolute top-full left-0 right-0 mt-4 bg-white border border-slate-200 rounded-2xl shadow-2xl z-50 overflow-hidden hidden"></div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                            <a href="#projects" class="px-10 py-4 bg-gradient-brand text-white font-bold rounded-2xl shadow-lg hover:shadow-indigo-300 transform transition-all hover:-translate-y-1 no-underline">
                                Discover More
                            </a>
                            <a href="#contact" class="px-10 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all no-underline">
                                Get Involved
                            </a>
                        </div>
                    </div>

                    <div class="flex-1 relative w-full max-w-2xl mx-auto lg:max-w-none">
                        <div class="video-container relative rounded-3xl overflow-hidden shadow-2xl border-[6px] border-white aspect-video bg-slate-900">
                            @php $thumbnailUrl = 'https://img.youtube.com/vi/omgUq6hwrdw/maxresdefault.jpg'; @endphp
                            <div id="player" class="absolute inset-0 w-full h-full hidden"></div>
                            <div id="video-poster" class="absolute inset-0 w-full h-full bg-cover bg-center cursor-pointer flex items-center justify-center"
                                style="background-image: url('{{ $thumbnailUrl }}')">
                                <div class="absolute inset-0 bg-indigo-900/30 transition-all hover:bg-indigo-900/10"></div>
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl transform transition-transform hover:scale-110 active:scale-95">
                                    <iconify-icon icon="solar:play-bold" width="32" height="32" class="text-indigo-600 ml-1"></iconify-icon>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Stats -->
                        <div class="absolute -bottom-6 -right-6 bg-white p-5 rounded-2xl shadow-2xl hidden md:block border border-slate-100">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                    <iconify-icon icon="solar:check-circle-bold" width="28" height="28"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">Successful</p>
                                    <p class="text-xl font-black text-slate-800">{{ $stats['total'] }}+ Projects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $impacts = [
                            ['Innovative Solutions', 'Tackling industry challenges.', 'solar:lightbulb-bold-duotone', 'bg-blue-50', 'text-blue-600'],
                            ['Collaboration', 'Multidisciplinary team efforts.', 'solar:users-group-rounded-bold-duotone', 'bg-indigo-50', 'text-indigo-600'],
                            ['Diverse Scope', 'From AI to Digital Media.', 'solar:layers-bold-duotone', 'bg-purple-50', 'text-purple-600'],
                            ['Industry Focus', 'Real business & social needs.', 'solar:chart-square-bold-duotone', 'bg-pink-50', 'text-pink-600'],
                        ];
                    @endphp
                    @foreach ($impacts as $item)
                        <div class="p-8 bg-slate-50 rounded-[2rem] border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                            <div class="w-14 h-14 {{ $item[3] }} {{ $item[4] }} rounded-2xl flex items-center justify-center mb-6">
                                <iconify-icon icon="{{ $item[2] }}" width="32" height="32"></iconify-icon>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $item[0] }}</h3>
                            <p class="text-slate-500 font-medium">{{ $item[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Explorer Section -->
        <section class="py-24 bg-slate-50" id="projects">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16 space-y-4">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900">Explore Projects</h2>
                    <p class="text-lg text-slate-500 font-medium">Browse student projects across all departments</p>
                </div>

                <!-- Tabs -->
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    @foreach ($departments as $index => $department)
                        <button 
                            class="tab-btn px-6 py-4 bg-white border border-slate-200 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm flex items-center gap-3 {{ $index === 0 ? 'active' : '' }}"
                            id="tab-{{ $department->id }}"
                            data-department-id="{{ $department->id }}">
                            <iconify-icon icon="{{ $department->icon ?? 'solar:case-round-bold' }}" width="20" height="20"></iconify-icon>
                            <span>{{ $department->department_name }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Content -->
                <div id="departments-tabContent" class="min-h-[400px]">
                    <div class="flex items-center justify-center py-20">
                        <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '100%', width: '100%', videoId: 'omgUq6hwrdw',
                playerVars: { 'autoplay': 0, 'controls': 1 },
                events: { 'onReady': (e) => {
                    document.getElementById('video-poster').addEventListener('click', () => {
                        document.getElementById('video-poster').style.display = 'none';
                        document.getElementById('player').classList.remove('hidden');
                        player.playVideo();
                    });
                }}
            });
        }

        $(document).ready(function() {
            // Search
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

            // Tabs
            function loadDept(id) {
                const container = $('#departments-tabContent');
                container.html('<div class="flex justify-center py-20"><div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div></div>');
                $.get('homepage/project-category/' + id, (res) => {
                    container.hide().html(res.html).fadeIn(500);
                });
            }

            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
                loadDept($(this).data('department-id'));
            });

            loadDept($('.tab-btn').first().data('department-id'));
        });
    </script>
@endpush
