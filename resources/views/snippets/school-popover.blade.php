@push('js')
<script defer>
    $(function(){
        $('{{ $jquery_element_string }}').on('click',function(){
           console.log("Hover over {{ $jquery_element_string }}");
        });
        $('{{ $jquery_element_string }}').popover({
                // container: '#app',
                content: `<div class="container">
                        <div class="row">
                            <div class="col-md-auto">
                                <img src="{{ getLogoImageUrl($school->logo) }}" alt="Logo {{ $school->id }}"
                                style="height: 100px;">
                            </div>
                            <div class="col-md-auto ml-1">
                                <label class="text-break"><strong>School Name: </strong>{{ $school->name }}</label>
                                <br>
                                <label class="text-break"><strong>Address: </strong>{{ $school->address }}</label>
                                <br>
                                <label class="text-break"><strong>District: </strong>{{ $school->district }}</label>
                                <br>
                                <label class="text-break"><strong>Country: </strong>{{ $school->country }}</label>

                            </div>
                        </div>
                    </div>
            `,
                html: true,
                placement: 'auto',
                title: '{{ $school->name }}',
                trigger: 'hover',

            }
        );
    });
</script>
@endpush
