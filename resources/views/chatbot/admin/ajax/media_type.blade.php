@if ($mediaType == PLAIN_TEXT || $mediaType == LINK || $mediaType == VIDEO)
    <input type="text" class="form-control" name="{{ $fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index }}" data-index="{{ $index }}">
@elseif($mediaType == IMAGE || $mediaType == AUDIO)
    <input type="file" accept="{{ $mediaType == IMAGE ? '.jpg' : '.mp3' }}" class="form-control" name="{{ $fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index }}" data-index="{{ $index }}">
@elseif($mediaType == HTML)
    <input type="text" class="form-control" name="{{ $fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index }}" data-index="{{ $index }}">
@endif