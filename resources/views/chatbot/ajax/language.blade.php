@php
use App\Models\LanguageModule\Language;
@endphp
@foreach ($data as $key => $language)
    <span class="locale" data-key="{{ $key }}" data-value="{{ $language[Language::locale] }}" data-toggle="tooltip" data-placement="bottom" title="{{ $language[Language::label_as] }}">{{ $language[Language::name] }}</span>
@endforeach