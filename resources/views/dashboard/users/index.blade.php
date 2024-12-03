@extends('layouts.master')

@section('content')
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
                        <th>Action</th>
                        <th>Auction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->formatted_created_at }}</td>
                        <td>
                           <span><a href = "{{ route('dashboard.users.edit', $user->id) }}" class = "badge badge-primary">edit</a></span>
                           <span><a href = "#" class = "badge badge-danger">delete</a></span>
                        </td>
                        <td>
                            <span><a href = "{{ route('dashboard.users.auction.live', $user->id) }}" class = "btn btn-primary btn-sm"><i class="fa-regular fa-chess-bishop"></i>&nbsp;User's Auctions</a></span>&nbsp;
                           <span><a href = "{{ route('dashboard.users.bid.history', $user->id) }}" class = "btn btn-success btn-sm"><i class="fa-solid fa-hammer"></i>&nbsp;User's Bids</a></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
</div>
</x-shadow-box>
@endsection