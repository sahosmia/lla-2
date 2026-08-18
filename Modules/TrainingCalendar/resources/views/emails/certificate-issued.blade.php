<x-email.layout>
    <x-slot name="logo">
        <x-email.logo />
    </x-slot>
    <x-slot name="content">
        <div style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;color:#4c4c4c;">
            <p style="margin:0 0 16px;">Hello {{ $registration->name }},</p>
            <p style="margin:0 0 20px;">
                Congratulations! You have successfully attended <strong style="color:#111827;">{{ $training->title }}</strong> and your certificate of completion is ready.
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px;background:#f6f8f7;border-left:4px solid #065A46;border-radius:8px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="margin:0 0 8px;font-size:16px;font-weight:700;color:#111827;">{{ $training->title }}</p>
                        <p style="margin:0;color:#585858;">
                            <strong style="color:#4c4c4c;">Event date &amp; time:</strong>
                            {{ $training->event_datetime?->format('M d, Y h:i A') }}
                        </p>
                        @if($training->hasAccreditation())
                            <p style="margin:6px 0 0;color:#585858;">
                                <strong style="color:#4c4c4c;">Accreditation:</strong>
                                {{ $training->accreditation_body }}{{ $training->accreditation_body && $training->formatted_pdu_points ? ' · ' : '' }}{{ $training->formatted_pdu_points ? $training->formatted_pdu_points . ' PDU' : '' }}
                            </p>
                        @endif
                    </td>
                </tr>
            </table>

            <p style="margin:0 0 20px;">
                You can view or download your certificate using the buttons below.
            </p>

            <x-email.button btnText="View Certificate" :btnUrl="$viewUrl" />
            <div style="margin-top:12px;">
                <a href="{{ $downloadUrl }}" style="font-size:14px;color:#065A46;text-decoration:underline;">Download certificate</a>
            </div>
        </div>
    </x-slot>
    <x-slot name="signature">
        {!! nl2br($signature ?? '') !!}
    </x-slot>
    <x-slot name="copyright">
        {!! nl2br($copyright ?? '') !!}
    </x-slot>
</x-email.layout>
