@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('genrate.index')}}" class="btn btn-sm btn-neutral">All Genrate</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    {!! Form::open(['route' => 'genrate.store']) !!}
                   
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'App/Platform', ['class' => 'form-control-label']) }}
                                        {{ Form::select('unique_code_link', $genrate, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select App/Platform...']) }}                                  
                                    </div>
                                </div>
								
								
                            </div>
							
							 <div class="row"><div class="col-lg-6">
                                    <div class="form-group">                                        
                                         
										{!! Form::textarea('detail',null,['class'=>'form-control', 'rows' => 2, 'cols' => 30]) !!}										
                                    </div>
                                </div></div>
								
                        <div class="pl-lg-1">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-3 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
