@extends('layouts.backend.app')

@section('title','Brands')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Product Features','button_name'=> 'Create New','button_link'=> url('seller/features/create')])
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
                                <input name="src" type="text" value="{{ $request->src ?? '' }}" class="form-control col-lg-4 ml-2" placeholder="search...">
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center table-borderless">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Preview') }}</th>
                                    <th>{{ __('Short') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $row)
                                <tr>
                                  <td>{{ $row->name }}</td>
                                  <td><img src="{{ asset($row->preview->content ?? '') }}" height="50" alt=""></td>
                                  <td>{{ $row->menu_status }}</td>
                                  <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                  <td class="">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('seller.features.edit', $row->id) }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-outline-danger delete-confirm ml-2" href="javascript:void(0)" data-id="{{$row->id}}"><i class="fa fa-trash"></i></a>
                                        <!-- Delete Form -->
                                        <form class="d-none" id="delete_form_{{ $row->id }}" action="{{ route('seller.category.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                        </form>
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

