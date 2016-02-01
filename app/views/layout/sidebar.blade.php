<nav class="navbar-default navbar-static-side" role="navigation">

    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            {{--<img alt="image" class="img-circle" src="img/profile_small.jpg"/>--}}
                        {{HTML::image('img/profile_small.jpg','image',array('class'=>'img-circle'))}}
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        {{Auth::user()->first_name.' '.Auth::user()->last_name}}
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">{{!empty(Agent::where('user_id',Auth::id())->count()) ? Agent::where('user_id',Auth::id())->first()->company : ''}}
                                    <b class="caret"></b></span> </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{URL::to('accounts/profile')}}">My Profile</a></li>
                        <li><a href="{{URL::to('account/profile/change-password')}}">Change Password</a></li>
                        <li><a href="#">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{URL::route('account-sign-out')}}">Sign Out</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <li>
                <a href="{{URL::to('/reservations')}}"><i class="fa fa-sitemap"></i> <span class="nav-label">Reservations </span></a>
            </li>

            <li class="@yield('active-bookings')">
                <a href="{{URL::to('bookings')}}"><i class="fa fa-sitemap"></i> <span class="nav-label">Bookings </span></a>
            </li>

            <li class="@yield('active-inquiries')">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Inquiries </span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">

                    <li class="@yield('active-inquiries-rate-inquiries')">
                        <a href="{{URL::to('inquiries/rate-inquiries')}}">Rate Inquiries</a></li>
                    <li class="@yield('active-inquiries-allotment-inquiries')">
                        <a href="{{URL::to('inquiries/allotment-inquiries')}}">Allotment Inquiries </a></li>
                </ul>
            </li>

            <li class="@yield('active-accounts')">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Accounts </span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="@yield('active-invoices')"><a href="{{URL::to('accounts/invoices')}}">Invoices</a></li>
                    <li class="@yield('active-payments')">
                        <a href="#">Payments <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li class="@yield('active-payments-view-payments')">
                                <a href="{{URL::to('accounts/payments')}}">View Payments </a>
                            </li>
                            <li class="@yield('active-payments-create-payments')">
                                <a href="{{URL::route('accounts.payments.create')}}">Make Payment</a>
                            </li>

                        </ul>
                    </li>
                    <li class="@yield('active-balance-sheet')">
                        <a href="{{URL::to('accounts/balance-sheet')}}">Balance Sheet</a></li>
                    <li class="@yield('active-accounts-credit-limit')">
                        <a href="{{URL::to('accounts/credit-limit')}}">Credit Limit</a></li>
                </ul>
            </li>

        </ul>
    </div>


</nav>