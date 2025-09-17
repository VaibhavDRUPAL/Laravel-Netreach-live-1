@php
    use App\Models\MediaModule\MediaType;
    use App\Models\ChatbotModule\Questionnaire;

    $flag = true;
@endphp

@if (isset($existing) && !empty($existing[Questionnaire::answer_sheet]))
    @foreach ($existing[Questionnaire::answer_sheet] as $answer)
        @if ($answer[Questionnaire::locale] == $locale)
            @php
                $flag = false;
            @endphp
            @foreach ($answer[Questionnaire::body] as $key => $body)
                <section>
                    <div class="row mb-2 answer-row">
                        <div class="col-md-2">
                            <select class="form-control media-type" name="media_type[]" data-index="{{ $key }}">
                                <option disabled selected hidden>Select Media Type</option>
                                @foreach ($mediaType as $value)
                                    <option value="{{ $value[MediaType::slug] }}" @selected($body[MediaType::media_type] == $value[MediaType::slug])>{{ $value[MediaType::type_name] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($body[MediaType::media_type] == LINK)
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . Questionnaire::title }}" value="{{ $body[Questionnaire::title] }}" data-name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] }}" data-index="{{ $key }}" placeholder="Enter Link Title">
                            </div>
                        @endif
                        <div @class(['col-md-6' => $body[MediaType::media_type] == LINK , 'col-md-8' => $body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO, 'col-md-9' => $body[MediaType::media_type] != LINK && $body[MediaType::media_type] != IMAGE && $body[MediaType::media_type] != AUDIO && isset($isAjax) && $isAjax])>
                            @if ($body[MediaType::media_type] == PLAIN_TEXT || $body[MediaType::media_type] == LINK || $body[MediaType::media_type] == VIDEO)
                                <input type="text" class="form-control" name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key }}" value="{{ $body[Questionnaire::content] }}" data-name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] }}" data-index="{{ $key }}" placeholder="Enter Answer">
                            @elseif($body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO)
                                <input type="file" class="form-control" name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key }}" data-name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] }}" data-index="{{ $key }}" placeholder="Enter Answer">
                                <input type="hidden" name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . 'old' }}" value="{{ $body[Questionnaire::content] }}">
                            @elseif($body[MediaType::media_type] == HTML)
                                <input type="text" class="form-control" name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key }}" value="{{ $body[Questionnaire::content] }}" data-name="{{ Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] }}" data-index="{{ $key }}" placeholder="Enter Answer">    
                            @endif
                        </div>
                        @if ($body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO)
                            <div class="col-md-1">
                                <a class="btn btn-primary float-right" target="_blank" href="{{ mediaOperations($body[Questionnaire::content], null, FL_GET_URL) }}" role="button">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        @endif
                        @isset($isAjax)
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger float-right remove-answer">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        @endisset
                    </div>
                </section>
            @endforeach
        @endif
    @endforeach
@endif    

@if ($flag)
    @php
        $key = isset($count) ? $count : 0;
    @endphp
    <section>
        <div class="row mb-2 answer-row">
            <div class="col-md-2">
                <select class="form-control media-type" name="media_type[]" data-index="{{ $key }}">
                    @foreach ($mediaType as $value)
                        <option value="{{ $value[MediaType::slug] }}" @selected($value[MediaType::slug] == PLAIN_TEXT)>{{ $value[MediaType::type_name] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="{{ Questionnaire::answer . UNDERSCORE . PLAIN_TEXT . UNDERSCORE . $count }}" data-name="{{ Questionnaire::answer . UNDERSCORE . PLAIN_TEXT }}" data-index="{{ $count }}" placeholder="Enter Answer">
            </div>
            @isset($isAjax)
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-answer">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            @endisset
        </div>
    </section>
@endif