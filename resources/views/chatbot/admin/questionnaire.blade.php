@extends('layouts.app')

@php
    use App\Models\ChatbotModule\Questionnaire;
    use App\Models\LanguageModule\Language;
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12 my-2">
            <button class="btn btn-primary float-right new-questionnaire" data-toggle="modal" data-target="#new-greetings">
                <i class="fa fa-plus"></i>
                Add Questionnaire
            </button>
        </div>
        @foreach ($questionnaire as $value)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 my-2">
                                <div class="badge badge-pill badge-info">
                                    Used {{ $value[Questionnaire::counter] }} times
                                </div>
                            </div>
                            <div class="col-md-10 my-2">
                                <button class="btn btn-sm btn-danger float-right mb-2 destroy-question" parent-id="{{ $value[Questionnaire::question_id] }}">
                                    <i class="fa fa-trash"></i>
                                    Delete Questionnaire
                                </button>
                                <button class="btn btn-sm btn-primary float-right mb-2 mr-1 new-question" parent-id="{{ $value[Questionnaire::question_id] }}">
                                    <i class="fa fa-plus"></i>
                                    Add More
                                </button>
                            </div>
                        </div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Language</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach($value[Questionnaire::question] as $question)
                                    <tr>
                                        <td scope="row" width="5%">{{ ++$count }}</td>
                                        <td scope="row" width="5%">{{ $language->where(Questionnaire::locale, $question[Questionnaire::locale])->first()[Language::name] }}</td>
                                        <td scope="row" width="80%">{{ $question[Questionnaire::body] }}</td>
                                        <td scope="row" width="10%">
                                            <a href="#" class="px-1 edit-question" data-body="{{ $question[Questionnaire::body] }}" parent-id="{{ $value[Questionnaire::question_id] }}" data-locale="{{ $question[Questionnaire::locale] }}">
                                                <i class="fas text-primary fa-edit"></i>
                                            </a>
                                            <a href="#" class="px-1 edit-answer-sheet" data-body="{{ $question[Questionnaire::body] }}" parent-id="{{ $value[Questionnaire::question_id] }}" data-locale="{{ $question[Questionnaire::locale] }}">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                            @if (!$loop->first)
                                                <a href="#" class="px-1 delete-question" parent-id="{{ $value[Questionnaire::question_id] }}" data-locale="{{ $question[Questionnaire::locale] }}">
                                                    <i class="fas text-danger fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="new-question" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="question-title">Add Question</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="{{ route('chatbot.questionnaire.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="question_id" id="parent_question_id">
                                <div id="question-field"></div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-primary float-right mr-2" id="add-question">
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
    <div class="modal fade" id="edit-question" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="question-title">Update Question</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="{{ route('chatbot.questionnaire.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="question_id" id="self_question_id">
                                <input type="hidden" name="locale" id="self_locale">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="question" id="self_question" placeholder="Enter Question">
                                    </div>
                                </div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="answer-sheet" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="questionnaire-title">Add Answers</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h6 class="modal-title" id="question"></h6>
                                </div>
                            </div>
                            <form action="{{ route('chatbot.questionnaire.update-answers') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="hidden" id="field-type" value="answer">
                                <input type="hidden" name="locale" id="locale">
                                <div id="answer-field"></div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-primary float-right mr-2" id="add-answer">
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
    <script src="{{ App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js') }}"></script>
@endpush