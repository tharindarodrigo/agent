@extends('inquiries.rate-inquiries.rate-inquiries')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Inquires</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Hotel</th>
                                <th>Room Type</th>
                                <th>Meal Basis</th>
                                <th>Room Spec</th>
                                <th>Status</th>
                            <tr>
                            </thead>
                            <tbody>
                            @if($rateinquiries->count())
                                @foreach($rateinquiries as $rateinquiry)
                                    <tr>
                                        <td>{{$rateinquiry->id}}</td>
                                        <td>{{$rateinquiry->from}}</td>
                                        <td>{{$rateinquiry->to}}</td>
                                        <td>{{$rateinquiry->hotel->hotel}}</td>
                                        <td>{{$rateinquiry->roomType->roomType}}</td>
                                        <td>{{$rateinquiry->mealBasis->meal_basis}}</td>
                                        <td>{{$rateinquiry->roomSpecification->room_specification}}</td>
                                        <td>
                                            @if($rateinquiry->status == 0)
                                                <small class="label label-warning"> Pending</small>

                                            @elseif($rateinquiry->status=1)
                                                <small class="label label-primary"> Confirmed</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else

                                <tr>
                                    <td colspan="8" align="center"><h3>No results Found</h3></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection