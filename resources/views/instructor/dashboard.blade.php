@include('instructor.header')
<style type="text/css">
	.header .header-top,
	.header-mobile
	 {
		background: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.header-menu .menu-nav > .menu-item.menu-item-active > .menu-link .menu-text
	 {
		color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.btn.btn-primary,
	.btn.btn-success,
	.datatable.datatable-default > .datatable-pager > .datatable-pager-nav > li > .datatable-pager-link.datatable-pager-link-active
	 {
	    background-color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	    border-color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.text-primary, .text-success, .datatable.datatable-default > .datatable-table > .datatable-body .datatable-toggle-detail i {
	    color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label .wizard-title {
	    color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label .wizard-icon {
	    color: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-arrow svg g [fill] {
	    fill: {{Auth::guard('instructor')->user()->organization->setting->color}}!important;
	}
	{{Auth::guard('instructor')->user()->organization->setting->css}}
</style>
@isset ($header)
    @include('instructor.sub_header.'.$header)
@endisset

@isset ($view)
	@include('instructor.content.'.$view)  
@endisset

@include('instructor.footer')
