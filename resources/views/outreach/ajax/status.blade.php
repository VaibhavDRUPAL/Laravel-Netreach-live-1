@php
    if ($statusID == 1)  $class = 'text-info';
    else if ($statusID == 2)  $class = 'text-success';
    else if ($statusID == 3)  $class = 'text-danger';
    else $class = 'text-primary';
@endphp

<span class="font-weight-bold {{ $class }}">{{ $status }}</span>