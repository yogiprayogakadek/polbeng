<?php

use App\Models\Department;

function listDepartment()
{
    $departments = Department::where('is_active', true)->get();

    return $departments;
}
