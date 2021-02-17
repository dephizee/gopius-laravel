@include('organization.header')
@isset ($header)
    @include('organization.sub_header.'.$header)
@endisset

@isset ($view)
	@include('organization.content.'.$view)  
@endisset

@include('organization.footer')
