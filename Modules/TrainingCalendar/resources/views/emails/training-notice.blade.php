<x-email.layout>
    <x-slot name="logo">
        <x-email.logo />
    </x-slot>
    <x-slot name="content">
        <div style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;color:#4c4c4c;">
            <p style="margin:0 0 16px;">Hello {{ $registration->name }},</p>
            <p style="margin:0 0 20px;">
                You have a new update for <strong style="color:#111827;">{{ $training->title }}</strong>:
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 20px;background:#f6f8f7;border-left:4px solid #065A46;border-radius:8px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0 0 8px;font-size:16px;font-weight:700;color:#111827;">{{ $notice->subject }}</p>
                        <p style="margin:0;color:#585858;">
                            <strong style="color:#4c4c4c;">Event date &amp; time:</strong>
                            {{ $training->event_datetime?->format('M d, Y h:i A') }}
                        </p>
                        @if($notice->location)
                            <p style="margin:6px 0 0;color:#585858;">
                                <strong style="color:#4c4c4c;">Location:</strong> {{ $notice->location }}
                            </p>
                        @endif
                    </td>
                </tr>
            </table>

            @if($notice->message)
                <div style="margin:0 0 20px;">
                    {!! nl2br(e($notice->message)) !!}
                </div>
            @endif

            @if($notice->zoom_link)
                <x-email.button btnText="Join via Zoom" :btnUrl="$notice->zoom_link" />
            @endif

            @if($notice->meet_link)
                <x-email.button btnText="Join via Google Meet" :btnUrl="$notice->meet_link" />
            @endif
        </div>
    </x-slot>
    <x-slot name="signature">
        {!! nl2br($signature ?? '') !!}
    </x-slot>
    <x-slot name="copyright">
        {!! nl2br($copyright ?? '') !!}
    </x-slot>
</x-email.layout>
