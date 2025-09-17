@extends('layouts.app')
@php
use App\Models\LanguageModule\Language;
@endphp
@section('content')
<div class="row">
    <div class="col-md-12 my-2">
        <button class="btn btn-primary float-right" id="add-language">
            <i class="fa fa-plus"></i>
            Add Language
        </button>
    </div>
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">All Language</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Language</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $count = 0;
                                @endphp
                                @if ($data->isNotEmpty())
                                    @foreach($data as $language)
                                        <tr>
                                            <td scope="row">{{ ++$count }}</td>
                                            <td scope="row">{{ $language[Language::label_as] }}</td>
                                            <td scope="row">{{ $language[Language::name] }}</td>
                                            <td scope="row">
                                                <a href="#" class="px-1 edit-language"
                                                    data-id="{{ $language[Language::language_id] }}">
                                                    <i class="fas text-primary fa-edit"></i>
                                                </a>
                                                <a href="#" class="px-1">
                                                    <i class="fas text-danger fa-trash delete-language"
                                                        data-id="{{ $language[Language::language_id] }}"
                                                        data-label="{{ $language[Language::label_as] }}"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td scope="row" colspan="3">No data found!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="language" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="language_title">Add Language</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form action="{{ route('language.save') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row" id="frm-add-language">
                                <input type="hidden" name="language_id" id="language_id">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Language Name</label>
                                        <input type="text" class="form-control" name="label_as"
                                            value="{{ old('label_as') }}" id="label_as" placeholder="Bengali" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="language">Language</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                            id="name" placeholder="বাংলা" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="language-code">Language Code</label>
                                        <input type="text" class="form-control" name="language_code"
                                            value="{{ old('language_code') }}" id="language_code" placeholder="en-bn"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="language-locale">Language Locale</label>
                                        <input type="text" class="form-control" name="locale"
                                            value="{{ old('locale') }}" id="locale" placeholder="bn" required>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right my-3">
                                <button type="submit" id="language_submit" class="btn btn-success float-right mr-0">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script
    src="{{ App::isProduction() ? secure_asset('assets/js/custom/language.js') : asset('assets/js/custom/language.js') }}">
</script>
@endpush