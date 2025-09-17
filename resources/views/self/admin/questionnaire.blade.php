@extends('layouts.app')

@section('content')

@php
    use App\Models\SelfModule\RiskAssessmentQuestionnaire;
@endphp

<div class="row">
	<a href="{{ route('admin.self-risk-assessment.questionnaire', ['export' => true]) }}" class="btn btn-primary float-right w-2 m-2" role="button" id="btn-export-risk-assessment">Export</a>
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Self-Risk Assessment Questionnaire</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        @php
                            $count = 0;
                        @endphp
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Count</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($data as $value)
                                    @if ($value[RiskAssessmentQuestionnaire::question_slug] != 'mobile-number')
                                        <tr>
                                            <td scope="col">{{ ++$count }}</td>
                                            <td scope="col">{{ $value[RiskAssessmentQuestionnaire::question] }}</td>
                                            <td scope="col">{{ $value[RiskAssessmentQuestionnaire::counter] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
