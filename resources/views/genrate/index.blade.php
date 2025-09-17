@extends('layouts.app')
@push('pg_btn')
@can('create-vn-link-genrate')
    <a href="{{ route('genrate.create') }}" class="btn btn-sm btn-neutral">Create New Generate</a>
@endcan
@endpush

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">All Generate</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">App/Platform Name</th>
                                    <th scope="col">Short Url</th>
                                    <th scope="col">Url</th>
									<th scope="col">Description</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($genrate as $plat)
                                    <tr>
										 <td scope="row">
                                            {{$plat->name}}
                                        </td>
                                        <td>{{$plat->tinyurl}}</td>
                                        <td scope="row">
                                            <input type="hidden" value="{{$plat->tinyurl}}" id="copy_text_{{$plat->id}}"> 
											<i class="fas fa-copy" onclick="copyUrl({{$plat->id}})" ></i>
											
                                        </td>
										<td>{{$plat->detail}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        {{$genrate->links()}}
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
        function copyUrl(id) {
			
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($("#copy_text_"+id).val()).select();
		  document.execCommand("copy");
		  $temp.remove();
		  alert("Copy URL");
		}
		
    </script>
@endpush