@extends('layouts.layout')
@section('app-content')
    @push('css')

    @endpush
    @push('js')
        <script>
            // $.fn.selectpicker.Constructor.BootstrapVersion = '4';

        </script>

    @endpush
    <select class="selectpicker" data-live-search="true">
        <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
        <option data-tokens="mustard">Burger, Shake and a Smile</option>
        <option data-tokens="frosting">Sugar, Spice and all things nice</option>
    </select>


@endsection
