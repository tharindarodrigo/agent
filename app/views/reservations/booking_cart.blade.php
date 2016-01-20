<?php
$total_cost = 0;
?>

@extends('reservations.reservations')

@section('head-styles')
    {{ HTML::style('css/plugins/iCheck/custom.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('css/plugins/steps/jquery.steps.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">

    <style type="text/css">
        h5 {
            color: #3498db;
        }

        .hotel_list_hide {
            display: none;
        }

        .room_list_hide {
            display: none;
        }

        .hotel_img_1 {
            width: 40px;
            height: 34px;
        }
    </style>

@endsection

@section('reservations-content')

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-md-9">

                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong>5</strong>) items</span>
                        <h5>Items in your cart</h5>
                    </div>

                    <div class="ibox-content">
                        @if(Session::has('rate_box_details'))

                            <div class="table-responsive">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                                    <thead>
                                    <tr>
                                        <th data-toggle="true">Product Name</th>
                                        <th data-hide="all"> Rooms</th>
                                        <th data-hide="phone">Price</th>
                                        <th class="text-right" data-sort-ignore="true">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($hotel_bookings as $hotel_booking)
                                        <tr>
                                            <td style="color: #3498db">
                                                {{ $hotel_booking['hotel_name'] }}
                                            </td>

                                            <td>

                                                @for($c=0 ; $c < count($hotel_booking)-3; $c++)

                                                    <strong> Rooms {{ $c+1 }} &nbsp;&nbsp;&nbsp;</strong>
                                                    <button type="button" class="btn btn-success btn-outline"
                                                            data-toggle="collapse"
                                                            data-target="#{{ $hotel_booking[$c]['room_identity'] }}">
                                                        {{ $hotel_booking[$c]['room_specification'] .'/'. $hotel_booking[$c]['meal_basis'] }}
                                                    </button>
                                                    <br/><br/>

                                                    <div style="width: 500px"
                                                         id="{{ $hotel_booking[$c]['room_identity'] }}"
                                                         class="collapse">
                                                        <div class="row ">
                                                            <div class="col-md-6">
                                                                <div><strong> Check In
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $hotel_booking[$c]['check_in'] }}</strong>
                                                                </div>
                                                                <div><strong> Check Out
                                                                        &nbsp;&nbsp;&nbsp;: {{ $hotel_booking[$c]['check_out'] }} </strong>
                                                                </div>
                                                                <div><strong> Room Type
                                                                        &nbsp;
                                                                        : {{ $hotel_booking[$c]['room_specification'] }}
                                                                        Room </strong></div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div><strong> Meal Basis
                                                                        : {{ $hotel_booking[$c]['meal_basis'] }} </strong>
                                                                </div>
                                                                <div><strong> Adult / Child :
                                                                        : {{ $hotel_booking[$c]['adult'] }}
                                                                        / {{ $hotel_booking[$c]['child'] }} </strong>
                                                                </div>
                                                                <div><strong> Room Count
                                                                        : {{ $hotel_booking[$c]['room_count'] }} </strong>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div>

                                                        </div>
                                                        {{ number_format(($hotel_booking[$c]['room_cost']), 2, '.', '') }}
                                                        <div>

                                                        </div>
                                                        {{ number_format((($hotel_booking[$c]['hotel_tax'] + $hotel_booking[$c]['hotel_handling_fee']) * Session::get('currency_rate') ) , 2, '.', '') }}

                                                        <div>
                                                            {{ number_format(($hotel_booking[$c]['supplement_rate'] ), 2, '.', '') }}
                                                        </div>
                                                        <br/>
                                                    </div>
                                                    <?php $total_cost = $total_cost + $hotel_booking[$c]['room_cost'] + ($hotel_booking[$c]['hotel_tax'] + $hotel_booking[$c]['hotel_handling_fee'] + $hotel_booking[$c]['supplement_rate']); ?>
                                                @endfor
                                            </td>

                                            <td>
                                                <strong style="color: #1ab394">USD {{ number_format(($total_cost), 2, '.', '') }}</strong>
                                            </td>

                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button class="btn-white btn btn-xs">View</button>
                                                    <button class="btn-white btn btn-xs">Edit</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        @endif
                    </div>

                    <div class="ibox-content">
                        <button class="btn btn-primary pull-right"><i class="fa fa fa-shopping-cart"></i> Checkout
                        </button>
                        <button class="btn btn-white"><i class="fa fa-arrow-left"></i> Continue shopping</button>
                    </div>
                </div>

            </div>
            <div class="col-md-3">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5>
                    </div>
                    <div class="ibox-content">
                            <span>
                                Total
                            </span>

                        <h2 class="font-bold">
                            $390,00
                        </h2>

                        <hr/>
                            <span class="text-muted small">
                                *For United States, France and Germany applicable sales tax will be applied
                            </span>

                        <div class="m-t-sm">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Checkout</a>
                                <a href="#" class="btn btn-white btn-sm"> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Support</h5>
                    </div>
                    <div class="ibox-content text-center">

                        <h3><i class="fa fa-phone"></i> +43 100 783 001</h3>
                            <span class="small">
                                Please contact with us if you have any questions. We are avalible 24h.
                            </span>

                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">

                        <p class="font-bold">
                            Other products you may be interested
                        </p>

                        <hr/>
                        <div>
                            <a href="#" class="product-name"> Product 1</a>

                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <a href="#" class="product-name"> Product 2</a>

                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('footer-scripts')

    <!-- Steps -->
    {{HTML::script("js/plugins/staps/jquery.steps.min.js")}}

    <!-- Jquery Validate -->
    {{HTML::script("js/plugins/validate/jquery.validate.min.js")}}

    {{HTML::script("js/plugins/iCheck/icheck.min.js")}}

    <!-- Custom js -->
    {{ HTML::script('js/my_script.js') }}
    {{ HTML::script('js/booking.js') }}

    <!-- FooTable -->
    <script src="js/plugins/footable/footable.all.min.js"></script>

    <!-- Page-Level Scripts -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('.footable').footable();
        });
    </script>

@endsection