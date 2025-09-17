@php
    use App\Models\ChatbotModule\Greetings;
    use App\Models\LanguageModule\Language;
    use App\Models\MediaModule\MediaType;
@endphp

@if (isset($existing) && !empty($existing[Greetings::greetings]))
    @foreach ($existing[Greetings::greetings] as $key => $greeting)
        <section>
            <div class="row mb-2 greeting-row">
                <div class="col-md-2">
                    <select class="form-control language" name="locale[]" data-index="{{ $key }}">
                        <option disabled selected hidden>Select Language</option>
                        @foreach ($language as $value)
                            <option value="{{ $value[Language::locale] }}" @selected($value[Language::locale] == $greeting[Language::locale])>{{ $value[Language::name] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control media-type" name="media_type[]" data-index="{{ $key }}">
                        <option disabled selected hidden>Select Media Type</option>
                        @foreach ($mediaType as $value)
                            <option value="{{ $value[MediaType::slug] }}" @selected($greeting[MediaType::media_type] == $value[MediaType::slug])>{{ $value[MediaType::type_name] }}</option>
                        @endforeach
                    </select>
                </div>
                <div @class(['col-md-8' => !isset($isAjax), 'col-md-7' => $greeting[MediaType::media_type] != IMAGE && $greeting[MediaType::media_type] != AUDIO && isset($isAjax) && $isAjax, 'col-md-6' => $greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO])>
                    @if ($greeting[MediaType::media_type] == PLAIN_TEXT || $greeting[MediaType::media_type] == LINK || $greeting[MediaType::media_type] == VIDEO)
                        <input type="text" class="form-control" name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key }}" value="{{ $greeting[Greetings::body] }}" data-name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] }}" data-index="{{ $key }}">
                    @elseif($greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO)
                        <input type="file" class="form-control" name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key }}" data-name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] }}" data-index="{{ $key }}">
                        <input type="hidden" name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . 'old' }}" value="{{ $greeting[Greetings::body] }}">
                    @elseif($greeting[MediaType::media_type] == HTML)
                        <input type="text" class="form-control" name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key }}" value="{{ $greeting[Greetings::body] }}" data-name="{{ Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] }}" data-index="{{ $key }}">    
                    @endif
                </div>
                @if ($greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO)
                    <div class="col-md-1">
                        <a class="btn btn-primary float-right" target="_blank" href="{{ mediaOperations($greeting[Greetings::body], null, FL_CHECK_EXIST) ? mediaOperations($greeting[Greetings::body], null, FL_GET_URL) : '#' }}" role="button">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                @endif
                @isset($isAjax)
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger float-right remove-greeting" data-index="{{ $key }}">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                @endisset
            </div>
        </section>
    @endforeach
@else
    @php
        $key = isset($count) ? $count : 0;
    @endphp
    <section>
        <div class="row mb-2 greeting-row">
            <div class="col-md-2">
                <select class="form-control language" name="locale[]" data-index="{{ $key }}">
                    <option disabled selected hidden>Select Language</option>
                    @foreach ($language as $value)
                        <option value="{{ $value[Language::locale] }}">{{ $value[Language::name] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control media-type" name="media_type[]" data-index="{{ $key }}">
                    <option disabled selected hidden>Select Media Type</option>
                    @foreach ($mediaType as $value)
                        <option value="{{ $value[MediaType::slug] }}">{{ $value[MediaType::type_name] }}</option>
                    @endforeach
                </select>
            </div>
            <div @class(['col-md-8' => !isset($isAjax), 'col-md-7' => isset($isAjax) && $isAjax])>
                <input type="text" class="form-control" name="{{ Greetings::greetings . UNDERSCORE . PLAIN_TEXT . UNDERSCORE . $key }}" data-index="{{ $key }}">
            </div>
            @isset($isAjax)
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-greeting" data-index="{{ $key }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            @endisset
        </div>
    </section>
@endif