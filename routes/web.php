<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\BankDetailController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\MedaiController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\Controller;
use App\Http\Controllers\Admin\CounterInfoController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PermissionController;
// use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DonnerController;
use App\Http\Controllers\Admin\EmaileTemplatesController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\InternalLinksController;
use App\Http\Controllers\Admin\IntroductionController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PaymentSettingController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteMenuController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SmtpController;
use App\Http\Controllers\Admin\Sub_CategoryController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\SupportersController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Models\Admin\InternalLinks;
use App\Models\Admin\PaymentSettings;
use App\Models\Admin\Program;

require_once __DIR__ . '/auth.php';

//Admin Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', function () {
        return view('layouts.app');
    });

    Route::resources([
        'admin/menus' => MenuController::class,
        'admin/permissions' => PermissionController::class,
        'admin/roles' => RoleController::class,
        'admin/users' => UserController::class,
        'admin/categories' => CategoriesController::class,
        'admin/sub_categories' => Sub_CategoryController::class,
        'admin/blogs' => BlogsController::class,
        'admin/pages' => PagesController::class,
        'admin/albums' => AlbumController::class,
        'admin/media' => MedaiController::class,
        'admin/banners' => BannerController::class,
        'admin/internal_links' => InternalLinksController::class,
        'admin/site_settings' => SiteSettingController::class,
        'admin/homesetting' => HomeSettingController::class,
        'admin/site_menus' => SiteMenuController::class,
        'admin/email_templates' => EmaileTemplatesController::class,
        'admin/popups' => PopupController::class,
        'admin/notices' => NoticeController::class,
        'admin/services' => ServiceController::class,
        'admin/team-members' => TeamMemberController::class,
        'admin/faqs' => FaqController::class,
        'admin/counter_infos' => CounterInfoController::class,
        'admin/donner' => DonnerController::class,
        'admin/supporter' => SupportersController::class,
        'admin/paymentmethod' => PaymentController::class,
        'admin/contact' => ContactController::class,
        'admin/newsletter' => NewsletterController::class,
        'admin/volunteer' => VolunteerController::class,
        'admin/testimonial' => TestimonialController::class,
        'admin/event' => EventController::class,
        'admin/program' => ProgramController::class,
        'admin/introductionsetting' => IntroductionController::class,
        'admin/bank' => BankDetailController::class,
        'admin/paymentsetting' => PaymentSettingController::class,
        'admin/smtp' => SmtpController::class,
        'admin/product' => ProductController::class,
        'admin/discount' => DiscountController::class,
        'admin/review' => ReviewController::class,
    ]);

// Edit profile route

    Route::get('/admin/users/{id}/profile/edit', [UserController::class, 'editProfile'])->name('users.eprof');
    Route::put('/admin/users/{id}/profile/update', [UserController::class, 'updProfile'])->name('users.profile');
    Route::get("/admin/users/{id}/password/change", [UserController::class, 'editPwd'])->name('users.pwd');
    Route::put("/admin/users/{id}/password/update", [UserController::class, 'updPwd'])->name('users.pupd');

    Route::get('/admin/getproduct/{id}', [HomeSettingController::class, 'getProd'])->name('ajax.getprod');


    Route::post('/getsub_category', [BlogsController::class, 'getsub_category']);
    Route::post('/getsub_category', [BlogsController::class, 'getsub_category']);
    Route::post('/getcategory_new', [SiteMenuController::class, 'getcategory_new']);
    Route::post('/getopic', [SiteMenuController::class, 'getopic']);
    Route::post('/getcurrency', [PatrnerController::class, 'getcurrency']);
    Route::post('menus/{menu}/assign', [MenuController::class, 'assign'])->name('menus.assign');
    Route::post('roles/{role}/assign', [RoleController::class, 'assign'])->name('roles.assign');
    //dashboard related routes
    Route::post('admin/dashboard/getcategory', [DashboardController::class, 'getcategorybytype']);
    Route::post('admin/dashboard/getsubcategory', [DashboardController::class, 'getsubcategorybycategory']);
    Route::get('admin/dashboard/change_status', [DashboardController::class, 'change']);
    Route::get('admin/dashboard/change_is_featured', [DashboardController::class, 'change_is_featured']);
    Route::post('admin/dashboard/update_order/{id}', [DashboardController::class, 'update_order']);
    //data ajax routes
    Route::get('/data_ajax', [CategoriesController::class, 'data_ajax']);
    Route::get('/donner/data_ajax', [DonnerController::class, 'data_ajax']);
    Route::get('/bank/data_ajax', [BankDetailController::class, 'data_ajax']);
    Route::get('/supporter/data_ajax', [SupportersController::class, 'data_ajax']);
    Route::get('/paymentmethod/data_ajax', [PaymentController::class, 'data_ajax']);
    Route::get('/contact/data_ajax', [ContactController::class, 'data_ajax']);
    Route::get('/newsletter/data_ajax', [NewsletterController::class, 'data_ajax']);
    Route::get('/volunteer/data_ajax', [VolunteerController::class, 'data_ajax']);
    Route::get('/testimonial/data_ajax', [TestimonialController::class, 'data_ajax']);
    Route::get('/albums/data_ajax', [AlbumController::class, 'data_ajax']);
    Route::get('/event/data_ajax', [EventController::class, 'data_ajax']);
    Route::get('/program/data_ajax', [ProgramController::class, 'data_ajax']);
   //------- 
    Route::get('/sub_cat_data', [Sub_CategoryController::class, 'sub_cat_data']);
    Route::get('/blog_data', [BlogsController::class, 'blog_data']);
    Route::get('/product_data', [ProductController::class, 'product_data']);
    Route::get('/order_data', [AdminOrderController::class, 'order_data']);
    Route::get('/discount_data', [DiscountController::class, 'discount_data']);
    Route::get('/page_data', [PagesController::class, 'page_data']);
    Route::get('/banner_data', [BannerController::class, 'banner_data']);
    Route::get('/review_data', [ReviewController::class, 'review_data']);
    Route::get('/user_data', [UserController::class, 'user_data']);
    Route::get('/internal_link_data', [InternalLinksController::class, 'internal_link_data']);
    Route::get('/permission_data', [PermissionController::class, 'permission_data']);
    Route::get('/role_data', [RoleController::class, 'role_data']);
    Route::get('/popup_data', [PopupController::class, 'popup_data']);
    Route::get('/notice_data', [NoticeController::class, 'notice_data']);
    Route::get('/service_data', [ServiceController::class, 'service_data']);
    Route::get('/team_data', [TeamMemberController::class, 'team_data']);
    Route::get('/faq_data', [FaqController::class, 'faq_data']);
    Route::get('/counter_data', [CounterInfoController::class, 'counter_data']);
    Route::get('/event_data', [EventController::class, 'event_data']);
    Route::get('/email_data', [EmaileTemplatesController::class, 'email_data']);
    Route::get('/paste', [Controller::class, 'past']);
});



