@extends('layouts.admin')

@section('title', 'គ្រប់គ្រងប្រភេទអាហារ')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">📂 ប្រភេទអាហារ</h3>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> បន្ថែមប្រភេទថ្មី
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>រូបភាព</th>
                    <th>ឈ្មោះ</th>
                    <th>ប្រភេទមេ</th>
                    <th>តម្លៃ</th>
                    <th>ស្តុក</th>
                    <th class="text-end">សកម្មភាព</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>

                        <td>
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     width="50" height="50"
                                     class="rounded"
                                     style="object-fit: cover;">
                            @else
                                <span class="text-muted">គ្មានរូប</span>
                            @endif
                        </td>

                        <td class="fw-semibold">{{ $category->name }}</td>

                        {{-- Parent Category --}}
                        <td>
                            {{ $category->parent?->name ?? '-' }}
                        </td>

                        {{-- Price --}}
                        <td class="text-success fw-bold">
                            ${{ number_format($category->price ?? 0, 2) }}
                        </td>

                        {{-- Stock --}}
                        <td>
                            <span class="badge bg-success">
                                {{ $category->stock ?? 0 }}
                            </span>
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('តើអ្នកប្រាកដថាចង់លុបប្រភេទនេះ?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            មិនទាន់មានប្រភេទអាហារនៅឡើយទេ។
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
