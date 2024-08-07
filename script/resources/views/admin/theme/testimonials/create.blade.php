@extends('layouts.backend.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('Testimonial') }}</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Create Testimonial') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.testimonial.store') }}" method="POST" class="ajaxform_with_reset" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Partner Name') }}</label>
                                        <input type="text" name="partner_name" placeholder="Name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Partner Position') }}</label>
                                        <input type="text" name="partner_position" placeholder="Prtner Position" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Testimonial') }}</label>
                                        <textarea name="testimonial" placeholder="Name" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('Store URL') }}</label>
                                        <input type="text" name="store_url" placeholder="URL" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="image">{{ __('Store Image') }}</label>
                                        <input type="file" class="form-control" name="store_image">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">{{ __('Active') }}</option>
                                            <option value="0">{{ __('Deactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="button-btn float-right">
                                        <button type="submit" class="btn btn-primary btn-lg">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
