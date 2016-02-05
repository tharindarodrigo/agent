@extends('layout.master')

@section('css')
    {{HTML::style('css/plugins/chosen/chosen.css')}}
    {{HTML::style('css/plugins/daterangepicker/daterangepicker-bs3.css')}}
    {{HTML::style('css/plugins/datapicker/datepicker3.css')}}

@endsection

@section('active-inquiries')
    active
@endsection

@section('active-inquiries-allotment-inquiries')
    active
@endsection

@section('bread-crumbs')
    @yield('bread-crumbs')
@endsection

@section('content')

@endsection

@section('script')
    {{HTML::script('js/plugins/chosen/chosen.jquery.js')}}
    {{HTML::script('js/plugins/fullcalendar/moment.min.js')}}
    {{HTML::script('js/plugins/daterangepicker/daterangepicker.js')}}
    {{HTML::script('js/plugins/datapicker/bootstrap-datepicker.js')}}
    <script type="text/javascript">
        $(function () {
            $('.hotel_selector').chosen(function(){

            });

            $('#data_5 .inquiry_period').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

//            $('.inquiry_period').daterangepicker({
//
//                locale: {
//                    format: 'YYYY-MM-DD'
//                }
//            });


        });

        $(document).ready(function () {
            $('.hotel_selector').change(function () {
                var hotel_id = $(this).val();

                var formData = new FormData();
                formData.append('hotel_id',hotel_id);
                var rooms = '';
                $.ajax({
                    url: 'http://'+window.location.host+'/hotel/get-room-list',
                    method: 'post',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: 'json',
                    success: function(data){
                        if(data != null){

                            $.each(data,function(index, item){
                                rooms += '<option value="'+index+'">'+item+'</option>'
                            });



                            $('#room_id').html(rooms);

                        }
                    }
                })
            });
        });
    </script>
@endsection