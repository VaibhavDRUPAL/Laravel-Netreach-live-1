@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Analytics Dashboard</h1>

        <!-- Cards for aggregated page views -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <h3 class="card-title">Total Site Visits </h3>
                                <h2 class="card-text">{{ number_format($counts['total']) }}</h2>
                            </div>
                            {{-- <div class="col-3">
                                <div class="ab-icon-info ab-dark-blue">
                                    <img height="50" width="50"
                                        src="{{ asset('assets/img/icons/dashboard-icon/eye.png') }}">
                                </div>
                            </div> --}}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/our-team">Counsellers Page Visits</h4>
                        <h2 class="card-text">{{ number_format($counts['ourTeam']) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/contact-us">VN/Counsellers Contact Page Visits</h4>
                        <h2 class="card-text">{{ number_format($counts['contactUs']) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/sra">General Links</h4>
                        <h2 class="card-text">{{ number_format($counts['sra']) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/self-risk-assessment">Self Risk Assessment Page Views</h4>
                        <h2 class="card-text">{{ number_format($counts['selfRiskAssessment']) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
