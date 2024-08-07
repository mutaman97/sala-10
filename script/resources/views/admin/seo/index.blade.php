@extends('layouts.backend.app')

@section('title','SEO Settings')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'SEO Settings'])
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            <div class="card-header">
                <h4>{{ __('SEO Settings') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-xxs">{{ __('ID') }}</th>
                                <th class="text-xxs">{{ __('Site Name') }}</th>
                                <th>{{ __('Mata Tag') }}</th>
                                <th class="text-xxs">{{ __('Twitter Site Title') }}</th>
                                <th class=" text-xxs">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $val)
                            @php
                            $value = json_decode($val->value ?? null)
                            @endphp
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $key+1 }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{$value->{'site_name_'.App::getLocale()} ?? ''}}</p>
                                </td>
                                <td>
                                    {{$value->{'matatag_'.App::getLocale()} ?? ''}}
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{$value->{'twitter_site_title_'.App::getLocale()} ?? ''}}</p>
                                </td>
                                <td class="align-middle">
                                    <a class="btn btn-primary text-light px-3 mb-0" href="{{ route('admin.seo.edit', $val->id) }}"><i class="fas fa-pencil-alt text-light mr-2" aria-hidden="true"></i>{{ __('Edit') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection