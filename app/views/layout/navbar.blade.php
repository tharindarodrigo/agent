<nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

        <form role="search" class="navbar-form-custom"
              action="http://webapplayers.com/inspinia_admin-v2.3/search_results.html">
            <div class="form-group">
                <input type="text" placeholder="Search for something..." class="form-control" name="top-search"
                       id="top-search">
            </div>
        </form>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <span class="m-r-sm text-muted welcome-message">{{!empty(Agent::where('user_id',Auth::id())->count()) ? Agent::where('user_id',Auth::id())->first()->company : ''}}</span>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope"></i> <span class="label label-warning" id="inquiry_count"></span>
            </a>
            <ul class="dropdown-menu dropdown-alerts" id="inquiries">


            </ul>

        </li>

        @if(Session::has('rate_box_details'))
            <?php
            $total_cost = 0;
            $total_hotel_amount = 0;
            $bookings = Session::get('rate_box_details');
            $hotel_bookings = [];
            // dd($bookings);

            $rate_keys = array_keys($bookings);

            foreach ($rate_keys as $rate_key) {
                $hotel_id = explode('_', $rate_key)[0];

                $hotel_bookings[$hotel_id][] = $bookings[$rate_key];
                $hotel_bookings[$hotel_id]['hotel_name'] = $bookings[$rate_key]['hotel_name'];
                $hotel_bookings[$hotel_id]['hotel_address'] = $bookings[$rate_key]['hotel_address'];
                $hotel_bookings[$hotel_id]['room_identity'] = $bookings[$rate_key]['room_identity'];
            }
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="label label-primary">
                        {{ count(Session::get('rate_box_details'))  }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-alerts">
                    @foreach($hotel_bookings as $booking)
                        <li>
                            <a href="{{URL::to('/booking-cart')}}">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> {{ $booking['hotel_name'] }}
                                    @for($c=0 ; $c < count($booking)-3; $c++)
                                        <?php $total_cost = $total_cost + $booking[$c]['room_cost'] + ($booking[$c]['hotel_tax'] + $booking[$c]['hotel_handling_fee'] + $booking[$c]['supplement_rate']); ?>
                                    @endfor
                                    <span style="color: #1ab394" class="pull-right text-muted small">
                                        USD {{  number_format(($total_hotel_amount), 2, '.', '')  }}
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php $total_hotel_amount = $total_hotel_amount + $total_cost ?>
                    @endforeach
                    <li>
                        <div class="text-center link-block">
                            <a href="{{URL::to('/booking-cart')}}">
                                <i class="fa-shopping-cart"></i>
                                <strong>View Cart</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

        @else
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-shopping-cart"></i> <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                </ul>
            </li>
        @endif

        <li>
            <a href="{{URL::route('account-sign-out')}}">
                <i class="fa fa-sign-out"></i> Sign out
            </a>
        </li>
    </ul>

</nav>