@extends('layouts.master')

@section('content')
    @php
        $permissions = config("permissions");
        $authRole = auth()->user()->role?->slug;
        $authPermissions = $permissions[$authRole] ?? [];
    @endphp
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    Users:
                    <x-slot name="rightSideContent">
                    </x-slot>
                </x-section-head>
            </div>
            <div class = "col-md-12">
            <table class="table display table-bordered" id = "example">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        @if (in_array("app.http.controllers.admin.admincontroller.destroy", $authPermissions))
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->formatted_created_at }}</td>
                        <td>{{ $user->createdBy?->name}}</td>
                        @if (in_array("app.http.controllers.admin.admincontroller.destroy", $authPermissions))
                        <td>
                                <form method="POST" action="{{ route('dashboard.admins.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class = "btn btn-sm btn-danger">Delete User</button>
                                </form>
                            </td>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
</div>
</x-shadow-box>
@endsection