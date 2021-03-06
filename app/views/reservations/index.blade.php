@extends('reservations.reservations')

@section('head-styles')
    {{ HTML::style('css/plugins/iCheck/custom.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}
    {{ HTML::style('css/plugins/steps/jquery.steps.css' , array('rel' => 'stylesheet' , 'media' => 'screen')) }}

    <style type="text/css">
        h5 {
            color: #3498db;
        }

        strong{
            font-size: 12px;
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

        .hotel_star, .filter_room_type, .filter_meal_type {
            margin: 0px !important;
        }

        hr {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        /*select {*/
        /*height: 20px !important;*/
        /*-webkit-appearance: none;*/
        /*font-size: 6px !important;*/
        /*}*/

        /*select option {*/
        /*font-size: 12px !important;*/
        /*}*/

    </style>

@endsection

@section('reservations-content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Reservations</h5>

                    </div>
                    <div class="ibox-content">

                        {{ Form::open(array('url' => '/reservations', 'files'=> true, 'id' => 'reservation_form', 'class' => 'wizard-big', 'method' => 'POST', )) }}

                        <fieldset>
                            <h2>Hotel Information</h2>
                            <br/>

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label>Where do you want to go? *</label><br/>

                                        <input type="text" class="form-control required" name="txt-search"
                                               id="inputString"
                                               onkeyup="lookup(this.value);" autocomplete="off"/>

                                        <div id="suggestions"></div>

                                    </div>

                                    <div class="form-group" id="data_1">
                                        <label>Check In *</label><br/>

                                        <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text" class="form-control" name="st_date"
                                                   value="{{ Session::has('st_date') ? Session::get('st_date') : $st_date }}">
                                        </div>
                                    </div>

                                    <div class="form-group" id="data_1">
                                        <label>Check Out *</label><br/>

                                        <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text" class="form-control" name="ed_date"
                                                   value="{{ Session::has('ed_date') ? Session::get('ed_date') : $ed_date }}">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="col-md-7">
                                            <label class="checkbox-inline i-checks">
                                                <input class="icheckbox_square-green" type="checkbox"
                                                       name="availability" id="chk_availability">
                                                <label style="margin-top: 5px">&nbsp; Check Availability </label>
                                            </label>
                                        </div>

                                        <div class="room_count_hide col-md-5">
                                            <label>No Of Rooms</label><br/>

                                            {{ Form::selectRange('room_count', 1, 10, null, ['class' => 'form-control m-b room_count', 'id' => '']) }}
                                        </div>
                                    </div>

                                    <div class="room_type form-group row">
                                        <div class="col-lg-6">
                                            <label> Room Type </label>

                                            <div class="form-group">
                                                {{ Form::select('room_type', RoomSpecification::lists('room_specification', 'id'), null, array('class' => 'form-control m-b', 'id' => '')) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Meal Basis </label>

                                            <div class="form-group">
                                                {{ Form::select('meal_basis', MealBasis::lists('meal_basis_name', 'id'), null, array('class' => 'form-control m-b', 'id' => '')) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <br/><br/>
                                        <button class="btn search_submit btn-primary" type="button">
                                            <i class="fa fa-check"></i>&nbsp; Search
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </fieldset>

                        {{Form::close()}}

                    </div>
                </div>
            </div>

            @if(Session::has('reservation'))
                @if(Session::get('reservation') == 1 || Session::get('reservation') == 2 || Session::has('txt-search'))
                    <div class="hotel_list col-lg-4">
                        <div class="ibox">
                            <div class="ibox-title">
                                <div class="row">
                                    <div class="row">
                                        <div class="container col-md-12">
                                            <h5> &nbsp;&nbsp;&nbsp; {{ $city_or_hotel }} ~> From
                                                : {{ Session::get('st_date') .' to : '. Session::get('ed_date'); }}</h5>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-2">
                                                <strong> Stars </strong>
                                            </div>

                                            {{ Form::open(array('url' => '/reservations', 'files'=> true, 'id' => 'star_filter_form', 'class' => 'wizard-big', 'method' => 'POST', )) }}
                                            <div class="col-md-4">
                                                {{ Form::selectRange('hotel_star', 1, 5, null, ['class' => 'col-md-4 form-control m-b hotel_star', 'id' => '']) }}
                                            </div>
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ibox-content">
                                <?php //$z = array(); ?>
                                @foreach($hotels as $hotel)
                                    <?php

                                    //echo public_path();
                                     //       dd(__DIR__);
                                    $directory = 'home/srilanka/public_html/images/hotel_images/';
                                    $images = glob($directory . $hotel->hotel_id . "_*");
                                    $img_path = array_shift($images);
                                    $img_name = basename($img_path);
                                    ?>
                                    {{--@if(!in_array($hotel->hotel_id, $z))--}}
                                    <div class="feed-activity-list">
                                        <div style="padding-top: 10px; padding-bottom: 10px" class="feed-element">
                                            <a href="#" class="pull-left">
                                                @if(count($img_path)>0)
                                                    {{ HTML::image('http://srilankahotels.travel/images/hotel_images/'.$img_name, '', array('class' => 'hotel_img_1'))}}
                                                @else
                                                    {{ HTML::image('http://srilankahotels.travel/images/no-image.jpg', '', array('class' => 'hotel_img_1')) }}
                                                @endif
                                            </a>

                                            <div class="media-body ">

                                                <?php
                                                $low_hotel_rate = Rate::lowestHotelRate($hotel->hotel_id, $st_date, $ed_date);
                                                //dd($hotel->hotel_id);
                                                $stars = Hotel::Where('id', $hotel->hotel_id)->first()->star_category_id;
                                                $star = StarCategory::where('id', $stars)->first();
                                                $hotel_star = $star->stars;
                                                ?>
                                                @if($low_hotel_rate > 0)
                                                    <button hotel_id="{{ $hotel->hotel_id }}"
                                                            class="pull-right book_hotel btn-xs btn-primary"
                                                            type="submit">
                                                        <i class="fa fa-check"></i>&nbsp;View
                                                    </button>
                                                @else
                                                    <button hotel_id="{{ $hotel->hotel_id }}" data-toggle="modal"
                                                            data-target="#myModa{{ $hotel->hotel_id }}"
                                                            style="background: #d75124; border-color: #d75124"
                                                            class="pull-right btn-xs btn-info"
                                                            type="button"> Request
                                                    </button>

                                                    <div class="modal inmodal" id="myModa{{ $hotel->hotel_id }}" tabindex="-1" role="dialog"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content animated flipInY">
                                                                {{ Form::open(array('url' => '/request-rate', 'files'=> true, 'id' => 'rate_request_form', 'class' => 'wizard-big', 'method' => 'POST', )) }}
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                    <h4 class="modal-title"> {{ Hotel::Where('id', $hotel->hotel_id)->first()->name }} </h4>
                                                                    <small class="font-bold">you can request rates from
                                                                        here..
                                                                    </small>
                                                                </div>
                                                                <div class="modal-body">

                                                                    {{ Form::hidden('hotel_id', $hotel->hotel_id) }}

                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <div class="col-md-6">
                                                                                <label> Room Specification </label>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                {{ Form::select('room_specification', RoomSpecification::lists('room_specification', 'id'), null, array('class' => 'form-control m-b', 'id' => '')) }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-6">
                                                                                <label>Meal Basis </label>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                {{ Form::select('meal_basis', MealBasis::lists('meal_basis_name', 'id'), null, array('class' => 'form-control m-b', 'id' => '')) }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-6">
                                                                                <label> Room Type </label>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                {{ Form::select('room_type', RoomType::Where('hotel_id', $hotel->hotel_id)->lists('room_type', 'id'), null, array('class' => 'form-control m-b', 'id' => '')) }}
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-white"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Send
                                                                        Request
                                                                    </button>
                                                                </div>
                                                                {{Form::close()}}
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif

                                                <strong>{{ Hotel::Where('id', $hotel->hotel_id)->first()->name }}</strong>
                                                <br>
                                                <small class="text-muted"> {{ Hotel::star_loop_blue($hotel_star)}} -
                                                    {{  City::where('id', Hotel::Where('id', $hotel->hotel_id)->first()->city_id)->first()->city }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php  //$z[] = $hotel->hotel_id; ?>
                                    {{--@endif--}}
                                @endforeach

                                <div class="btn-group">
                                    {{ $hotels->links() }}
                                </div>

                            </div>

                        </div>
                    </div>
                @endif
            @endif

            <div id="room_rates_list" class="hotel_list col-lg-4">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="row">
                                <div class="container col-md-12">
                                    <h5 id="hotel_name_h5"></h5>
                                </div>
                            </div>
                            <hr/>

                            <div class="row">
                                <div class="col-md-12">

                                    {{ Form::open(array('url' => '/get_hotel_details', 'files'=> true, 'id' => 'filter_room_form', 'class' => 'wizard-big', 'method' => 'POST', )) }}
                                    <div class="col-md-6">
                                        {{ Form::select('filter_room_type', RoomSpecification::lists('room_specification', 'id'), null, array('class' => 'form-control m-b filter_room_type', 'id' => '')) }}
                                    </div>
                                    {{Form::close()}}


                                    {{ Form::open(array('url' => '/get_hotel_details', 'files'=> true, 'id' => 'filter_meal_form', 'class' => 'wizard-big', 'method' => 'POST', )) }}
                                    <div class="col-md-6">
                                        {{ Form::select('filter_meal_type', MealBasis::lists('meal_basis_name', 'id'), null, array('class' => 'form-control m-b filter_meal_type', 'id' => '')) }}
                                    </div>
                                    {{Form::close()}}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <div id="room_rates" class="feed-activity-list">

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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#room_rates_list').hide();
            $('.room_count_hide').hide();
            $('.room_type').hide();
        });
    </script>

    <script type="text/javascript">
        $('#chk_availability').change(function () {
            if ($(this).is(":checked")) {
                $('.room_count_hide').show();
                $('.room_type').show();
            } else {
                $('.room_count_hide').hide();
                $('.room_type').hide();
            }
        });

        $('.book_hotel').click(function () {
            var hotel_id = $(this).attr('hotel_id');

            var url = 'http://' + window.location.host + '/get_hotel_details';
            var formData = new FormData();
            formData.append('hotel_id', hotel_id);

            sendBookingData(url, formData);

        });

        $('.search_submit').click(function () {

            var txt_search = $('#inputString').val();

            if (!txt_search) {
                toastr.error('Please Type Something To Search....!!');
            } else {
                $('#reservation_form').submit();
            }
        });

        $('.hotel_star').change(function () {
            $('#star_filter_form').submit();

        });

        $('.filter_room_type').change(function () {
            var room_type = $(this).val();

            var url = 'http://' + window.location.host + '/get_hotel_details';
            var formData = new FormData();
            formData.append('room_type', room_type);

            sendBookingData(url, formData);

        });

        $('.filter_meal_type').change(function () {
            var meal_type = $(this).val();

            var url = 'http://' + window.location.host + '/get_hotel_details';
            var formData = new FormData();
            formData.append('meal_type', meal_type);

            sendBookingData(url, formData);

        });


        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });


    </script>

@endsection