<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginOrganization;
use App\Http\Controllers\LoginInstructor;
use App\Http\Controllers\Organization;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LoginLearnerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$domain = parse_url(config('app.url'),  PHP_URL_HOST);
Route::group(['domain'=>'admin.'.$domain,], function(){
	Route::group(['middleware'=>['auth_Admin']], function(){
		Route::get('/dashboard', [Admin::class, 'dashboard'])->name('admin_dashboard');
		Route::get('/logout', [Admin::class, 'logout'])->name('admin_logout');
		
	});
	Route::get('/', [Admin::class, 'index'])->name('admin_login');
	Route::post('/', [Admin::class, 'processLogin'])->name('admin_login');
});
// dd($domain);
Route::group(['domain'=>'{account}.'.$domain,], function(){
	Route::get('/', function ($account) {
        print($account);
    });
});



Route::get('/state-json/{country_id}', [LoginOrganization::class, 'stateJson'])->name('register');

Route::group(['middleware'=>['auth_organization_is_logged_in']], function(){
	Route::get('/', [LoginOrganization::class, 'index'])->name('login');
	Route::post('/', [LoginOrganization::class, 'processLogin'])->name('login_process');
	Route::get('/register', [LoginOrganization::class, 'registerView'])->name('register');
	Route::post('/register', [LoginOrganization::class, 'registerProcess'])->name('register');
	
});
Route::group(['prefix'=>'organization',], function(){
	Route::group(['middleware'=>['auth_organization']], function(){
		Route::get('/', [Organization::class, 'index'])->name('organization_dashboard');
		Route::get('/timeline', [Organization::class, 'timeline'])->name('organization_timeline');


		Route::get('/appearance', [Organization::class, 'appearance'])->name('organization_appearance');
		Route::get('/customize', [Organization::class, 'customize'])->name('organization_customize');
		Route::get('/domain-mapping', [Organization::class, 'domainMapping'])->name('domainMapping');


		Route::get('/classes', [CategoryController::class, 'classes'])->name('organization_classes');
		Route::get('/classes-all', [CategoryController::class, 'allClass'])->name('organization_course_new');
		Route::get('/class-add', [CategoryController::class, 'newClass'])->name('organization_class_new');
		Route::post('/class-add', [CategoryController::class, 'processNewClass'])->name('organization_class_new');
		// Route::get('/courses-build/{course_id}', [Organization::class, 'buildCourse'])->name('organization_course_build');
		


		
		


		

		


		Route::get('/instructors', [InstructorController::class, 'instructor'])->name('organization_instuctors');
		Route::get('/instructors-all', [InstructorController::class, 'allInstructors'])->name('organization_all_instructors');
		Route::get('/instructors-add', [InstructorController::class, 'newInstructor'])->name('organization_instuctor_new');
		Route::post('/instructors-add', [InstructorController::class, 'processNewInstructor'])->name('organization_instuctor_new');


		Route::get('/learners', [LearnerController::class, 'learner'])->name('organization_learners');
		Route::get('/learners-all', [LearnerController::class, 'allLearners'])->name('organization_all_learners');
		Route::get('/learners-add', [LearnerController::class, 'newLearner'])->name('organization_learner_new');
		Route::post('/learners-add', [LearnerController::class, 'processNewLearner'])->name('organization_learner_new');


		Route::get('/users-add', [Organization::class, 'addUser'])->name('organization_add_user');
		// Route::post('/', [LoginOrganization::class, 'processLogin'])->name('login');
		// Route::get('/register', [LoginOrganization::class, 'registerView'])->name('register');
		// Route::post('/register', [LoginOrganization::class, 'registerProcess'])->name('register');


		Route::get('/logout', [Organization::class, 'logout'])->name('organization_logout');
	});
});
Route::group(['prefix'=>'instructor'], function (){
	
	Route::group(['middleware'=>'auth_instructor_login'], function (){
		Route::get('/', [LoginInstructor::class, 'index'])->name('instructor_login');
		Route::post('/', [LoginInstructor::class, 'processLogin']);
	});
	Route::group(['middleware'=>'auth_instructor'], function (){
		Route::get('/timeline', [InstructorController::class, 'instructorDashboard'])->name('instructor_dashboard');
		Route::get('/profile', [InstructorController::class, 'instructorProile'])->name('instructor_profile');
		Route::post('/profile', [InstructorController::class, 'updateInstructorProile']);

		
		Route::group(['prefix'=>'instructor-class/{class}', 'middleware'=>'instructor_class_access'], function (){
			Route::get('/', [InstructorController::class, 'instructorClass'])->name('instructor_class');
			Route::get('/courses-add', [CourseController::class, 'newCourse'])->name('instructor_course_new');
			Route::post('/courses-add', [CourseController::class, 'processNewCourse']);
			Route::get('/courses-build/{course_id}', [CourseController::class, 'buildCourse'])->name('instructor_course_build');

			Route::get('/courses-build/{course}/create/{chapter_name}', [ChapterController::class, 'addChapter'])->name('instructor_course_build_create');
			Route::get('/courses-build/{course_id}/delete/{chapter}', [ChapterController::class, 'deleteChapter'])->name('instructor_course_build_delete_chapter');
			Route::get('/courses-build/{course_id}/all', [ChapterController::class, 'allChapter'])->name('instructor_course_build_all_chapters');

			Route::get('/courses-build/{course_id}/create/{chapter_id}/{block_name}', [BlockController::class, 'addBlock'])->name('instructor_course_build_create_block');
			Route::post('/courses-build/{course_id}/update-content/{block_id}', [BlockController::class, 'updateBlockContent'])->name('instructor_course_build_upload_block_content');
			Route::get('/courses-build/{course_id}/delete/block/{block_id}', [BlockController::class, 'deleteBlock'])->name('instructor_course_build_delete_block');
			Route::get('/courses-build/{course_id}/{chapter_id}/all', [BlockController::class, 'allBlocks'])->name('instructor_course_build_all_chapter_blocks');


			Route::get('/poll-add', [PollController::class, 'newPoll'])->name('instructor_poll_new');
			Route::post('/poll-add', [PollController::class, 'processNewPoll']);
			Route::get('/poll/{poll}', [PollController::class, 'viewPoll'])->name('instructor_poll_view');


			Route::get('/assignment-add', [AssignmentController::class, 'newAssignment'])->name('instructor_assignment_new');
			Route::post('/assignment-add', [AssignmentController::class, 'processNewAssignment']);
			Route::get('/assignment/{poll}', [AssignmentController::class, 'viewAssignment'])->name('instructor_assignment_view');


			Route::get('/quiz-add', [QuizController::class, 'newQuiz'])->name('instructor_quiz_new');
			Route::post('/quiz-add', [QuizController::class, 'processNewQuiz']);
			Route::get('/quiz-build/{quiz}', [QuizController::class, 'buildQuiz'])->name('instructor_quiz_build');
			Route::post('/quiz-build/{quiz}/upload', [QuizController::class, 'processBuiltQuiz']);

		});


		Route::get('/classes', [InstructorController::class, 'instructorClasses'])->name('instructor_classes');
		Route::get('/classes-all', [InstructorController::class, 'allInstructorClasses'])->name('organization_course_new');



		Route::get('/activities', [InstructorController::class, 'instructorActivities'])->name('instructor_activities');
		Route::get('/courses-all', [CourseController::class, 'allCourse'])->name('instructor_course_newI');

		Route::get('/assignments', [AssignmentController::class, 'instructorAssignments'])->name('instructor_assignments');
		Route::get('/assignments-all', [AssignmentController::class, 'allAssignments']);


		Route::get('/quizzes', [QuizController::class, 'instructorQuizzes'])->name('instructor_quizzes');
		Route::get('/quizzes-all', [QuizController::class, 'allQuizzes']);

		Route::get('/polls', [InstructorController::class, 'instructorPolls'])->name('instructor_polls');
		Route::get('/polls-all', [PollController::class, 'allPolls']);
		

		Route::get('/learners', [LearnerController::class, 'instructorLearners'])->name('instructor_learners');
		Route::get('/learners-all', [LearnerController::class, 'allInstructorLearners']);


		Route::get('/logout', [InstructorController::class, 'logout'])->name('instructor_logout');
	});
});
Route::group(['prefix'=>'learner'], function (){
	Route::group(['middleware'=>'auth_learner_login'], function (){
		Route::get('/', [LoginLearnerController::class, 'index'])->name('learner_login');
		Route::post('/', [LoginLearnerController::class, 'processLogin']);
	});
	Route::group(['middleware'=>'auth_learner'], function (){
		Route::get('/timeline', [LearnerController::class, 'learnerDashboard'])->name('learner_dashboard');
		Route::get('/classes', [LearnerController::class, 'learnerClasses'])->name('learner_classes');
		Route::get('/activities', [LearnerController::class, 'learnerActivities'])->name('learner_activities');
	});
});



// Route::domain(  'admin.' . parse_url(config('app.url'))  )->group(function () {
//     Route::group(['middleware'=>['auth_Admin']], function(){
// 		Route::get('/dashboard', [Admin::class, 'dashboard'])->name('admin_dashboard');
		
// 	});
// 	Route::get('/', [Admin::class, 'index'])->name('admin_login');
// 	Route::post('/', [Admin::class, 'processLogin'])->name('admin_login');
// });
