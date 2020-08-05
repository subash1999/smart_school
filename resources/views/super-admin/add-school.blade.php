@extends("layouts.super-admin-layout")
@section("super-admin-content")
    <h2 class="h2 text-center">Add/Register School</h2>
    <form action="{{ route("super-admin-store-school") }}"
          method="POST"
        class="col-xxl-6 col-xl-8 col-lg-8 flex-column m-auto">
        @csrf
        <div class="form-group">
            <label for="name">School Name</label>
            <input type="text" name="name"
                   class="form-control" required min="2" max="255">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address"
                   class="form-control" required min="2" max="255">
        </div>
        <div class="form-group">
            <label for="district">District</label>
            <input type="text" name="district"
                   class="form-control" required min="2" max="255">
        </div>
    </form>
@endsection
