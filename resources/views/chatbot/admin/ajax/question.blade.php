@php
    use App\Models\LanguageModule\Language;
@endphp

<section>
    <div class="row mb-2 question-row">
        <div class="col-md-2">
            <select class="form-control" name="locale[]">
                @foreach ($language as $value)
                    @if (empty($existingLocale))
                        <option value="{{ $value[Language::locale] }}">{{ $value[Language::name] }}</option>
                    @else
                        @if (!$existingLocale->contains($value[Language::locale]))
                            <option value="{{ $value[Language::locale] }}">{{ $value[Language::name] }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" name="question[]" placeholder="Enter Question">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger float-right remove-question">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</section>