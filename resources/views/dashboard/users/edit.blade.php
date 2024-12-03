@extends('layouts.master')

@section('content')
    <x-shadow-box shadowClass="shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-section-head>
                    <p style = "font-size: 13px">
                        
                    </p>
                    User Detail:
                </x-section-head>
                <form action="{{route('dashboard.users.update', $user->id)}}" method = "post" id = "user-edit-form">
                    @csrf
                    @method('patch')
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label><span class = "required">*</span>
                                <input type="text" class="form-control" placeholder="Enter Name" id="product_name", value="{{old('name') ?? $user->name}}" name="name">
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                @error("email")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="email" class="form-control" readonly name="" placeholder="Enter Email Address" value="{{ $user->email}}"></input>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number:</label>
                                @error("email")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name = "phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') ?? $user->phone_number}}"></input>
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                @error("address")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" class="form-control" name = "address" placeholder="Enter the address" value="{{ old('address') ?? $user->address}}"></input>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="submit" buttonClass="btn btn-success" id="update-btn">Update</button> -->
                    <button type="button" class="btn btn-default" id="edit-btn" style = "border:1px solid grey"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Enable Editing</button>
                    <a type="button" href="{{ route('dashboard.users.destroy', $user->id) }}" class="btn btn-danger mx-1" id="delete-btn" style = "display: none; float:right;" onclick="return confirm('Are you sure you want to delete this user permanently ? All its related record will be deleted.')"><i class="fa-solid fa-trash"></i>&nbsp;Delete User</a>
                    <button type="submit" class="btn btn-success mx-1" id="update-btn" style = "display: none; float:right"><i class="fa-solid fa-computer-mouse"></i>&nbsp;Update User</button>
                </form>
            </div>
        </div>
    </x-shadow-box>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#user-edit-form input[type="text"]').prop('readonly', true);

        var isEditing = false;

        // Bind click event to the edit-btn
        $("#edit-btn").click(function () {
            isEditing = !isEditing;
            // Set readonly property based on the isEditing variable
            $('#user-edit-form input[type="text"]').prop('readonly', !isEditing);
            // Show/hide the update-btn based on the isEditing variable
            $("#update-btn").toggle(isEditing);
            $("#delete-btn").toggle(isEditing);

            // Change the text content of the edit-btn based on the isEditing variable
            $(this).text(isEditing ? "Disable Editing" : "Enable Editing");
        });
    });
</script>
@endsection