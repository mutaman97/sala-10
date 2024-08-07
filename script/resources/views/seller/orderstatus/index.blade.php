@extends('layouts.backend.app')

@section('title',__('Categories'))

@section('head')
@include('layouts.backend.partials.headersection',['title'=>__('Order Status'),'button_name'=> __('Create New'),'button_link'=> url('seller/orderstatus/create')])
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="Search">{{ __('Search') }}</label>
                         <form method="get">
                            <div class="row">
                                <input name="src" type="text" value="{{ $request->src ?? '' }}" class="form-control col-lg-4 ml-2" placeholder="{{__('Search...')}}">
                            </div>
                         </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Badge Color') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Short') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $ignore_status=[1,2,3];
                                @endphp
                                @foreach($posts as $row)
                                <tr>
                                  <td>{{ $row->name }}</td>
                                  <td><span class="badge text-white" style="background-color: {{ $row->slug }}">{{ $row->slug }}</span></td>
                                  <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                  <td>{{ $row->featured }}</td>
                                  <td class="">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('seller.orderstatus.edit', $row->id) }}"><i class="fa fa-edit"></i></a>
                                        @if(!in_array($row->id,$ignore_status))
                                            <a class="btn btn-sm btn-outline-danger delete-confirm ml-2" href="javascript:void(0)" data-id="{{$row->id}}"><i class="fa fa-trash"></i></a>
                                            <!-- Delete Form -->
                                            <form class="d-none" id="delete_form_{{ $row->id }}" action="{{ route('seller.category.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     {{ $posts->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

