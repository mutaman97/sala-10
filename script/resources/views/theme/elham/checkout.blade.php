@extends('theme.elham.layouts.app')
@section('content')

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url()->current() }}">{{ $page_data->cart_page_title ?? __('Checkout') }}</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="shopping-cart shopping-cart-shipping">
                    @if(Cart::instance('default')->count() != 0)
                        <form id="checkoutForm" action="{{ route('make.order') }}" method="post" id="form-guest-shipping" class="validate-form orderform">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    <div class="left">
                                        <h1 class="cart-section-title">{{ $page_data->cart_page_title ?? __('Checkout') }}</h1>
                                        {{-- <p>{{ $page_data->cart_page_description ?? '' }}</p> --}}
                                        <div class="tab-checkout tab-checkout-open m-t-0">
                                            @if(Auth::check() == false)
                                                <p class="font-600 text-center m-b-30">
                                                    {{ __('You are checking out as a guest.') }}&nbsp;{{ __('Do You Have Account?') }}&nbsp;
                                                    <a href="javascript:void(0)" class="link" data-toggle="modal" data-target="#loginModal">
                                                        <strong class="link-underlined">{{ __('Login') }}</strong>
                                                    </a>
                                                </p>
                                            @endif
                                            {{-- <h2 class="title">1.&nbsp;&nbsp;{{ __('Shipping Information') }}</h2> --}}
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-12 cart-form-shipping-address">
                                                    <p class="text-shipping-address">{{ __('Shipping Address') }}</p>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label>{{ __('Name') }}</label>
                                                                <input type="text" name="name" class="form-control form-input" value="{{ Auth::check() ? Auth::user()->name : old('name', '') }}" maxlength="250" required>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <label>{{__('Email Address')}}</label>
                                                                <input type="email" name="email" class="form-control form-input" value="{{ Auth::check() ? Auth::user()->email : old('email', '') }}" maxlength="250" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label>{{__('Phone Number')}}</label>
                                                                <input type="number" name="phone" class="form-control form-input" value="{{ Auth::check() ? Auth::user()->phone : old('phone', '') }}" maxlength="250" required>
                                                            </div>
                                                            @if(count($locations) != 0)
                                                                <div class="col-12 col-md-6  delivery_address_area">
                                                                    <label>{{ __('Select Delivery Area') }}</label>
                                                                    <select id="locations" name="location" class="select2 select2-req form-control" data-placeholder="{{ __('Location') }}" required>
                                                                        <option value="" selected="" disabled=""></option>
                                                                        @foreach($locations as $key => $row)
                                                                            <option value="{{ $row->id }}" data-shipping="{{ $row->shippings }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group delivery_address_area">
                                                        <label>{{ __('Delivery Address') }}</label>
                                                        <input type="text" name="address" id="location_input" class="form-control form-input location_input" value="{{ $meta->address ?? '' }}" maxlength="250" required>
                                                    </div>
                                                    @if(count($locations) != 0)
                                                        <div class="form-group  post_code_area">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label class="control-label">{{ __('Zip Code') }}</label>
                                                                    <input type="text" name="post_code" placeholder="Enter your zip code" class="form-control form-input" value="{{ $meta->post_code ?? old('post_code', '') }}" maxlength="90" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <label class="control-label">{{ __('Comment') }}</label>
                                                        <textarea name="description" class="form-control form-textarea" placeholder="{{ __('Add any extra information') }}" minlength="5" maxlength="1000" required></textarea>
                                                    </div>
                                                </div>
                                                @if($order_settings->shipping_amount_type == 'distance')
                                                    <div class="col-12 map_area">
                                                        <div class="form-group">
                                                            <p class="text-danger alert_area"></p>
                                                            <div id="map-canvas" class="map-canvas">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(Auth::check() == false)
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" value="1" id="create_account" checked>
                                                                <label for="create_account" class="custom-control-label">{{ __('Do you want to create an account?') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 cart-form-billing-address" style="display: block;">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label>{{ __('Add Password') }}</label>
                                                                    <input type="password" name="password" class="form-control form-input" placeholder="Password" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-4 order-summary-container">
                                    <h2 class="cart-section-title">{{ __('Order Summary') }}</h2>
                                    <div class="right">
                                        <div class="cart-order-details checkout_page">
                                            {{-- Checkout page --}}
                                        </div>
                                        <div class="row-custom m-t-30 m-b-10">
                                            <strong>{{ __('Subtotal') }}<span class="float-right cart_subtotal">{{ Cart::instance('default')->subtotal() }}</span></strong>
                                        </div>
                                        <div class="row-custom m-b-10">
                                            <strong>{{ __('Tax') }}<span class="float-right cart_tax">{{ Cart::instance('default')->discount() }}</span></strong>
                                        </div>
                                        <div class="row-custom m-b-10">
                                            <strong>{{__('Shipping Fee')}}<span class="float-right shipping_fee">0.00</span></strong>
                                        </div>
                                        @if (session()->has('coupon'))
                                            <div class="row-custom m-b-15">
                                                <form id="removeCartDiscountForm" action="{{ route('removediscount') }}" method="post">
                                                    @csrf
                                                    {{-- TODO Cart Discount JavaScript --}}
                                                    <strong>{{ __('Coupon') }}&nbsp;&nbsp;[{{ session()->get('coupon')['name'] ?? '' }}]&nbsp;&nbsp;<a href="javascript:void(0)" class="font-weight-normal" onclick="removeCartDiscountCoupon();" type="button">[remove]</a><span class="float-right cart_discount render_currency">-&nbsp;{{ Cart::instance('default')->discount() }}</span></strong>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="row-custom">
                                            <strong>{{ __('Total') }}<span class="float-right render_currency cart_total">{{ Cart::instance('default')->total() }}</span></strong>
                                        </div>
                                        <div class="row-custom">
                                            <p class="line-seperator"></p>
                                        </div>
                                        @if($pickup_order == 'off')
                                            <div class="row-custom m-b-15">
                                                <p class="text-shipping-address">{{ __('Order Method') }}</p>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="radio" class="custom-control-input order_method" name="order_method" value="delivery" @if($order_method == 'delivery') checked="" @endif id="is_pickup1">
                                                        <label for="is_pickup1" class="custom-control-label">{{ __(' Delivery') }}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="radio" class="custom-control-input order_method" name="order_method" value="pickup" @if($order_method == 'pickup') checked="" @endif id="is_pickup">
                                                        <label for="is_pickup" class="custom-control-label">{{ __(' Pickup') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input  type="hidden" name="order_method" class="order_method none" value="delivery" >
                                        @endif
                                        @if($order_settings->shipping_amount_type != 'distance')
                                            <div class="row-custom m-b-15 shipping_method_area none">
                                                <p class="text-shipping-address">{{ __('Delivery Method') }}</p>
                                                <div class="shipping_render_area">
                                                    {{-- Shipping Method --}}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row-custom">
                                            <p class="line-seperator"></p>
                                        </div>
                                        <div class="row-custom m-b-15 accordion" id="paymentac">
                                            <p class="text-shipping-address">{{ __('Payment Method') }}</p>
                                            @foreach($getways as $getway)
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox" id="headingThree">
                                                        <input
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseThree{{ $getway->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseThree"
                                                        name="payment_method"
                                                        class="custom-control-input getway accordion-button getway_btn"
                                                        id="getway{{ $getway->id }}"
                                                        type="radio"
                                                        data-logo="{{ $getway->logo }}"
                                                        data-rate="{{ $getway->rate }}"
                                                        data-charge="{{ $getway->charge }}"
                                                        data-currency="{{ $getway->currency_name }}"
                                                        data-instruction="{{ $getway->instruction }}"
                                                        data-id="{{ $getway->id }}"
                                                        value="{{ $getway->id }}">

                                                        <label for="getway{{ $getway->id }}" class="custom-control-label">{{ $getway->name }}</label>
                                                    </div>
                                                </div>
                                                <div id="collapseThree{{ $getway->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#paymentac">
                                                    <div class="accordion-body">
                                                        <div class="item">
                                                            <div class="list-item m-t-15">
                                                                <label>{{ __('Currency') }}&nbsp;:</label>
                                                                <strong class="lbl-price">{{ __($getway->currency_name) }}</strong>
                                                            </div>
                                                            <div class="list-item">
                                                                <label>{{ __('Currency Rate') }}&nbsp;:</label>
                                                                <strong class="lbl-price">{{ $getway->rate }}</strong>
                                                            </div>
                                                            <div class="list-item">
                                                                <label>{{ __('Payment Charge') }}&nbsp;:</label>
                                                                <strong class="lbl-price">{{ $getway->charge }}</strong>
                                                            </div>
                                                            <div class="list-item d-flex flex-column">
                                                                <label class="m-b-10">{{ __('Payment instructions') }}&nbsp;:</label>
                                                                <strong>{{ $getway->instruction }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="row-custom">
                                            <p class="line-seperator"></p>
                                        </div>
                                        <div class="row-custom m-b-15 payments">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input  value="1" type="checkbox" class="custom-control-input pre_order" name="pre_order" value="delivery" id="pre_order">
                                                    <label for="pre_order" class="custom-control-label">{{ __('is this pre-order?') }}</label>
                                                </div>
                                            </div>
                                            <div class="pre_order_area d-none">
                                                <div class="form-group">
                                                    <label>{{ __('Delivery Date?') }}</label>
                                                    <input type="date" name="date" class="form-control date">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('Delivery Time?') }}</label>
                                                    <input type="time" id="time"  class="form-control">
                                                    <input type="hidden" name="time" class="time">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="shipping_fee" name="shipping_fee">
                                        <input type="hidden" id="total_price" name="total_price">
                                        <input type="hidden" id="my_lat" name="my_lat" value="{{ $meta->lat ?? '' }}">
                                        <input type="hidden" id="my_long" name="my_long" value="{{ $meta->long ?? '' }}">
                                        <div class="row-custom m-t-30 m-b-15">
                                            <div class="button">
                                                <a id="checkoutSubmitButton" href="javascript:void(0)" class="btn btn-block submitbtn" onclick="submitCheckoutForm();" type="button">{{ __('Continue to checkout') }}</a>
                                            </div>
                                        </div>
                                        <div class="payment-icons">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{ asset('theme/modesy/img/payment/visa.svg') }}" alt="visa" class="lazyload">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{ asset('theme/modesy/img/payment/mastercard.svg') }}" alt="mastercard" class="lazyload">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{ asset('theme/modesy/img/payment/maestro.svg') }}" alt="maestro" class="lazyload">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{ asset('theme/modesy/img/payment/amex.svg') }}" alt="amex" class="lazyload">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{ asset('theme/modesy/img/payment/discover.svg') }}" alt="discover" class="lazyload">
                                        </div>
                                        @if (!session()->has('coupon'))
                                            <hr class="m-t-30 m-b-30">
                                            <form action="{{ route('makediscount') }}" method="post" class="m-0 ajaxform_with_reload">
                                                @csrf
                                                <label class="font-600">{{ __('Discount Coupon') }}</label>
                                                <div class="cart-discount-coupon">
                                                    <input type="text" name="coupon" class="form-control form-input" value="{{ old('coupon') ?? '' }}" maxlength="254" placeholder="{{ __('Enter Your Coupon') }}" required>
                                                    <button type="submit" class="btn basicbtn btn-custom m-l-5">{{ __('Apply') }}</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="row">
                            <div class="alert alert-danger" role="alert">
                                {{ __('No Cart Item Available For Checkout') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>







{{--


<!-- Start Checkout -->
<section class="shop checkout p-top-40 p-btm-70 section">
	<div class="container">
		@if(Cart::instance('default')->count() != 0)
		<form class="form orderform" method="post" action="{{ route('make.order') }}">
			@csrf
			<div class="row">
				<div class="col-lg-8 col-12">
					<div class="checkout-form m-top-30">
						<div class="checkout-form-inner">
							<div class="checkout-heading">
								<h2>{{ __('Personal Details') }}</h2>
							</div>
							<!-- Form -->

							<div class="row">
								<div class="col-lg-12 col-md-12 col-12">
									@if ($errors->any())

									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
									@endif
									@if (Session::has('error'))
									<div class="alert alert-danger">
										<ul>

											<li>{{ Session::get('error') }}</li>

										</ul>
									</div>
									@endif
									@if (Session::has('alert'))
									<div class="alert alert-danger">
										<ul>

											<li>{{ Session::get('alert') }}</li>

										</ul>
									</div>
									@endif
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Name') }}<span>*</span></label>
										<input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="" required="required">
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Email Address') }}<span>*</span></label>
										<input value="{{ Auth::check() ? Auth::user()->email : '' }}" type="email" name="email" placeholder="" required="required">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ __('Phone Number') }}<span>*</span></label>
										<input type="number" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="" required="required" maxlength="20">
									</div>
								</div>

								@if(count($locations) != 0)
								<div class="col-lg-6 col-md-6 col-12 delivery_address_area">
									<div class="form-group">
										<label>{{ __('Select Delivery Area') }}<span>*</span></label>
										<select name="location" id="locations" >
											<option value="" selected="" disabled=""></option>
											@foreach($locations as $key => $row)
											<option value="{{ $row->id }}" data-shipping="{{ $row->shippings }}"
												>{{ $row->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									@endif
									<div class="col-lg-6 col-md-6 col-12 delivery_address_area">
										<div class="form-group">
											<label>{{ __('Delivery Address') }} <span>*</span></label>
											<input type="text" class="location_input" id="location_input" name="address" placeholder=""  value="{{ $meta->address ?? '' }}">
										</div>
									</div>
									@if(count($locations) != 0)
									<div class="col-lg-6 col-md-6 col-12 post_code_area">
										<div class="form-group">
											<label>{{ __('Postal Code') }}<span>*</span></label>
											<input type="text" name="post_code" placeholder="" value="{{ $meta->post_code ?? '' }}" >
										</div>
									</div>
									@endif
									@if($order_settings->shipping_amount_type == 'distance')
									<div class="col-lg-12 col-md-12 col-12 map_area">
										<div class="form-group">
											<p class="text-danger alert_area"></p>
											<div class="map-canvas h-300" id="map-canvas">

											</div>

										</div>
									</div>
									@endif
									<div class="col-lg-12 col-md-12 col-12">
										<div class="form-group">
											<label>{{ __('Comment') }}</label>
											<textarea class="form-control h-150" name="comment" maxlength="300"></textarea>
										</div>
									</div>

									@if(Auth::check() == false)
									<div class="col-lg-6 col-md-6 col-12">
										<div class="form-group create-account">
											<input id="create_account" type="checkbox" value="1">
											<label for="create_account">{{ __('Create an account?') }}</label>

										</div>
										<div class="form-group  password_area none mt-2">
											<input type="password" name="password" placeholder="Password" >
										</div>
									</div>
									@endif
								</div>

							<!--/ End Form -->
						</div>

					</div>
				</div>
				<div class="col-lg-4 col-12">
					<div class="order-details m-top-30">
						<h2 class="payment-side-title">{{ __('Your Order') }}</h2>
						<!-- Order Widget -->
						<div class="single-widget order-dt">
							@if($pickup_order == 'on')
							<div class="cart-img-head">
								<input  type="radio" name="order_method" id="is_pickup" class="order_method" value="pickup" @if($order_method == 'pickup') checked="" @endif>
								<label for="is_pickup">&nbsp{{ __(' Pickup') }}</label>
								<input type="radio" name="order_method" id="is_pickup1" class="order_method" value="delivery" @if($order_method == 'delivery') checked="" @endif>
								<label for="is_pickup1">&nbsp{{ __(' Delivery') }}</label>
							</div>
							@else
							<input  type="hidden" name="order_method" class="order_method none" value="delivery" >
							@endif
							<div class="content">
								<ul>
									<li>{{ __('Subtotal') }}
										<span class="cart_subtotal">
											0.00
										</span>
									</li>
									<li>(+) {{ __('Tax') }}
										<span class="cart_tax">
											0.00
										</span>
									</li>
									<li>(+) {{ __('Delivery fee') }}<span class="shipping_fee">0.00</span></li>

									<li class="last">{{ __('Total') }}<span class="cart_total">0.00</span></li>
								</ul>
							</div>
						</div>
						<!--/ End Order Widget -->
						@if($order_settings->shipping_amount_type != 'distance')
						<div class="single-widget payments shipping_method_area none">
							<h2 class="payment-side-title">{{ __('Shipping Method') }}</h2>
							<div class="content">
								<div class="checkbox shipping_render_area accordion">

								</div>
							</div>
						</div>
						@endif
						<!-- Order Widget -->
						<div class="single-widget payments">
							<h2 class="payment-side-title">{{ __('Payment Method') }}</h2>
							<div class="content">
								<div class="accordion" id="paymentac">
									@foreach($getways as $getway)
									<div class="payment-list-item">
										<h2 class="accordion-header" id="headingThree">
											<button class="accordion-button getway_btn collapsed getway"
											type="button"
											data-bs-toggle="collapse"
											data-bs-target="#collapseThree{{ $getway->id }}"
											aria-expanded="false"
											aria-controls="collapseThree"
											data-logo="{{ asset($getway->logo) }}"
											data-rate="{{ $getway->rate }}"
											data-charge="{{ $getway->charge }}"
											data-currency="{{ $getway->currency_name }}"
											data-instruction="{{ $getway->instruction }}"
											data-id="{{ $getway->id }}">

												<input
												name="payment_method"
												class="getway "
												id="getway{{ $getway->id }}"
												type="radio"
												data-logo="{{ $getway->logo }}"
												data-rate="{{ $getway->rate }}"
												data-charge="{{ $getway->charge }}"
												data-currency="{{ $getway->currency_name }}"
												data-instruction="{{ $getway->instruction }}"
												data-id="{{ $getway->id }}"
												value="{{ $getway->id }}">

												<label class="checkbox-inline" for="getway{{ $getway->id }}"></label>{{ $getway->name }}
											</button>
										</h2>
										<div id="collapseThree{{ $getway->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#paymentac">
											<div class="accordion-body">
												<ul>
													<li class="currency_area none">
														{{ __('Currency : ') }} {{ $getway->currency_name }}
													</li>
													<li class="rate_area none">
														{{ __('Currency Rate : ') }} {{ $getway->rate }}
													</li>
													<li class="charge_area none">
														{{ __('Payment Charge : ') }} {{ $getway->charge }}
													</li>
													<li class="instruction_area  none">
														{{ __('Payment instruction : ') }} {{ $getway->instruction }}
													</li>
												</ul>

											</div>
										</div>
									</div>
									@endforeach


								</div>

							</div>

						</div>

						<div class="single-widget payments">
							<h2 class="payment-side-title"><input type="checkbox" id="pre_order" class="pre_order" name="pre_order" value="1"> <label for="pre_order">{{ __('Pre Order ?') }}</label></h2>
							<div class="content pre_order_area none">
								<div class="">
									<div class="form-group">
										<label>{{ __('Delivery Date ?') }}</label>
										<input type="date" name="date" class="form-control date">
									</div>
									<div class="form-group">
										<label>{{ __('Delivery Time ?') }}</label>
										<input type="time" id="time"  class="form-control">
										<input type="hidden" name="time" class="time">
									</div>
								</div>
							</div>
						</div>

						<input type="hidden" id="shipping_fee" name="shipping_fee">
						<input type="hidden" id="total_price" name="total_price">
						<input type="hidden" id="my_lat" name="my_lat" value="{{ $meta->lat ?? '' }}">
						<input type="hidden" id="my_long" name="my_long" value="{{ $meta->long ?? '' }}">
						<!--/ End Order Widget -->
						<!-- Button Widget -->
						<div class="single-widget get-button">
							<div class="content">
								<div class="button">
									<button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</button>
								</div>
							</div>
						</div>
						<!--/ End Button Widget -->
						<div class="checkout-bottom">
							<div class="checkout-first"><b>Total</b><span class="cart_total">0.00</span></div>
							<div class="button">
								<button type="submit"  class="btn submit_btn submitbtn">{{ __('Proceed to checkout') }}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		@else
		<div class="row">
			<div class="alert alert-danger" role="alert">
					{{ __('No Cart Item Available For Checkout') }}
				</div>
		</div>
		@endif
	</div>
</section>
<!--/ End Checkout --> --}}



<!--/ End Checkout -->
<input type="hidden" id="subtotal" value="{{ Cart::instance('default')->subtotal() }}">
<input type="hidden" id="tax" value="{{ Cart::instance('default')->tax() }}">
<input type="hidden" id="total" value="{{ Cart::instance('default')->total() }}">
<input type="hidden" id="latitude" value="{{ tenant('lat') }}">
<input type="hidden" id="longitude" value="{{ tenant('long') }}">
<input type="hidden" id="city" value="{{ $invoice_data->store_legal_city ?? '' }}">
@endsection





@php
$randomNumber = rand();
@endphp


@push('js')
@if($source_code == 'off')
<script type="text/javascript" src="{{ asset('theme/disable-source-code.js') }}"></script>
@endif
<script type="text/javascript">
	"use strict";

	var subtotal=parseFloat($('#subtotal').val());
	var tax=parseFloat($('#tax').val());
	var total=parseFloat($('#total').val());
	var new_total=subtotal;
</script>
@if($order_settings->shipping_amount_type == 'distance')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $order_settings->google_api ?? '' }}&libraries=places&radius=5&location={{ tenant('lat') }}%2C{{ tenant('long') }}&callback=initialize"></script>
<script type="text/javascript">
	"use strict";


	if ($('#my_lat').val() != null) {
		localStorage.setItem('lat',$('#my_lat').val());

	}
	if ($('#my_long').val() != null) {
		localStorage.setItem('long',$('#my_long').val());

	}

	if ($('#location_input').val() != null) {
		localStorage.setItem('location',$('#location_input').val());
	}



	if (localStorage.getItem('location') != null) {
		var locs= localStorage.getItem('location');
	}
	else{
		var locs = "";
	}
	$('#location_input').val(locs);
	if (localStorage.getItem('lat') !== null) {
		var lati=localStorage.getItem('lat');
		$('#my_lat').val(lati)
	}
	else{
		var lati= {{ tenant('lat') }};
	}
	if (localStorage.getItem('long') !== null) {
		var longlat=localStorage.getItem('long');
		$('#my_long').val(longlat)
	}
	else{
		var longlat= {{ tenant('long') }};
	}

	const maxRange= {{ $order_settings->google_api_range ?? 0 }};
	const resturentlocation="{{ $invoice_data->store_legal_address ?? '' }}";
	const feePerkilo= {{ $order_settings->delivery_fee ?? 0 }};

	var mapOptions;
	var map;
	var marker;
	var searchBox;
	var city;
</script>

<script type="text/javascript" src="{{ asset('theme/resto/js/google-api.js') }}"></script>
@endif


<script type="text/javascript" src="{{ asset('theme/checkout.js') }}?v={{ $randomNumber }}"></script>

<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>

@endpush
