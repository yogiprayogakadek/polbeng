<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <a href="{{ route('frontend.homepage') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logo/main-logo.png') }}" height="40px" alt="Logo" />
        </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="list-unstyled ps-0">

            <li class="mb-1">
                <a href="{{ route('frontend.homepage') }}"
                    class="px-0 fs-4 d-block text-dark link-primary w-100 py-2">Home</a>
            </li>

            <li class="mb-1">
                <button
                    class="fs-4 d-flex justify-content-between align-items-center w-100 border-0 bg-transparent text-dark link-primary py-2 px-0"
                    data-bs-toggle="collapse" data-bs-target="#submenuDepartments" aria-expanded="false"
                    aria-controls="submenuDepartments">
                    Departments
                    <i class="ti ti-chevron-down fs-5"></i>
                </button>
                <div class="collapse ps-3" id="submenuDepartments">
                    <ul class="list-unstyled">
                        @foreach (listDepartment() as $department)
                            <li>
                                <a href="{{ route('frontend.project.department', ['department' => Str::slug($department->department_name), 'uuid' => $department->uuid]) }}"
                                    class="d-block py-1 text-dark">{{ $department->department_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
