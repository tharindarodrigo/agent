@include('emails.emailStructure.header1')

Hello Thilina, <br/> <br/>

You Have New Message From

{{ $name }} <br/><br/>

-------------------------------------------------------------<br/><br/>

{{ $comments }} <br/> <br/> <br/>

-------------------------------------------------------------<br/><br/>

Email - {{ $email }} <br/><br/>

@if(!empty($phone))
    Contact No - {{ $phone }}
@endif

@include('emails.emailStructure.footer')
