@extends('inquiries.allotment-inquiries.allotment-inquiries')

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
                                <th>Controls</th>
                            <tr>
                            </thead>
                            <tbody>
                            @if($allotmentinquiries->count())

                                @foreach($allotmentinquiries as $allotmentinquiry)
                                <tr>
                                    <td>{{$allotmentinquiry->id}}</td>
                                    <td>{{$allotmentinquiry->from}}</td>
                                    <td>{{$allotmentinquiry->to}}</td>
                                    <td>{{$allotmentinquiry->hotel->hotel}}</td>
                                    <td>{{$allotmentinquiry->roomType->roomType}}</td>
                                    <td>{{$allotmentinquiry->status}}</td>
                                    <td></td>
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