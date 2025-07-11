<aside class="side-mini-panel with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="iconbar">
        <div>
            <div class="mini-nav">
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </div>
                <ul class="mini-nav-ul" data-simplebar>

                    <!-- --------------------------------------------------------------------------------------------------------- -->
                    <!-- Pegawai -->
                    <!-- --------------------------------------------------------------------------------------------------------- -->

                    <li class="mini-nav-item single-menu" id="dashboard">
                        <a href="{{ route('dashboard.admin') }}" data-bs-toggle="tooltip"
                            data-bs-custom-class="custom-tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                            <iconify-icon icon="solar:home-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    {{-- <li>
                        <span class="sidebar-divider lg"></span>
                    </li> --}}


                    <li class="mini-nav-item" id="mini-1">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Department">
                            <iconify-icon icon="solar:buildings-2-bold" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <li class="mini-nav-item" id="mini-2">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Study Program">
                            <iconify-icon icon="ph:graduation-cap" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item" id="mini-3">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Project Category">
                            <iconify-icon icon="solar:tag-bold" class="fs-7"></iconify-icon>
                        </a>
                    </li>
                    <li class="mini-nav-item" id="mini-4">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Project">
                            <iconify-icon icon="solar:folder-with-files-bold" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                </ul>

            </div>
            <div class="sidebarmenu">
                <div class="brand-logo d-flex align-items-center nav-logo">
                    <a href="{{ route('dashboard.admin') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logo/main-logo.png') }}" height="40px" alt="Logo" />
                    </a>

                </div>

                <!-- ---------------------------------- -->
                <!-- Department -->
                <!-- ---------------------------------- -->
                <nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
                    <ul class="sidebar-menu" id="sidebarnav">
                        <!-- ---------------------------------- -->
                        <!-- Department -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap">
                            <span class="hide-menu">Department</span>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Department -->
                        <!-- ---------------------------------- -->
                        {{-- @can('access-admin-menu') --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" id="department" href="{{ route('department.index') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:buildings-2-bold"></iconify-icon>
                                <span class="hide-menu">Department List</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('department.create') }}" aria-expanded="false">
                                <iconify-icon icon="solar:user-plus-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Create Department</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('department.showRestore') }}" aria-expanded="false">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                <span class="hide-menu">Deleted Items</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- ---------------------------------- -->
                <!-- Study Program -->
                <!-- ---------------------------------- -->
                <nav class="sidebar-nav" id="menu-right-mini-2" data-simplebar>
                    <ul class="sidebar-menu" id="sidebarnav">
                        <!-- ---------------------------------- -->
                        <!-- Study Program -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap">
                            <span class="hide-menu">Study Program</span>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Study Program -->
                        <!-- ---------------------------------- -->
                        {{-- @can('access-admin-menu') --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" id="studi_program" href="{{ route('studyProgram.index') }}"
                                aria-expanded="false">
                                <iconify-icon icon="ph:graduation-cap-duotone"></iconify-icon>
                                <span class="hide-menu">Study Program List</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('studyProgram.create') }}" aria-expanded="false">
                                <iconify-icon icon="solar:user-plus-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Create Study Program</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('studyProgram.showRestore') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                <span class="hide-menu">Deleted Items</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- ---------------------------------- -->
                <!-- Project Category -->
                <!-- ---------------------------------- -->
                <nav class="sidebar-nav" id="menu-right-mini-3" data-simplebar>
                    <ul class="sidebar-menu" id="sidebarnav">
                        <!-- ---------------------------------- -->
                        <!-- Project Category -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap">
                            <span class="hide-menu">Project Category</span>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Project Category -->
                        <!-- ---------------------------------- -->
                        {{-- @can('access-admin-menu') --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" id="project_category" href="{{ route('projectCategory.index') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:tag-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Project Category List</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('projectCategory.create') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:user-plus-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Create Project Category</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('projectCategory.showRestore') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                <span class="hide-menu">Deleted Items</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- ---------------------------------- -->
                <!-- Project -->
                <!-- ---------------------------------- -->
                <nav class="sidebar-nav" id="menu-right-mini-4" data-simplebar>
                    <ul class="sidebar-menu" id="sidebarnav">
                        <!-- ---------------------------------- -->
                        <!-- Project -->
                        <!-- ---------------------------------- -->
                        <li class="nav-small-cap">
                            <span class="hide-menu">Project</span>
                        </li>
                        <!-- ---------------------------------- -->
                        <!-- Project -->
                        <!-- ---------------------------------- -->
                        {{-- @can('access-admin-menu') --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link" id="project" href="{{ route('project.index') }}"
                                aria-expanded="false">
                                <iconify-icon icon="solar:folder-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Project List</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('project.create') }}" aria-expanded="false">
                                <iconify-icon icon="solar:user-plus-bold-duotone"></iconify-icon>
                                <span class="hide-menu">Create Project</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('project.showRestore') }}" aria-expanded="false">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken"></iconify-icon>
                                <span class="hide-menu">Deleted Items</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</aside>
