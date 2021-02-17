@include('learner.header')
@isset ($header)
    @include('learner.sub_header.'.$header)
@endisset

@isset ($view)
	@include('learner.content.'.$view)  
@endisset

@include('learner.footer')
