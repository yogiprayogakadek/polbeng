<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Project Title</th>
            <th>Category</th>
            <th>School Year</th>
            <th>Semester</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($projects as $index => $project)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $project->project_title }}</td>
                <td>{{ $project->projectCategory->project_category_name ?? '-' }}</td>
                <td>{{ $project->school_year }}</td>
                <td><span class="badge bg-primary">{{ $project->semester }}</span></td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No projects found for the selected filters.</td>
            </tr>
        @endforelse
    </tbody>
</table>
