@php
    use App\Models\ChatbotModule\Content;
@endphp

@foreach ($data as $content)
    @if ($content[Content::slug] == CHAT_AGAIN)
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
    @if ($loop->first)
        <div class="button-group">
    @endif
        @if ($content[Content::slug] == CHAT_AGAIN_CANCEL)
            @php
                $flag = false;
            @endphp
            @foreach ($content[Content::content] as $key => $item)
                @if ($key == $locale)
                    <button class="btn cancel-btn">{{ $item }}</button>
                    @php
                        $flag = true;
                    @endphp
                @endif
            @endforeach
            @if (!$flag)
                <button class="btn cancel-btn">{{ $content[Content::content][Config::get('app.fallback_locale')] }}</button>
            @endif
        @endif
        @if ($content[Content::slug] == CHAT_AGAIN_CONFIRM)
            @php
                $flag = false;
            @endphp
            @foreach ($content[Content::content] as $key => $item)
                @if ($key == $locale)
                    <button class="btn confirm-btn">{{ $item }}</button>
                    @php
                        $flag = true;
                    @endphp
                @endif
            @endforeach
            @if (!$flag)
                <button class="btn confirm-btn">{{ $content[Content::content][Config::get('app.fallback_locale')] }}</button>
            @endif
        @endif
    @if ($loop->last)
        </div>
    @endif
@endforeach