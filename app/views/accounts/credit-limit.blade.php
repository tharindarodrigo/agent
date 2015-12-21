@extends('accounts.accounts')

@section('active-accounts-credit-limit')
    {{'active'}}
@endsection

@section('content')
    <div class="col-lg-3">
    </div>
    <div class="col-lg-6">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-12">

                    <span class="text-center">
                        <h2>
                            Your Credit Limit is
                        </h2>
                        <h1>USD {{number_format(Agent::where('user_id',Auth::id())->first()->credit_limit,2)}}</h1>
                    </span>
                </div>
            </div>
        </div>
    </div>

@stop

