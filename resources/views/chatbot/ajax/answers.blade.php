@php
    use App\Models\ChatbotModule\{Content, Questionnaire};
    use App\Models\MediaModule\MediaType;
@endphp
<li class="chat">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="{{ App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif') }}" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">
        @foreach ($data[Questionnaire::body] as $answer)
            @if ($answer[MediaType::media_type] == PLAIN_TEXT)
                <p>{{ Str::squish($answer[Questionnaire::content]) }}</p>
            @elseif($answer[MediaType::media_type] == IMAGE)
                <img src="{{ mediaOperations($answer[Questionnaire::content], null, FL_GET_URL) }}" alt="">
            @elseif($answer[MediaType::media_type] == VIDEO)
                <iframe width="400" height="250" src="{{ $answer[Questionnaire::content] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            @elseif($answer[MediaType::media_type] == LINK)
                <a target="_blank" href="{{ $answer[Questionnaire::content] }}">{{ $answer[Questionnaire::title] }}</a>
            @endif
        @endforeach
        @foreach ($contentData as $content)
            @if ($content[Content::slug] == ASK_ANOTHER_QUESTION)
                @php
                    $flag = false;
                @endphp
                @foreach ($content[Content::content] as $key => $item)
                    @if ($key == $locale)
                        <p>{{ $item }}</p>
                        @php
                            $flag = true;
                        @endphp
                    @endif
                @endforeach
                @if (!$flag)
                    <p>{{ $content[Content::content][Config::get('app.fallback_locale')] }}</p>
                @endif
            @endif
        @endforeach
    </div>
</li>
<li class="chat outgoing">
    @foreach ($contentData as $content)
        @if ($content[Content::slug] == ASK_ANOTHER_QUESTION_YES)
            @php
                $flag = false;
            @endphp
            @foreach ($content[Content::content] as $key => $item)
                @if ($key == $locale)
                    <p class="show-more" data-id="{{ $questionID }}" data-locale="{{ $locale }}">{{ $item }}</p>
                    @php
                        $flag = true;
                    @endphp
                @endif
            @endforeach
            @if (!$flag)
                <p class="show-more" data-id="{{ $questionID }}" data-locale="{{ $locale }}">{{ $content[Content::content][Config::get('app.fallback_locale')] }}</p>
            @endif
        @endif
        @if ($content[Content::slug] == ASK_ANOTHER_QUESTION_NO)
            @php
                $flag = false;
            @endphp
            @foreach ($content[Content::content] as $key => $item)
                @if ($key == $locale)
                    <p class="no-thats-all">{{ $item }}</p>
                    @php
                        $flag = true;
                    @endphp
                @endif
            @endforeach
            @if (!$flag)
                <p class="no-thats-all">{{ $content[Content::content][Config::get('app.fallback_locale')] }}</p>
            @endif
        @endif
    @endforeach
</li>
