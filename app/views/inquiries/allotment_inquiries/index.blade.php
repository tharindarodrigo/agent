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
                                <th>Status</th>
                            <tr>
                            </thead>
                            <tbody>
                            @foreach($allotmentinquiries as $allotmentinquiry)
                                <tr>
                                    <td>{{$allotmentinquiry->id}}</td>
                                    <td>{{$allotmentinquiry->from}}</td>
                                    <td>{{$allotmentinquiry->to}}</td>
                                    <td>{{$allotmentinquiry->hotel->hotel}}</td>
                                    <td>{{$allotmentinquiry->roomType->roomType}}</td>
                                    <td>{{$allotmentinquiry->status}}</td>
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