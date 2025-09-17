@extends('layouts.app')
@push('pg_btn')
@can('create-vm')
    <a href="{{ route('user.vms.create') }}" class="btn btn-sm btn-neutral">Create New User VMS</a>
@endcan
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All PO/CO/VN</h3>
                        </div>
                        <div class="col-lg-4">
                    {!! Form::open(['route' => 'user.vms', 'method'=>'get']) !!}
                        <div class="form-group mb-0">
                        {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search VN']) }}
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
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th> 
									<th scope="col">VM Code</th>
									<th scope="col">Phone</th> 	
									<th scope="col">State</th> 									
									<th scope="col">Region</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>  									
                                    
                                </tr>
                                </thead>
                                <tbody class="list">
									@foreach($vms_list as $key=>$list)
									
										<?php 
											$state_name='';
											if(!empty($list->state_code)){
												$state_codeArr = explode(",",$list->state_code);
												$results = App\Models\StateMaster::getStateName($state_codeArr);
												if($results->count() > 0){
													foreach($results as $key=>$val){
														$state_name.= $val->state_name." ,";
													}
												}
											}	
											?>
										<tr>
											<td >{{$list->name}}</td>
											<td >{{$list->last_name}}</td>
											<td >{{$list->email}}</td>  
											<td >{{$list->vncode}}</td>  											
											<td >{{$list->mobile_number}}</td>  											
											<td >{{rtrim($state_name,',')}}</td>  											
											<td >{{strtoupper($list->region)}}</td>  											
											<td >
											@if($list->status==1)
												<a href="javascript:;" class="btn btn-sm btn-info  mr-4 " onclick="return userStatus({{$list->id}},'DeActive');">Active</a>
											@else 
												<a href="javascript:;" class="btn btn-sm btn-danger  mr-4 " onclick="return userStatus({{$list->id}},'Active');">De-Active</a>
											@endif
											</td>  											
											<td >
											@can('update-user')
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit Vn details" href="{{route('vn.edit',$list)}}">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
											
											<a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Password" href="{{route('vn.pass',$list)}}">
                                                <i class="fa fa-key" aria-hidden="true"></i>
                                            </a>																						
											
                                            @endcan
											</td>  											
											
										</tr>
									@endforeach
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        {{$vms_list->links()}}
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
    <script>
       
	  function userStatus(ursid, type){
		  
		   var con = confirm("Are you sure? you want to change status?");
		   if(!con)
			  return false;
		  
			var jsonData = {"_token": "{{ csrf_token() }}","ursid": ursid,"type":type}
				$.ajax({
					type:'POST',
					url: "{{ route('usr.staus.update')}}",
					data: jsonData,
					dataType:"json",
					success: (data) => {
						console.log(data);
						window.location.href=window.location.href;	
					},
					error: function(data){
						console.log(data);
					}
				});				
	  }
    </script>
@endpush
