
					<!--begin::Content-->
					
					<!--end::Content-->

					
					<!--begin::Footer-->
					
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		
		
		<!--end::Scrolltop-->
		<!--begin::Sticky Toolbar-->
		
		<!--end::Sticky Toolbar-->
		<!--begin::Demo Panel-->

		<!--end::Demo Panel-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#F64E60", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors-->
		@switch($view)
		    @case('instructorss--')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/instructor-learner.js"></script>
				<!--end::Page Scripts-->
		        @break

		    @case('learners')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/instructor-learner.js"></script>
				<!--end::Page Scripts-->
		        @break
 			@case('courses')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/instructor-courses.js"></script>
				<!--end::Page Scripts-->
		        @break

		    @case('classes')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/instructor-classes.js"></script>
				<!--end::Page Scripts-->
		        @break

		    @case('instructors')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/instructor-instructors.js"></script>
				<!--end::Page Scripts-->
		        @break

		    @case('add_course')
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/custom/wizard/wizard-1.js"></script>
				<!--end::Page Scripts-->
				<script src="/assets/js/pages/custom/education/student/profile.js"></script>
				<script src="/assets/js/add_course.js"></script>

		        @break

		    @case('add_instructor')
		    	<script type="text/javascript">
		    		$('#kt_select2_3').select2({
					   placeholder: "Select atleast a class",
					});
		    	</script>
		    	<script src="/assets/js/pages/custom/login/add-instructor.js"></script>
		    	@break
		    @case('add_learner')
		    	<script type="text/javascript">
		    		$('#kt_select2_3').select2({
					   placeholder: "Select atleast a class",
					});
		    	</script>
		    	<script src="/assets/js/pages/custom/login/add-learner.js"></script>
		    	@break
		    @case('add_class')
				<script src="/assets/js/pages/custom/login/add-class.js"></script>
			

		        @break
			
			@case('build_course')
		        <!--begin::Page Scripts(used by this page)-->
				<!--begin::Page Vendors(used by this page)-->
				<script src="/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
				<!--end::Page Vendors-->
				<!--begin::Page Scripts(used by this page)-->
				
				<!--end::Page Scripts-->
				<script src="/assets/js/build_course.js"></script>

		        @break
		
		    @default
		        <!--begin::Page Scripts(used by this page)-->
				<script src="/assets/js/pages/widgets.js"></script>
				<!--end::Page Scripts-->
		@endswitch
		
		
	</body>
	<!--end::Body-->
</html>