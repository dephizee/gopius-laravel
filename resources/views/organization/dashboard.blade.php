@include('organization.header')
<style type="text/css">
	.header .header-top,
	.header-mobile
	 {
		background: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.header-menu .menu-nav > .menu-item.menu-item-active > .menu-link .menu-text
	 {
		color: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.btn.btn-primary,
	.btn.btn-success,
	.datatable.datatable-default > .datatable-pager > .datatable-pager-nav > li > .datatable-pager-link.datatable-pager-link-active
	 {
	    background-color: {{Auth::guard('organization')->user()->setting->color}}!important;
	    border-color: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.text-primary, .text-success, .datatable.datatable-default > .datatable-table > .datatable-body .datatable-toggle-detail i {
	    color: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label .wizard-title {
	    color: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-label .wizard-icon {
	    color: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	.wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-arrow svg g [fill] {
	    fill: {{Auth::guard('organization')->user()->setting->color}}!important;
	}
	{{Auth::guard('organization')->user()->setting->css}}
</style>
@isset ($header)
    @include('organization.sub_header.'.$header)
@endisset

@isset ($view)
	@include('organization.content.'.$view)  
@endisset

@include('organization.footer')