//Frontend Routes
// Route::get('/', function () {
//     return view('Frontend.home.main.index');
// });


Route::get('/products', [PageController::class, 'getProduct']);
Route::get('/product/{slug}', [PageController::class, 'getProdDetail']);
Route::get('/products/category/{slug}', [PageController::class, 'getProduct']);

// gallery route
Route::get('/gallery', [PageController::class, 'getGallery']);


// ========== customer portal ================================
Route::controller(FrontendUserController::class)->group(function() {
    Route::get('/login', 'register')->name('customer.register'); 
    Route::post('/login', 'customerLogin')->name('customer.access'); 
    Route::get('/customer/logout', 'logout')->name('customer.logout'); 
    Route::get('/user/{token}/validate', 'validateToken')->name('customer.validate'); 
    Route::get('/cart', 'cart')->name('customer.cart'); 
    Route::post('/cart', 'addCart')->name('customer.addCart'); 
    Route::post('/cart/remove', 'rmvCart')->name('customer.rmvCart'); 
    Route::get('/cart/{id}/clear', 'clearCart')->name('cart.clear'); 
    Route::get('/user', 'getProfile')->name('customer.profile'); 
    Route::get('/user/{id}/order', 'orderDetail')->name('customer.order'); 
});

// ====================== Order Controller ======================
Route::controller(OrderController::class)->group(function() {
    Route::post('/order', 'checkMethod')->name('order.check'); 
    Route::get('/order/validate/{prod}/{type}', 'validatePayment')->name('order.validate'); 
});

Route::controller(AdminOrderController::class)->group(function() {
    Route::post('/admin/order/{id}/destroy', 'destroy')->name('order.destroy'); 
    Route::get('/admin/order', 'index')->name('order.index'); 
});


// Frontend ajax url ...............


// thematic areas
Route::get('/area', [HomeController::class, 'thematicView']);

//home route
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [PageController::class, 'getAbout']);
Route::get('/introduction', [PageController::class, 'getAbout']);


// ====== product ================================
// Route::controller(ProductController::class)->group(function() {
//     Route::get('/admin/product/create', 'create')->name('product.create')->middleware('auth'); 
//     Route::post('/admin/product/store','store')->name('product.store');
// });



//payment route
Route::get('/payment-message/{type}', [PageController::class, 'paymentMsg']);

//Search Route
Route::post('/search', [PageController::class, 'searchDB']);


//become a volunteer routes
Route::get('/become-a-volunteer', [PageController::class, 'volunteerForm']);
Route::post('/volunteer/submit', [PageController::class, 'submitVolunteerForm']);
// contact us route 
// Route::get('/contact-us', [PageController::class, 'contactUsForm']);
Route::post('/contact-us/submit', [PageController::class, 'submitContactForm']);
// Comment Controlls
Route::post('/comment/submit/{model}', [PageController::class, 'publishComment']);

// donner form
Route::post('/donate-now/submit', [PageController::class, 'submitDonnerForm']);
Route::get('/donate-now', [PageController::class, 'getDonnerForm']);
Route::get('/donate-now/{id}', [PageController::class, 'getDonnerForm']);

// Pages with category filter
Route::get('area/{slug}', [PageController::class, 'thematicDetail']);


//pages and details route
Route::get('/{link}', [PageController::class, 'getLink']);
// Route::get('/{link}/{slug}', [PageController::class, 'getDetail']);

