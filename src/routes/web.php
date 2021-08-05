<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => 'Googlemarketer\Contact\Http\Controllers'], function () {
    Route::resource('/contact', ContactController::class);
});


Route::get('/slider', function(){
    return view('slider');
});
//adminsetup Route
Route::get('adminsetup', function(){
    return view('adminsetup');
});

//associatesetup Route
Route::get('associatesetup', function(){
    return view('associatesetup');
});
//partnersetup Route
Route::get('partnersetup', function(){
    return view('partnersetup');
});



// Member custom dashboard
//Route::namespace('Member')->prefix('users')->group(function(){
Route::namespace('Member')->group(function(){
    Route::resource('{user}/profile','MemberProfileController')->middleware('auth');
    Route::resource('{user}/usercomments','MemberCommentController')->middleware('auth');
    Route::get('{user}/dashboard', 'MemberDashboardController@index')->name('user.dashboard')->middleware('auth');
    Route::get('{user}/listedproperty', 'MemberDashboardController@listedproperty')->name('user.property');
    Route::get('{user}/favproperty', 'MemberDashboardController@favproperty')->name('user.favproperty');
    Route::get('{user}/listedposts', 'MemberDashboardController@listedposts')->name('user.posts');
    Route::get('{user}/orders','MemberDashboardController@listorders')->name('user.orders');
    //Routes for mutliple image uploads
    Route::get('image','ImageController@create');
    Route::post('image','ImageController@store');
    Route::get('image/{image}','ImageController@show');
 });


//auth routes
/*  'login'    => true,
    'logout'   => true,
    'register' => true,
    'reset'    => true,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification */

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('web.home');
Route::get('/home', 'HomeController@index');

//Main App Static routes
    Route::get('/about', 'PagesController@about')->name('about');
    Route::get('/careers', 'PagesController@careers')->name('careers');
    Route::get('/volunteers', 'PagesController@volunteer')->name('volunteers');
    Route::get('/news', 'PagesController@news')->name('news');
    Route::get('/plans', 'PagesController@plan')->name('plan');
    Route::get('/single', 'PagesController@single')->name('single');
    Route::get('/privacy', 'PagesController@privacy')->name('privacy');
    Route::get('/terms', 'PagesController@terms')->name('terms');
    Route::get('/status', 'PagesController@status')->name('status');


//Main App Dynamic Routes based on Controller

 Route::resources([
        'posts'                                   =>'PostController',
        'messages'                                =>'MessageController',
        '{job}/resumes'                            =>'ResumeController',
        'property'                                =>'PropertyController',
        'community'                               =>'CommunityController',
        'orders'                                  =>'OrderController',
    ]);

Route::get('services', 'ServiceController@category')->name('services');
Route::get('{category}', 'ServiceController@subcategory');
Route::get('{category}/{subcategory}', 'ServiceController@services');
Route::get('{category}/{subcategory}/{service}', 'ServiceController@subservices');

//App Member Dynamic Routes based on Controllers

Route::namespace('Member')->group(function(){
    // routes resources
    Route::resources([
        'posts/{post}/postcomments'               =>'PostCommentController',
        'property/{property}/propertycomments'    =>'PropertyCommentController',
        'community/{community}/volunteers'        =>'CommunityVolunteerController',
        'community/{community}/communitycomments' =>'CommunityCommentController'
    ]);

});

// post replies
Route::namespace('Member')->group(function(){
    Route::post('/comment/store', 'PostCommentController@addComment')->name('comment.add');
    Route::post('/reply/store', 'PostCommentController@replyStore')->name('reply.add');
    Route::post('/propertycomment/store', 'PropertyCommentController@addComment')->name('propertycomment.add');
    Route::post('/propertyreply/store', 'PropertyCommentController@replyStore')->name('propertyreply.add');
});

// User Backend Admin Panel
Route::get('backend', function(){
    return view('backend');
})->middleware('auth');

// Vue Programs Testing
Route::get('vuetesting', function(){
    return view('vuetesting');
});

Route::get('skills', function(){
    return ['laravel','php','Vue','Javascript','MySql'];
});

//route to send email
Route::resource('/sendmail', 'SendMailController')->only(['index','store']);



//Route::resource('users.profile', 'UserProfilesController')->shallow();

// Route::resource('comment','CommentController');
// Route::resource('community','CommunityController');
// Route::resource('contact', 'ContactsController');
// Route::resource('order', 'OrdersController');
// Route::resource('posts', 'PostsController');
// Route::resource('profile','ProfileController');
// Route::resource('property','PropertyController');
// Route::resource('resume','ResumesController');
// Route::resource('volunteer','VolunteerController');


    //Route::get('/', 'MembersController@index')->name('members');
    // Route::get('/dashboard', 'MembersController@dashboard')->name('dashboard')->middleware('auth');
    // Route::get('/member', 'MembersController@member')->name('member');

    // Route::get('posts/{post}/comments/{comment?}', function ($postId, $commentId = null) {
    //     //
    // });
    //Route::get('user/profile', function () {})->name('profile');
    //Route::get('user/{id}/profile', function ($id) {})->name('profile');
    //$url = route('profile', ['id' => 1]);
    // $url = route('profile', ['id' => 1, 'photos' => 'yes']);
    // Route::resource('posts.comments', 'PostCommentController');
    // /posts/{post}/comments/{comment}
    //Route::resource('photos.comments', 'CommentController')->shallow();





