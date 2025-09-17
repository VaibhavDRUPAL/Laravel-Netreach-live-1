@extends('layouts.app')
@push('pg_btn')

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All District</h3>
                        </div>
						
						<div class="col-lg-4">
							{!! Form::open(['route' => 'district.index', 'method'=>'get']) !!}
								<div class="form-group mb-0">
								{{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search District']) }}
							</div>
							{!! Form::close() !!}
						</div>
                       
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                           
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($district as $val)
                                    <tr>
                                        <th scope="row">
                                            {{$val->district_name}}
                                        </th>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        {{$district->links()}}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
   
@endpush
