@php
use App\Models\ChatbotModule\Greetings;
use App\Models\MediaModule\MediaType;
@endphp
<li class="chat">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="{{ App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif') }}" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">
        @foreach ($greetings as $greeting)
        @if ($greeting[MediaType::media_type] == PLAIN_TEXT)
        <p>{{ Str::squish($greeting[Greetings::body]) }}</p>
        @elseif($greeting[MediaType::media_type] == IMAGE)
        <img src="{{ mediaOperations($greeting[Greetings::body], null, FL_CHECK_EXIST) ? mediaOperations($greeting[Greetings::body], null, FL_GET_URL) : '#' }}" alt="">
        @elseif($greeting[MediaType::media_type] == VIDEO)
        <iframe width="400" height="250" src="{{ $greeting[Greetings::body] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        @elseif($greeting[MediaType::media_type] == LINK)
        <a target="_blank" href="{{ $greeting[Greetings::body] }}">{{ $greeting[Greetings::body] }}</a>
        @endif
        @endforeach
    </div>
</li>
