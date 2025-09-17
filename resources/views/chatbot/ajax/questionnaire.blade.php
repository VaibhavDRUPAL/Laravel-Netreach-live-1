@php
    use App\Models\ChatbotModule\{Greetings, Content};
@endphp
<li class="chat outgoing">
    @foreach ($questionnaire as $id => $question)
        <p class="question" name="question" data-id="{{ $id }}" data-locale="{{ $locale }}">{{ Str::squish($question[Greetings::body]) }}</p>
    @endforeach
    <div class="extra">
        @foreach ($contentData as $content)
            @if ($content[Content::slug] == LOAD_MORE)
                @php
                    $flag = false;
                @endphp
                @foreach ($content[Content::content] as $key => $item)
                    @if ($key == $locale)
                        <span class="load-more" data-offset="{{ $offset }}" data-locale="{{ $locale }}">{{ $item }}</span>
                        @php
                            $flag = true;
                        @endphp
                    @endif
                @endforeach
                @if (!$flag)
                    <span class="load-more" data-offset="{{ $offset }}" data-locale="{{ $locale }}">{{ $content[Content::content][Config::get('app.fallback_locale')] }}</span>
                @endif
            @endif
            @if ($content[Content::slug] == BOOK_AN_APPOINTMENT)
                @foreach ($content[Content::content] as $key => $item)
                    @if ($key == $locale)
                        <span class="book-an-appointment">{{ $item }}</span>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
</li> 