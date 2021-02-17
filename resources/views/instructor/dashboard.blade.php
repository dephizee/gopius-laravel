@include('instructor.header')
@isset ($header)
    @include('instructor.sub_header.'.$header)
@endisset

@isset ($view)
	@include('instructor.content.'.$view)  
@endisset

@include('instructor.footer')
