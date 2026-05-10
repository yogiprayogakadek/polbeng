@extends('front_end.template.master')

@section('page-title', 'Project')

@section('content')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6, #8b5cf6);
        }

        .hero-section {
            position: relative;
            padding: 80px 0;
            background-color: #f8fafc;
            overflow: hidden;
        }

        .hero-bg-blur {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            filter: blur(40px) opacity(0.15);
            transform: scale(1.1);
            z-index: 0;
        }

        .category-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            padding: 2px;
            background: var(--primary-gradient);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.1;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-gradient);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        .filter-pill {
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: white;
            color: #64748b;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-pill.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .scroll-hide::-webkit-scrollbar {
            display: none;
        }

        .scroll-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .year-dropdown-btn {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            min-width: 180px;
            justify-content: space-between;
        }

        .year-dropdown-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
        }

        .year-dropdown-btn:after {
            display: none;
        }

        .dropdown-menu-custom {
            border: none;
            border-radius: 20px;
            padding: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin-top: 12px !important;
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
            min-width: 220px;
            z-index: 1050;
        }

        .dropdown-item-custom {
            border-radius: 12px;
            padding: 10px 16px;
            color: #64748b;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            margin-bottom: 4px;
            cursor: pointer;
        }

        .dropdown-item-custom:last-child {
            margin-bottom: 0;
        }

        .dropdown-item-custom:hover {
            background: rgba(59, 130, 246, 0.05);
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.1);
        }

        .dropdown-item-custom.active {
            background: var(--primary-gradient) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        #load-more {
            transition: all 0.3s ease;
        }

        #load-more:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }
    </style>

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
        $photoId = $categoryImages[$projectCategory->project_category_name] ?? '1451187580459-43490279c0fa';
        $thumbnail = $projectCategory->thumbnail;
        if ($thumbnail && !Str::startsWith($thumbnail, ['http://', 'https://'])) {
            $heroImage = asset('storage/' . $thumbnail);
        } elseif ($thumbnail) {
            $heroImage = $thumbnail;
        } else {
            $heroImage = "https://images.unsplash.com/photo-{$photoId}?auto=format&fit=crop&w=1200&q=80";
        }
    @endphp

    <section class="hero-section">
        <div class="hero-bg-blur" style="background-image: url('{{ $heroImage }}')"></div>
        <div class="container-fluid position-relative z-1">
            <nav aria-label="breadcrumb" class="mb-4 animate__animated animate__fadeInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-muted">Home</a></li>
                    <li class="breadcrumb-item"><a href="/#projects" class="text-muted">Project Categories</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">{{ $projectCategory->project_category_name }}</li>
                </ol>
            </nav>

            <div class="row align-items-center">
                <div class="col-lg-8 animate__animated animate__fadeInLeft">
                    <h1 class="display-5 fw-bolder text-dark mb-2">{{ $projectCategory->project_category_name }}</h1>
                    <p class="fs-4 text-muted mb-0">
                        {{ $projectCategory->studyProgram->study_program_name }} • {{ $projectCategory->studyProgram->department->department_name }}
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 animate__animated animate__fadeInRight">
                    <div class="bg-white p-3 rounded-4 shadow-sm d-inline-block border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-start">
                                <div class="small text-muted text-uppercase tracking-wider fw-bold">Total Projects</div>
                                <div class="fs-5 fw-bolder text-primary lh-1">{{ $projects->total() }} Showcase</div>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary">
                                <i class="ti ti-layers-intersect fs-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light-gray py-7 min-vh-100">
        <div class="container-fluid">
            <div class="row g-4 mb-5 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text bg-white border-end-0 ps-4">
                            <i class="ti ti-search text-muted"></i>
                        </span>
                        <input type="text" id="search-project" class="form-control border-start-0 ps-2 py-3 fs-5"
                            placeholder="Search project title or description...">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted fw-bold text-nowrap"><i class="ti ti-filter me-1"></i> Year:</span>
                        <div class="dropdown">
                            <button class="year-dropdown-btn dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span id="selected-year-text">All Time</span>
                                <i class="ti ti-chevron-down opacity-50"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom shadow-lg border-0" aria-labelledby="yearDropdown">
                                <li>
                                    <a class="dropdown-item dropdown-item-custom active year-filter" data-year="" href="javascript:void(0)">
                                        <i class="ti ti-calendar-event me-2"></i> All Time
                                    </a>
                                </li>
                                @foreach ($allYears as $year)
                                    <li>
                                        <a class="dropdown-item dropdown-item-custom year-filter" data-year="{{ $year }}" href="javascript:void(0)">
                                            <i class="ti ti-calendar me-2"></i> {{ $year }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="results-count" class="mb-4 text-muted small text-uppercase tracking-widest fw-bold opacity-0 transition-all">
                Found Results
            </div>

            <div id="project-list" class="row g-4">
                @include('front_end.project.partials.project_card', ['projects' => $projects])
            </div>

            <div class="text-center mt-5">
                <button id="load-more" class="btn btn-primary rounded-pill px-5 py-2 {{ $projects->hasMorePages() ? '' : 'd-none' }}">
                    Load More Projects
                </button>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        let page = 1;
        let selectedYear = '';
        let isLoading = false;
        const projectCategoryID = '{{ $projectCategoryID }}';

        function updateFilters() {
            page = 1;
            const query = $('#search-project').val();
            
            $.ajax({
                url: "{{ route('frontend.project.search') }}",
                method: 'GET',
                data: {
                    query: query,
                    year: selectedYear,
                    projectCategoryID: projectCategoryID
                },
                success: function(html) {
                    $('#project-list').html(html);
                    
                    if (query.length > 0 || selectedYear !== '') {
                        $('#results-count').removeClass('opacity-0');
                    } else {
                        $('#results-count').addClass('opacity-0');
                    }

                    const $html = $('<div>').append(html);
                    if ($.trim(html) === '' || $html.find('.empty-state-wrapper').length > 0) {
                        $('#load-more').addClass('d-none').hide();
                    } else {
                        $('#load-more').removeClass('d-none').show();
                    }
                }
            });
        }

        $('.year-filter').on('click', function(e) {
            e.preventDefault();
            $('.year-filter').removeClass('active');
            $(this).addClass('active');
            selectedYear = $(this).data('year');
            
            // Update dropdown text
            const yearText = selectedYear === '' ? 'All Time' : selectedYear;
            $('#selected-year-text').text(yearText);
            
            updateFilters();
        });

        $('#search-project').on('keyup', function() {
            clearTimeout(window.searchDelay);
            window.searchDelay = setTimeout(updateFilters, 400);
        });

        function loadMoreProjects() {
            if (isLoading) return;
            
            isLoading = true;
            $('#load-more').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...');
            
            page++;
            const query = $('#search-project').val();
            $.ajax({
                url: "{{ route('frontend.project.loadmore') }}",
                data: {
                    page: page,
                    query: query,
                    year: selectedYear,
                    projectCategoryID: projectCategoryID
                },
                method: 'GET',
                success: function(html) {
                    if ($.trim(html) !== '') {
                        $('#project-list').append(html);
                        $('#load-more').prop('disabled', false).html('Load More Projects');
                    } else {
                        $('#load-more').addClass('d-none').hide();
                    }
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }

        $('#load-more').on('click', function() {
            loadMoreProjects();
        });

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                if (!$('#load-more').hasClass('d-none') && $('#load-more').is(':visible') && !isLoading) {
                    loadMoreProjects();
                }
            }
        });
    </script>
@endpush
