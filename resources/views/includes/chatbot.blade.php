{{-- <div class="chatbot-toggler" data-toggle="tooltip" data-placement="top" title="Hi, I’m Malini didi">
    <img style="width: 75%" src="{{ App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif') }}" alt="">
    <i class="close-icon fa-solid fa-xmark fa-2xl" style="display: none;"></i>
</div>

<div class="chatbot" style="display: none;">
    <header>
        <img style="width: 50px;margin-left:5px;margin-right:5px" class="header-image" src="{{ App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif') }}" alt="Hello, I'm Malini Didi">
        <div class="header-greeting ms-2">
            <span>Hello</span>
            <span>I'm Malini Didi</span>
        </div>
        <i class="refresh-icon me-5 fa-sharp fa-solid fa-rotate-right fa-xl"></i>
    </header>
    <div id="chatbot_helpline">
            <a href="tel:1097" class="aids_helpline">Call AIDS Helpline 1097</a>
    </div>
    <div class="modal" style="display: none;">
        <div class="modal-content" id="reset-content">
            @include('chatbot.ajax.reset')
        </div>
    </div>

    <ul class="chatbox" id="chatbox">
        <li class="chat" style="margin-top: 20px;">
            <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="{{ App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif') }}" alt="Chatbot Image" class="chatbot-image">
            <div class="incoming">
                <p>Please select your preferred language from the options below</p>
            </div>
        </li>
        <li class="chat outgoing">
            <div id="language-list" class="languages">
                @include('chatbot.ajax.language')
            </div>
        </li>
        <section id="chatbot"></section>
    </ul>
</div> --}}