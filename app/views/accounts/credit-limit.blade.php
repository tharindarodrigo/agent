@extends('accounts.accounts')

@section('active-accounts-credit-limit')
    {{'active'}}
@endsection

@section('content')
    {{--{{dd('<pre>',,'</pre>')}}--}}
    @if(Entrust::hasRole('Agent'))

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
    @else
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Set Agent Credit Limits</h5>
                        </div>
                        <div class="ibox-content">
                            {{Form::open(array('url'=>'accounts/credit-limit/update'))}}

                            <div class="form-group">
                                <label for="agent_id">Agent</label>
                                {{Form::select('agent_id', Agent::lists('company','id'),null, array('class' => 'form-control', 'id'=>'agent_id'))}}
                                {{$errors->first('agent_id', '<span class="size12" style="color: red;">:message</span>') }}

                            </div>
                            <div class="form-group">
                                <label for="credit_limit">Credit Limit</label>
                                {{Form::text('credit_limit',null, array('class' => 'form-control', 'id'=>'credit_limit'))}}
                                {{$errors->first('credit_limit', '<span class="size12" style="color: red;">:message</span>') }}

                            </div>
                            <div class="form-group">
                                {{Form::submit('Update', array('class'=> 'btn btn-primary', 'name'=>'update'))}}
                            </div>

                            {{Form::close()}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Agent Credit Limits</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="credit_limit_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>Country</th>
                                        <th>Credit Limit</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($agents as $agent)
                                        <tr>
                                            <td>{{$agent->id}}</td>
                                            <td>{{$agent->company}}</td>
                                            <td>{{$agent->country->country}}</td>
                                            <td align="right">{{number_format($agent->credit_limit,2)}}</td>
                                            <td>
                                                <button class="btn btn-xs btn-success" agent_id="{{$agent->id}}"
                                                        credit_limit="{{$agent->credit_limit}}"><span
                                                            class="glyphicon glyphicon-edit"></span></button>
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
        </div>
    @endif


@stop

