<x-mail::message>
# {{ $messageSubject }}

Hello,

{{-- This will convert newlines (like pressing Enter) into paragraphs --}}
{!! nl2br(e($messageBody)) !!}

<br>
Thanks,<br>
{{ $fromName ?? config('app.name') }}
</x-mail::message>