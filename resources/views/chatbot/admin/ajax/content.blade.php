@php
    use App\Models\ChatbotModule\Content;
    use App\Models\LanguageModule\Language;
@endphp

@if (isset($data) && !empty($data[Content::content]))
    @php
        $index = 0;
    @endphp
    @foreach ($data[Content::content] as $key => $content)
        <section data-section="{{ $index }}">
            <div class="row mb-2 content-row">
                <div class="col-md-3">
                    <select class="form-control content-language" name="locale[]" data-index="{{ $index }}">
                        <option disabled selected hidden>Select Language</option>
                        @foreach ($language as $value)
                            <option value="{{ $value[Language::locale] }}" @selected($value[Language::locale] == $key)>{{ $value[Language::name] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="content[]" id="content_{{ $index }}" value="{{ $content }}" data-index="{{ $index }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-content" data-locale="{{ $key }}" data-index="{{ $index }}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </section>
        @php
            $index++;
        @endphp
    @endforeach
@else
    <section data-section="en">
        <div class="row mb-2 content-row">
            <div class="col-md-3">
                <select class="form-control content-language" name="locale[]">
                    <option disabled selected hidden>Select Language</option>
                    @foreach ($language as $value)
                        <option value="{{ $value[Language::locale] }}">{{ $value[Language::name] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="content[]">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger float-right remove-content" data-locale="en">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </section>
@endif