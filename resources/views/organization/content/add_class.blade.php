
					<!--begin::Content-->
					<!--begin::Content-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<!--begin::Container-->
							<div class="container">
								<!--begin::Profile Account Information-->
								<div class="d-flex flex-row">
									<!--begin::Aside-->
									
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-row-fluid ml-lg-8">
										<!--begin::Card-->
										@if ($errors->any())
										    <div class="alert alert-danger">
										        <ul>
										            @foreach ($errors->all() as $error)
										                <li>{{ $error }}</li>
										            @endforeach
										        </ul>
										    </div>
										@endif
										<form class="form" method="POST" novalidate="novalidate" id="kt_form">
											@csrf
											
											<div class="card card-custom">
												<!--begin::Header-->
												<div class="card-header py-3">
													<div class="card-title align-items-start flex-column">
														<h3 class="card-label font-weight-bolder ">Add New Class</h3>
														<span class="text-muted font-weight-bold font-size-sm mt-1">Enter class details and submit</span>
													</div>
													<div class="card-toolbar">
														<button type="submit" id="m_submit" class="btn btn-success mr-2">
															Save Changes
														</button>
														<button type="reset" class="btn mr-2">
															Clear
														</button>
													</div>
												</div>
												<!--end::Header-->
												<!--begin::Form-->
												{{-- <form class="form"> --}}
													<!--begin::Body-->
													<div class="card-body">
														<div class="col-sm-6 float-left">
															<!--begin::Form Group-->
															<div class="form-group">
															   <label>Class Title:</label>
															   <input type="text" class="form-control form-control-solid" name="cat_title" />
															   <span class="form-text text-muted">Please your Class Title</span>
															</div>
															
															<div class="form-group">
															   <label>Class Description</label>
															   <textarea class="form-control form-control-solid" name="cat_desc" style="height: 200px;"></textarea>
															  
															   
															</div>
															
															
														</div>
														<div class="col-sm-6 float-left">
															<div class="form-group">
															   <label>Class Code:</label>
															   <input type="text" class="form-control form-control-solid" name="cat_code" maxlength="6" minlength="6" />
															   <span class="form-text text-muted">Please your Class Code</span>
															</div>
															<div class="form-group">
																<label for="exampleSelectd">Status</label>
																<select class="form-control" id="exampleSelectd" name="cat_status">
																	<option value="1">Open</option>
																	<option value="0">Closed</option>
																	
																</select>
															</div>
															<div class="form-group">
															   <label>Maximum Students:</label>
															   <input type="text" class="form-control form-control-solid" name="cat_max_student" />
															   
															</div>
														</div>
														
														

														
														
														
													</div>
													<!--end::Body-->
												{{-- </form> --}}
												<!--end::Form-->
											</div>
										</form>
										<!--end::Card-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Profile Account Information-->
							</div>
							<!--end::Container-->
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					<!--end::Content-->
					<!--end::Content-->
					