@component('mail::message')
# Hello {!! $to_name ?? '' !!},

<span class="text-break">{!! $message ?? '' !!}</span>

@if(isset($btn_text) && isset($btn_url))
@component('mail::button', ['url' => $btn_url])
    {!! $btn_text ?? 'Click' !!}
@endcomponent
@endisset

@isset($panel)
@component('mail::panel')
    {!! $panel ?? '' !!}
@endcomponent
@endisset


@isset($table_title)
## Table component:
@endisset

@isset($markdown_table)

@component('mail::table')
{!! $markdown_table ?? '' !!}
@endcomponent

@endisset

@isset($subcopy)
@component('mail::subcopy')
    {!! $subcopy ?? '' !!}
@endcomponent
@endisset


Thanks,
<br>
{!! $mail_from ?? config('app.name') ?? '' !!}
@endcomponent
