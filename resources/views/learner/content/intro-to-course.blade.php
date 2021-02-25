					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Entry-->
						<div class="container">
							<!--begin::Education-->
							<div class="">
								<!--begin::Aside-->
								
								<!--end::Aside-->
								<!--begin::Content-->
								<div class="card card-custom gutter-b ">
									<!--begin::Body-->
									<!--begin::Dropdown-->
									
									<!--end::Dropdown-->
									<div class="card-body row">
										<!--begin::Top-->
										
										<!--end::Top-->
										<!--begin::Bottom-->
										<div class="pt-4 col-sm-5">
											<!--begin::Image-->
											<div class="bgi-no-repeat bgi-size-cover rounded min-h-235px" style="background-image: url({{asset('storage/'.$course->course_cover_img_url)}})"></div>
											<!--end::Image-->
											<!--begin::Symbol-->
											
										
											
											<!--end::Action-->
										</div>
										<div class="row col-sm-7">
											<!--begin::Symbol-->
											
											<!--end::Symbol-->
											<!--begin::Info-->
											<div class="d-flex flex-column flex-grow-1">
												<span>
													<h1 class="text-dark-75 text-hover-primary my-1 font-size-lg font-weight-bolder" style="font-size: 48px;">{{$course->course_title}}</h1>
													
												</span>
												<span class="text-muted font-weight-bold">in {{$class->cat_title}}</span>
												<div class="d-flex align-items-center  py-5">
												<div class="symbol symbol-60 symbol-circle symbol-success overflow-hidden mr-5">
														<span class="symbol-label">
															<img src="/assets/media/svg/avatars/007-boy-2.svg" class="h-75 align-self-end" alt="">
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Info-->
													<div class="d-flex flex-column flex-grow-1">
														<a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-24 font-weight-bolder" style="font-size: 24px;">by {{$course->instructor->instr_name}}</a>
														<span class="text-dark-75 font-weight-bold mr-25">{{$course->course_desc}}</span>
													</div>
													<!--end::Info-->
												</div>
											</div>
											<!--end::Info-->
											
										</div>
										<!--end::Bottom-->
										
									</div>
									<!--end::Body-->
								</div>
								<div class="d-flex flex-column flex-md-row">
									<!--begin::Aside-->
									
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-md-row-fluid ">
										<div class="row">
											<div class="col-sm-8">
												
												<!--begin::Forms Widget 3-->
												<div class="card card-custom gutter-b">

													<!--begin::Body-->
													<div class="card-body">
														<h3 class="card-title align-items-start flex-row">
															<span class="card-label font-weight-bolder text-dark d-block">Courses Content</span>
															<span class="text-muted mt-3 font-weight-bold font-size-sm">{{count($course->chapters)}} chapters</span>

															
														</h3>
														<div class="accordion accordion-toggle-arrow" id="accordionExample1">
														@foreach ($course->chapters as $key => $chapter)
															<div class="card">
														        <div class="card-header">
														            <div class="card-title text-dark-75" data-toggle="collapse" data-target="#collapseOne{{$key}}">
														                <span class="col-sm-8">{{$chapter->chapter_title}} </span>
														               
														            </div>
														        </div>

														        <div id="collapseOne{{$key}}" class="collapse {{$key==0?'show':''}}" data-parent="#accordionExample1">
														            <div class="card-body">
														            	@foreach ($chapter->blocks as $block)
																        	<div class="row m-2">
															                	<div class="col-sm-1">	
															                		<i class="fa far fa-play-circle">	</i>
															                	</div>
															                	<div class="col-sm-8">	
															                		{{$block->block_title}}
															                	</div>
															                	
															                </div>
																        @endforeach
														              
														            </div>
														        </div>
														    </div>
														@endforeach
														<a href="{{ route('learner_class_course_learn', [$class->cat_id, $course->course_id]) }}">
														    <button class="btn btn-primary font-weight-bolder font-size-sm py-3 mt-10 px-14 w-100 mx-auto">
														    	Enter Class
															</button>
													    </a>
													</div>
													</div>
													<!--end::Body-->
												</div>
												<!--end::Forms Widget 3-->
												
											</div>
											<div class="col-sm-4">
												
												<!--begin::Forms Widget 7-->
												
												

												<!--begin::Base Table Widget 2-->
												<div class="card card-custom gutter-b">
													<!--begin::Header-->
													<div class="card-header border-0 pt-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label font-weight-bolder text-dark">Similar Courses</span>
															<span class="text-muted mt-3 font-weight-bold font-size-sm">44 total courses</span>
														</h3>
														
													</div>
													<!--end::Header-->
													<!--begin::Body-->
													<div class="card-body pt-2 pb-0 mt-3">
														<div class="tab-content mt-5" id="myTabTables2">
															<!--begin::Tap pane-->
															
															<!--end::Tap pane-->
															<!--begin::Tap pane-->
															
															<!--end::Tap pane-->
															<!--begin::Tap pane-->
															<div class="tab-pane fade active show" id="kt_tab_pane_2_3" role="tabpanel" aria-labelledby="kt_tab_pane_2_3">
																<!--begin::Table-->
																<div class="table-responsive">
																	<table class="table table-borderless table-vertical-center">
																		<thead>
																			<tr>
																				<th class="p-0" ></th>
																				<th class="p-0" ></th>
																				<th class="p-0" ></th>
																				<th class="p-0" ></th>
																			</tr>
																		</thead>
																		<tbody>
																			<tr>
																				<td class="m-0 p-0">
																					<div class="symbol symbol-50 symbol-light mr-2">
																						<span class="symbol-label">
																							<img src="/assets/media/svg/misc/006-plurk.svg" class="h-50 align-self-center" alt="">
																						</span>
																					</div>
																				</td>
																				<td class="pl-0">
																					<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Mathematics</a>
																					<span class="text-muted font-weight-bold d-block">in Primary 4</span>
																				</td>
																				<td class="">
																					<div>
																						<span class="text-muted font-weight-bold">25%</span>
																						<span class="text-muted font-weight-bold float-right">Progress</span>
																					</div>
																					<div class="progress w-100">
																					    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
																					</div>
																				</td>
																				
																				<td class="text-right pr-0">
																					<a href="#" class="btn btn-icon btn-light btn-sm">
																						<span class="svg-icon svg-icon-md svg-icon-success">
																							<!--begin::Svg Icon | path:/assets/media/svg/icons/Navigation/Arrow-right.svg-->
																							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																									<polygon points="0 0 24 0 24 24 0 24"></polygon>
																									<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
																									<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
																								</g>
																							</svg>
																							<!--end::Svg Icon-->
																						</span>
																					</a>
																				</td>
																			</tr>
																			<tr>
																				<td class="m-0 p-0">
																					<div class="symbol symbol-50 symbol-light mr-2">
																						<span class="symbol-label">
																							<img src="/assets/media/svg/misc/015-telegram.svg" class="h-50 align-self-center" alt="">
																						</span>
																					</div>
																				</td>
																				<td class="pl-0">
																					<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Geography</a>
																					<span class="text-muted font-weight-bold d-block">in SS1</span>
																				</td>
																				<td class="">
																					<div>
																						<span class="text-muted font-weight-bold">95%</span>
																						<span class="text-muted font-weight-bold float-right">Progress</span>
																					</div>
																					<div class="progress w-100">
																					    <div class="progress-bar bg-primary" role="progressbar" style="width: 95%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
																					</div>
																				</td>
																				
																				<td class="text-right pr-0">
																					<a href="#" class="btn btn-icon btn-light btn-sm">
																						<span class="svg-icon svg-icon-md svg-icon-success">
																							<!--begin::Svg Icon | path:/assets/media/svg/icons/Navigation/Arrow-right.svg-->
																							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																									<polygon points="0 0 24 0 24 24 0 24"></polygon>
																									<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
																									<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
																								</g>
																							</svg>
																							<!--end::Svg Icon-->
																						</span>
																					</a>
																				</td>
																			</tr>
																			<tr>
																				<td class="m-0 p-0">
																					<div class="symbol symbol-50 symbol-light mr-2">
																						<span class="symbol-label">
																							<img src="/assets/media/svg/misc/003-puzzle.svg" class="h-50 align-self-center" alt="">
																						</span>
																					</div>
																				</td>
																				<td class="pl-0">
																					<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">History</a>
																					<span class="text-muted font-weight-bold d-block">in SS2</span>
																				</td>
																				<td class="">
																					<div>
																						<span class="text-muted font-weight-bold">50%</span>
																						<span class="text-muted font-weight-bold float-right">Progress</span>
																					</div>
																					<div class="progress w-100">
																					    <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
																					</div>
																				</td>
																				<td class="text-right pr-0">
																					<a href="#" class="btn btn-icon btn-light btn-sm">
																						<span class="svg-icon svg-icon-md svg-icon-success">
																							<!--begin::Svg Icon | path:/assets/media/svg/icons/Navigation/Arrow-right.svg-->
																							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																									<polygon points="0 0 24 0 24 24 0 24"></polygon>
																									<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
																									<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
																								</g>
																							</svg>
																							<!--end::Svg Icon-->
																						</span>
																					</a>
																				</td>
																			</tr>
																			<tr>
																				<td class="m-0 p-0">
																					<div class="symbol symbol-50 symbol-light mr-2">
																						<span class="symbol-label">
																							<img src="/assets/media/svg/misc/005-bebo.svg" class="h-50 align-self-center" alt="">
																						</span>
																					</div>
																				</td>
																				<td class="pl-0">
																					<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">Religious Studies</a>
																					<span class="text-muted font-weight-bold d-block">in Primary 2</span>
																				</td>
																				<td class="">
																					<div>
																						<span class="text-muted font-weight-bold">75%</span>
																						<span class="text-muted font-weight-bold float-right">Progress</span>
																					</div>
																					<div class="progress w-100">
																					    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
																					</div>
																				</td>
																				<td class="text-right pr-0">
																					<a href="#" class="btn btn-icon btn-light btn-sm">
																						<span class="svg-icon svg-icon-md svg-icon-success">
																							<!--begin::Svg Icon | path:/assets/media/svg/icons/Navigation/Arrow-right.svg-->
																							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																									<polygon points="0 0 24 0 24 24 0 24"></polygon>
																									<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
																									<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
																								</g>
																							</svg>
																							<!--end::Svg Icon-->
																						</span>
																					</a>
																				</td>
																			</tr>
																			<tr>
																				<td class="m-0 p-0">
																					<div class="symbol symbol-50 symbol-light mr-2">
																						<span class="symbol-label">
																							<img src="/assets/media/svg/misc/014-kickstarter.svg" class="h-50 align-self-center" alt="">
																						</span>
																					</div>
																				</td>
																				<td class="pl-0">
																					<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">English</a>
																					<span class="text-muted font-weight-bold d-block">in JSS2</span>
																				</td>
																				<td class="">
																					<div>
																						<span class="text-muted font-weight-bold">20%</span>
																						<span class="text-muted font-weight-bold float-right">Progress</span>
																					</div>
																					<div class="progress w-100">
																					    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
																					</div>
																				</td>
																				<td class="text-right pr-0">
																					<a href="#" class="btn btn-icon btn-light btn-sm">
																						<span class="svg-icon svg-icon-md svg-icon-success">
																							<!--begin::Svg Icon | path:/assets/media/svg/icons/Navigation/Arrow-right.svg-->
																							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																									<polygon points="0 0 24 0 24 24 0 24"></polygon>
																									<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
																									<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
																								</g>
																							</svg>
																							<!--end::Svg Icon-->
																						</span>
																					</a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	
																</div>
																<!--end::Table-->
															</div>
															<!--end::Tap pane-->
														</div>
													</div>
													<!--end::Body-->
												</div>
												<!--end::Base Table Widget 2-->
												
												
												<!--end::List Widget 18-->
											</div>
										</div>
									</div>

									<!--end::Content-->
								</div>

								<!--end::Content-->
							</div>
							<!--end::Education-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->