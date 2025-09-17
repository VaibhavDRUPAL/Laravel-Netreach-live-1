@if ($media)
    <a href="{{ $media }}" target="_blank" role="button" class="text-default">
        <strong>Download</strong>
    </a>
@endif
@if ($media)
    @if ($evidence)
        | <a href="{{ asset('storage/' . $evidence) }}" target="_blank" role="button" class="text-default">
            <strong>Show Evidence</strong>
        </a>
    @endif
@else
    <a href="{{ asset('storage/' . $evidence) }}" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
@endif
@if ($evidence2)
    | <a href="{{ asset('storage/' . $evidence2) }}" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
@endif
@if ($evidence3)
    | <a href="{{ asset('storage/' . $evidence3) }}" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
@endif
@if ($evidence4)
    | <a href="{{ asset('storage/' . $evidence4) }}" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
@endif
@if ($evidence5)
    | <a href="{{ asset('storage/' . $evidence5) }}" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
@endif
