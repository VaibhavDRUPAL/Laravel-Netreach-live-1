@extends('layouts.app')

@php
    use App\Models\ChatbotModule\LanguageCounter;
    use App\Models\LanguageModule\Language;
@endphp

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Language Counter</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Language Name</th>
                                    <th scope="col">Language Counter</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach($data as $counter)
                                    <tr>
                                        <td scope="row" width="5%">{{ ++$count }}</td>
                                        <td scope="row" width="5%">{{ $counter[LanguageCounter::RL_LANGUAGE][Language::name] }}</td>
                                        <td scope="row" width="80%">{{ $counter[LanguageCounter::counter] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection