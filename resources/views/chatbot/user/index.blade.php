@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">All Users</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center" id="chatbot-user-details">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Full name</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Zip Code</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" media="all" href="{{asset('assets/css/jquery.dataTables.css')}}">
    <script type="text/javascript" charset="utf8" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js') }}"></script>
@endpush