<form action="{{ $url ?? '' }}" method="POST">
    {{ $country }}
    @csrf
    <label for="">Email: {{ Auth::user()->email }}</label>
    <div class="form-group">
        <input type="password" name="password" class="form-control">
    </div>
    <input type="submit" value="Verify" class="btn btn-primary">
</form>
