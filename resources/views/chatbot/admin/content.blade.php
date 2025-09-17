@extends('layouts.app')
@php
use App\Models\ChatbotModule\Content;
@endphp
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">All Chatbot Content</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $count = 0;
                                @endphp
                                @if ($data->isNotEmpty())
                                @foreach($data as $content)
                                <tr>
                                    <td scope="row">{{ ++$count }}</td>
                                    <td scope="row">{{ $content[Content::title] }}</td>
                                    <td scope="row">{{ $content[Content::description] }}</td>
                                    <td scope="row">
                                        <a href="#" class="px-1 edit-content"
                                            data-id="{{ $content[Content::content_id] }}">
                                            <i class="fas text-primary fa-edit"></i>
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
<div class="modal fade" id="content" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="content-title">Update Content</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form action="{{ route('chatbot.content.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="content_id" id="content_id">
                            <div class="content-fields" id="content-field"></div>
                            <div class="float-right my-3">
                                <button type="submit" class="btn btn-success float-right mr-0">
                                    Update
                                </button>
                                <button type="button" class="btn btn-primary float-right mr-2" id="add-content">
                                    <i class="fa fa-plus"></i>
                                    Add More
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
    src="{{ App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js') }}">
</script>
@endpush