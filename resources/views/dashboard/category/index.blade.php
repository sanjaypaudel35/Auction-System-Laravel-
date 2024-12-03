@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p style = "font-size: 13px">
                    
                </p>
                <x-section-head>
                    List of categories:
                    <x-slot name="rightSideContent">
                        <a href="{{ route('dashboard.categories.create')}}">create new</a>
                    </x-slot>
                </x-section-head>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <!-- <th>Parent</th> -->
                        <th>Position</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <!-- <td>{{  $category->parent }}</td> -->
                        <td>{{ $category->position }}</td>
                        <td>
                            @if($category->status_value == "active")
                            <span class="badge badge-success">{{ $category->status_value }}</span>
                            @else
                            <span class="badge badge-danger">{{ $category->status_value }}</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{route('dashboard.categories.edit', $category->id)}}">
                                <i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit
                            </a>
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
                                 <i class="fa-regular fa-trash-can"></i>&nbsp;Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
</x-shadow-box>
@endsection