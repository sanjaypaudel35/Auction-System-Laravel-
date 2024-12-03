@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    <p style = "font-size: 13px">
                        
                    </p>
                    Edit a Category:
                </x-section-head>
                    <form action="{{route('dashboard.categories.update', $category->id)}}" method = "post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label><span class = "required">*</span>
                            <x-form-input type="text" name="name" placeholder="Enter category name" value="{{ $category->name ?? old('name')}}"></x-form-input>
                        </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name = "description" class="form-control" placeholder="Enter Description">
                            {{ $category->description ?? old('description')}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="position">position:</label>
                        <x-form-input type="number" name="position" value="{{ $category->position ?? old('position')}}"></x-form-input>
                    </div>
                    <x-button type="submit" buttonClass="btn btn-primary">Update</x-button>
                </form>
            </div>
        </div>
    </x-shadow-box>
@endsection