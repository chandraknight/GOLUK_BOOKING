<?php

use Illuminate\Support\Facades\DB;

Route::post('/book/vehicle',[
    'uses'=>'FrontEndController@bookVehicleWithoutSession',
    'as'=>'book.vehicle.session'
]);

Route::post('/hotel/reserve',[
    'uses'=>'FrontEndController@bookHotelWithoutSession',
    'as'=>'hotel.reserve.session'
]);

Route::post('/tour/reserve',[
    'uses'=>'FrontEndController@bookTourWithoutSession',
    'as'=>'tour.book.session'
]);

Route::get('/booking/success/{id}',[
    'uses'=>'BookingController@bookingSuccess',
    'as'=>'booking.success'
]);

Route::get('/booking/invoice/{id}',[
    'uses'=>'FrontEndController@viewHotelInvoice',
    'as'=>'view.hotel.invoice'
]);

Route::get('/invoice/stripe/{id}',[
    'uses'=>'BookingController@viewStripe',
    'as'=>'viewstripe'
]);

Route::get('/invoice/vehicle/stripe/{id}',[
    'uses'=>'BookingController@viewVehicleStripe',
    'as'=>'viewvehiclestripe'
]);

Route::post('/invoice/payment',[
    'uses'=>'BookingController@paymentStripe',
    'as'=>'stripePayment'
]);

Route::get('/',[
    'uses'=>'FrontEndController@welcome',
    'as'=>'welcome'
]);
Route::get('/hotels',[
    'uses'=>'FrontEndController@hotelList',
    'as'=>'hotel.list'
]);

Route::get('/vehicles',[
   'uses'=>'FrontEndController@vehicleList',
   'as'=>'vehicle.list'
]);

Route::get('/hotels/more/{id}',[
    'uses'=>'FrontEndController@hotelShow',
    'as'=>'hotel.show'
]);
Route::get('/hotels/rooms/{id}',[
    'uses'=>'FrontEndController@hotelRoom',
    'as'=>'room.list'
]);

Route::get('/hotels/rooms/view/{id}',[
    'uses'=>'FrontEndController@roomShow',
    'as'=>'room.show'
]);
Route::get('/search/hotel',[
    'uses'=>'FrontEndController@searchHotel',
    'as'=>'hotelsearch.index'
]);

Route::get('/search/vehicle',[
    'uses'=>'FrontEndController@searchVehicle',
    'as'=>'vehiclesearch'
]);

Route::post('/hotel/room/book',[
    'uses'=>'FrontEndController@book',
    'as'=>'room.book'
]);

Route::post('/hotels/book',[
    'uses'=>'BookingController@register',
    'as'=>'book.register'
]);

Route::get('/vehicle/list',[
    'uses'=>'FrontEndController@listVehicle',
    'as'=>'vehicle.list'
]);

Route::get('/vehicle/view/{id}',[
    'uses'=>'FrontEndController@showVehicle',
    'as'=>'vehicle.show'
]);

Route::get('vehicle/reserve/{id}',[
    'uses'=>'FrontEndController@reserveVehicle',
    'as'=>'reservevehicle'
]);

Route::post('/vehicle/reserve',[
    'uses'=>'BookingController@reserveVehicle',
    'as'=>'vehiclereserve'
]);

Route::get('/vehicle/booking/invoice/{id}',[
    'uses'=>'BookingController@vehicleInvoice',
    'as'=>'view.vehicle.invoice'
]);

Route::get('/tours',[
    'uses'=>'FrontEndController@listTour',
    'as'=>'listtour'
]);

Route::get('/tour/search',[
    'uses'=>'FrontEndController@searchTour',
    'as'=>'toursearch'
]);

Route::get('/tour/view/{id}',[
    'uses'=>'FrontEndController@showTour',
    'as'=>'tour.show'
]);

Route::get('/tour/book/{id}',[
   'uses'=>'BookingController@tourBook',
   'as'=>'booktour'
]);

Route::post('/tour/book',[
    'uses'=>'BookingController@bookTour',
    'as'=>'tourbook'
]);

Route::get('/tour/book/invoice/{id}',[
    'uses'=>'BookingController@tourInvoice',
    'as'=>'tourinvoice'
]);

Auth::routes();
Route::group(['prefix'=>'user','middleware'=>'auth'],function(){
    Route::get('/profile/{id}',[
        'uses'=>'UserController@userProfile',
        'as'=>'profile'
    ]);

    Route::get('/profile/settings/{id}',[
        'uses'=>'UserController@userSettings',
        'as'=>'usersetting'
    ]);

    Route::post('/profile/change',[
        'uses'=>'UserController@editProfile',
        'as'=>'editprofile'
    ]);

    Route::post('/profile/change/password',[
        'uses'=>'UserController@changePassword',
        'as'=>'changepassword'
    ]);

    Route::get('/profile/bookinghistory/{id}',[
        'uses'=>'UserController@bookingHistory',
        'as'=>'userbookinghistory'
    ]);

    Route::get('/profile/commissions/{id}',[
        'middleware'=>'role:,agent',
        'uses'=>'UserController@commissions',
        'as'=>'commissions'
    ]);
});
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Hotel route group
 */
Route::group(['prefix'=>'hotel','middleware'=>['auth','role:,hotelowner,admin,superadmin']],function(){

	Route::get('/',[
		'uses'=>'HotelController@index',
		'as'=>'hotel.index'
	]);
	Route::get('/register',
		['uses'=>'HotelController@register',
		'as'=>'hotel.register'
	]);
	Route::post('/register',[
		'uses'=>'HotelController@store',
		'as'=>'hotel.store'
	]);
	Route::get('/update/{id}',[
		'uses'=>'HotelController@edit',
        'as'=>'hotel.edit'
	]);
	Route::post('/update',[
		'uses'=>'HotelController@update',
        'as'=>'hotel.update'
	]);
	Route::get('/delete/{id}',[
		'uses'=>'HotelController@delete',
		'as'=>'hotel.delete'
	]);
	Route::get('/view/{id}',[
		'uses'=>'HotelController@view',
		'as'=>'hotel.view'
	]);
	Route::get('/photo/upload/{id}',[
		'uses'=>'PhotoController@add',
		'as'=>'photo.add'
	]);
	Route::post('/photo/upload',[
		'uses'=>'PhotoController@upload',
		'as'=>'photo.upload'
	]);
	Route::get('/photo/delete/{id}',[
		'uses'=>'PhotoController@delete',
		'as'=>'photo.delete'
	]);
	Route::get('/rooms/{id}',[
	    'uses'=>'RoomsController@index',
        'as'=>'room.index'
    ]);
	Route::get('/rooms/add/{id}',[
	    'uses'=>'RoomsController@add',
        'as'=>'room.add'
    ]);
	Route::post('/rooms/register',[
	    'uses'=>'RoomsController@register',
        'as'=>'room.register'
    ]);
	Route::get('/rooms/view/{id}',[
	    'uses'=>'RoomsController@view',
        'as'=>'room.view'
    ]);
	Route::get('/rooms/edit/{id}',[
	    'uses'=>'RoomsController@edit',
        'as'=>'room.edit'
    ]);
	Route::post('/rooms/update',[
	    'uses'=>'RoomsController@update',
        'as'=>'room.update'
    ]);
	Route::get('/rooms/delete/{id}',[
	    'uses'=>'RoomsController@delete',
        'as'=>'room.delete'
    ]);


	Route::post('/roomservices/add',[
	    'uses'=>'RoomServiceController@insertService',
        'as'=>'roomservice.add'
    ]);

	
	Route::get('rooms/gallery/add/{id}',[
	    'uses'=>'RoomGalleryController@add',
        'as'=>'roomgallery.add'
    ]);
	Route::post('/rooms/gallery/insert',[
	    'uses'=>'RoomGalleryController@insert',
        'as'=>'roomgallery.insert'
    ]);
	Route::get('/rooms/gallery/delete/{id}',[
	    'uses'=>'RoomGalleryController@delete',
        'as'=>'roomgallery.delete'
    ]);
    Route::get('rooms/bookings/{id}',[
    	'uses'=>'BookingController@index',
    	'as'=>'hotel.bookings'
    ]);
    Route::get('/rooms/booking/details/{id}',[
        'uses'=>'BookingController@bookingDetails',
        'as'=>'booking.details'
    ]);
    Route::get('/rooms/booking/confirm/{id}',[
        'uses'=>'BookingController@bookConfirm',
        'as'=>'book.confirm'
    ]);
    Route::get('/rooms/booking/view/{id}',[
        'uses'=>'BookingController@viewBook',
        'as'=>'view.booking'
    ]);

    Route::get('/booking/invoice/{id}',[
        'uses'=>'BookingController@invoice',
        'as'=>'invoice.view'
    ]);

    Route::get('/booking/invoice/pay/{id}',[
        'uses'=>'BookingController@payInvoice',
        'as'=>'invoice.pay.back'
    ]);

    Route::get('/booking/cancel/{id}',[
        'uses'=>'BookingController@cancelBooking',
        'as'=>'booking.cancel'
    ]);


});

/**
 * Room Services group
 */

Route::group(['prefix'=>'rooms','middleware'=>['auth','role:,hotelowner,admin,hotelowner']],function() {

    Route::get('roomservices/{id}',[
        'uses'=>'RoomServiceController@index',
        'as'=>'roomservices.index'
    ]);

    Route::get('roomservice/edit/{id}',[
        'uses'=>'RoomServiceController@editRoomService',
        'as'=>'roomservice.edit'
    ]);

    Route::post('roomservice/update',[
        'uses'=>'RoomServiceController@updateRoomService',
        'as'=>'roomservice.update'
    ]);

    Route::get('roomservice/delete/{id}',[
        'uses'=>'RoomServiceController@deleteRoomService',
        'as'=>'roomservice.delete'
    ]);
});

/**
 * Service routes group
 */



Route::group(['prefix'=>'service','middleware'=>['auth','role:,hotelowner']],function(){
	Route::get('/{id}',[
		'uses'=>'HotelServiceController@index',
		'as'=>'service.index'
	]);
	
	Route::post('/register',[
		'uses'=>'HotelServiceController@store',
		'as'=>'service.store'
	]);
	Route::get('/update/{id}',[
		'uses'=>'HotelServiceController@edit',
		'as'=>'service.edit'
	]);
	Route::post('/update',[
		'uses'=>'HotelServiceController@update',
		'as'=>'service.update'
	]);
	Route::get('/delete/{id}',[
		'uses'=>'HotelServiceController@delete',
		'as'=>'service.delete'
	]);

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/notification/read/{$id}',[
    'uses'=>'BookingController@readnotify',
    'as'=>'notify.read'
]);

Route::get('/notification/{id}',function($id){
    $notification = DB::table('notifications')->where('id',$id)->first();
    DB::update('update notifications set read_at = now() where id=?',[$notification->id]);
    return redirect()->back();
    })
->name('notify.read');

Route::group(['prefix'=>'superadmin','middleware'=>['auth','role:,superadmin,admin']],function(){

    /**
     * roles group
     */

    Route::get('/roles',[
     'uses'=>'SuperAdmin\SuperAdminController@roles',
     'as'=>'roles'
   ]);

   Route::post('/roles/add',[
       'uses'=>'SuperAdmin\SuperAdminController@addroles',
       'as'=>'addroles'
   ]);

   Route::get('/roles/delete/{id}',[
       'uses'=>'SuperAdmin\SuperAdminController@deleterole',
       'as'=>'deleterole'
   ]);

   Route::get('/roles/edit/{id}',[
       'uses'=>'SuperAdmin\SuperAdminController@editrole',
       'as'=>'editrole'
   ]);

   Route::post('/roles/update',[
       'uses'=>'SuperAdmin\SuperAdminController@updaterole',
       'as'=>'updaterole'
   ]);

   Route::get('/roles/assign',[
       'uses'=>'SuperAdmin\SuperAdminController@roleAssign',
       'as'=>'roleassign'
   ]);

   Route::post('/roles/assign',[
       'uses'=>'SuperAdmin\SuperAdminController@assignRole',
       'as'=>'assignrole'
   ]);
   Route::get('/roles/user/edit/{id}',[
    'uses'=>'SuperAdmin\SuperAdminController@editUserRole',
    'as'=>'edituserrole'
   ]);

   /**
    * users group
    */

   Route::get('/users',[
       'uses'=>'SuperAdmin\SuperAdminController@users',
       'as'=>'users'
   ]);

   Route::get('/users/{role}',[
      'uses'=>'SuperAdmin\SuperAdminController@viewusers',
      'as'=>'viewusers'
   ]);

   /**
    * permissions group
    */
   Route::get('/permissions',[
      'uses'=>'SuperAdmin\SuperAdminController@permissions',
      'as'=>'permissions'
   ]);

   Route::post('/permissions/add',[
       'uses'=>'SuperAdmin\SuperAdminController@addPermission',
       'as'=>'addpermission'
   ]);

   Route::get('/permissions/edit/{id}',[
       'uses'=>'SuperAdmin\SuperAdminController@editPermission',
       'as'=>'editpermission'
   ]);

    Route::post('/permissions/update',[
        'uses'=>'SuperAdmin\SuperAdminController@updatePermission',
        'as'=>'updatepermission'
    ]);

    Route::get('/permissions/delete/{id}',[
        'uses'=>'SuperAdmin\SuperAdminController@deletePermission',
        'as'=>'deletepermission'
    ]);

    Route::get('/permission/grant',[
        'uses'=>'SuperAdmin\SuperAdminController@permissionAssign',
        'as'=>'permissionassign'
    ]);

    Route::post('/permission/assign',[
        'uses'=>'SuperAdmin\SuperAdminController@assignPermission',
        'as'=>'assignpermission'
    ]);

    Route::get('/hotels',[
        'uses'=>'SuperAdmin\SuperAdminController@hotels',
        'as'=>'hotels'
    ]);

    Route::get('/hotel/delete/{id}',[
        'uses'=>'SuperAdmin\SuperAdminController@deleteHotel',
        'as'=>'deletehotel'
    ]);


});

Route::group(['prefix'=>'vehicle','middleware'=>['auth','role:,vehicleowner,admin,superadmin']],function(){

    Route::get('/index',[
        'uses'=>'VehicleController@index',
        'as'=>'vehicle.index'
    ]);

    Route::get('/add',[
        'uses'=>'VehicleController@addVehicle',
        'as'=>'vehicle.add'
    ]);

    Route::post('/register/vehicle',[
        'uses'=>'VehicleController@registerVehicle',
        'as'=>'register.vehicle'
    ]);

    Route::get('/vehicle/view/{id}',[
        'uses'=>'VehicleController@viewVehicle',
        'as'=>'vehicle.view'
    ]);

    Route::get('/vehicle/delete/{id}',[
        'uses'=>'VehicleController@deleteVehicle',
        'as'=>'vehicle.delete'
    ]);

    Route::get('/vehicle/edit/{id}',[
        'uses'=>'VehicleController@editVehicle',
        'as'=>'vehicle.edit'
        ]);

    Route::post('/update',[
        'uses'=>'VehicleController@updateVehicle',
        'as'=>'vehicle.update'
    ]);

   Route::get('/vehicle/booking/{id}',[
      'uses'=>'BookingController@vehicleBookings',
      'as'=>'vehicle.booking'
   ]);

   Route::get('/vehicle/booking/confirm/{id}',[
       'uses'=>'BookingController@confirmVehicleBooking',
       'as'=>'confirmvehiclebooking'
   ]);

   Route::get('/vehicle/booking/cancel/{id}',[
       'uses'=>'BookingController@cancelVehicleBooking',
       'as'=>'cancelvehiclebooking'
   ]);

   Route::get('/vehicle/booking/invoice/{id}',[
       'uses'=>'BookingController@viewVehicleInvoice',
       'as'=>'viewvehicleinvoice'
   ]);

   Route::post('/vehicle/services/add',[
    'uses'=>'VehicleController@addServices',
    'as'=>'add.services'
   ]);
});

Route::group(['prefix'=>'tourpackage','middleware'=>['auth','role:,tourowner,admin,superadmin']],function(){

    Route::get('/index',[
        'uses'=>'TourPackageController@index',
        'as'=>'indexpackage'
    ]);

    Route::get('/add',[
       'uses'=>'TourPackageController@addPackage',
       'as'=>'addpackage'
    ]);

    Route::post('/register',[
        'uses'=>'TourPackageController@registerPackage',
        'as'=>'registerpackage'
    ]);

    Route::get('/edit/{id}',[
        'uses'=>'TourPackageController@editPackage',
        'as'=>'editpackage'
    ]);

    Route::post('/update',[
        'uses'=>'TourPackageController@updatePackage',
        'as'=>'updatepackage'
    ]);

    Route::get('/view/{id}',[
        'uses'=>'TourPackageController@viewPackage',
        'as'=>'viewpackage'
    ]);

    Route::get('/delete/{id}',[
        'uses'=>'TourPackageController@deletePackage',
        'as'=>'deletepackage'
    ]);

    Route::post('/gallery/add',[
        'uses'=>'TourPackageController@addImage',
        'as'=>'packagegallery.insert'
    ]);

    Route::get('/gallery/delete/{id}',[
        'uses'=>'TourPackageController@deleteImage',
        'as'=>'packagegallery.delete'
    ]);
    Route::get('/bookings/{id}',[
        'uses'=>'BookingController@viewTourBooking',
        'as'=>'tour.booking'
    ]);

    Route::get('/bookings/details/{id}',[
        'uses'=>'TourPackageController@viewBookingDetails',
        'as'=>'tour.book.details'
    ]);

    Route::get('/bookings/confirm/{id}',[
        'uses'=>'BookingController@confirmTourBooking',
        'as'=>'tour.confirm'
    ]);

    Route::get('/bookings/cancel/{id}',[
        'uses'=>'BookingController@cancelTourBooking',
        'as'=>'tour.cancel'
    ]);

    Route::get('/booking/invoice/{id}',[
        'uses'=>'BookingController@viewTourInvoice',
        'as'=>'viewtourinvoice'
    ]);
});

Route::group(['prefix'=>'admin','middleware'=>['auth','role:,admin,superadmin']],function(){

    Route::get('/index',[
        'uses'=>'AdminController@index',
        'as'=>'admin.index'
    ]);

    Route::get('/hotels',[
        'uses'=>'AdminController@hotel',
        'as'=>'admin.hotel'
    ]);

    Route::get('/hotel/{id}',[
        'uses'=>'AdminController@viewHotel',
        'as'=>'admin.hotel.view'
    ]);

    Route::get('/hotel/confirm/{id}',[
        'uses'=>'AdminController@confirmHotel',
        'as'=>'admin.hotel.confirm'
    ]);

    Route::get('/hotel/append/{id}',[
        'uses'=>'AdminController@appendHotel',
        'as'=>'admin.hotel.append'
    ]);

    Route::get('/vehicles',[
        'uses'=>'AdminController@vehicles',
        'as'=>'admin.vehicle'
    ]);

    Route::get('/vehicles/view/{id}',[
        'uses'=>'AdminController@viewVehicle',
        'as'=>'admin.vehicle.view'
    ]);

    Route::get('/vehicle/confirm/{id}',[
        'uses'=>'AdminController@confirmVehicle',
        'as'=>'admin.vehicle.confirm'
    ]);

    Route::get('/vehicle/append/{id}',[
        'uses'=>'AdminController@appendVehicle',
        'as'=>'admin.vehicle.append'
    ]);

    Route::get('/type',[
        'uses'=>'AdminController@vehicleType',
        'as'=>'vehicle.type.index'
    ]);

    Route::post('/type/register',[
        'uses'=>'AdminController@registerVehicleType',
        'as'=>'vehicle.type.register'
    ]);

    Route::get('/type/edit/{id}',[
        'uses'=>'AdminController@editVehicleType',
        'as'=>'vehicle.type.edit'
    ]);

    Route::post('/type/update',[
        'uses'=>'AdminController@updateVehicleType',
        'as'=>'vehicle.type.update'
    ]);

    Route::get('/type/delete/{id}',[
        'uses'=>'AdminController@deleteVehicleType',
        'as'=>'vehicle.type.delete'
    ]);

    Route::get('/service/index',[
        'uses'=>'AdminController@serviceIndex',
        'as'=>'vehicle.service.index'
    ]);

    Route::post('/service/register',[
        'uses'=>'AdminController@registerVehicleService',
        'as'=>'vehicle.service.register'
    ]);

    Route::get('/service/edit/{id}',[
        'uses'=>'AdminController@editVehicleService',
        'as'=>'vehicle.service.edit'
    ]);

    Route::post('/service/update',[
        'uses'=>'AdminController@updateVehicleService',
        'as'=>'vehicle.service.update'
    ]);

    Route::get('/service/delete/{id}',[
        'uses'=>'AdminController@deleteVehicleService',
        'as'=>'vehicle.service.delete'
    ]);

    Route::get('/tours',[
        'uses'=>'AdminController@tours',
        'as'=>'admin.tour'
    ]);

    Route::get('/tour/view/{id}',[
        'uses'=>'AdminController@viewTour',
        'as'=>'admin.tour.view'
    ]);

    Route::get('/tour/confirm/{id}',[
        'uses'=>'AdminController@confirmTour',
        'as'=>'admin.tour.confirm'
    ]);

    Route::get('/tour/append/{id}',[
        'uses'=>'AdminController@appendTour',
        'as'=>'admin.tour.append'
    ]);

    Route::get('/users',[
        'uses'=>'AdminController@users',
        'as'=>'admin.users'
    ]);

    Route::get('/users/edit/{id}',[
        'uses'=>'AdminController@editUser',
        'as'=>'admin.user.edit'
    ]);

    Route::post('/users/edit',[
        'uses'=>'AdminController@updateUser',
        'as'=>'admin.user.update'
    ]);

    Route::get('/user/delete/{id}',[
        'uses'=>'AdminController@deleteUser',
        'as'=>'admin.user.delete'
    ]);

    Route::get('/bookings/hotel',[
        'uses'=>'AdminController@hotelBookings',
        'as'=>'admin.hotel.booking'
    ]);

    Route::get('/bookings/vehicle',[
        'uses'=>'AdminController@vehicleBookings',
        'as'=>'admin.vehicle.booking'
    ]);

    Route::get('/bookings/tours',[
        'uses'=>'AdminController@tourBookings',
        'as'=>'admin.tour.booking'
    ]);

    Route::get('/booking/hotel/view/{id}',[
        'uses'=>'AdminController@viewHotelBooking',
        'as'=>'admin.view.hotel.booking'
    ]);

    Route::get('/booking/vehicle/view/{id}',[
        'uses'=>'AdminController@viewVehicleBooking',
        'as'=>'admin.view.vehicle.booking'
    ]);

    Route::get('/booking/tour/view/{id}',[
        'uses'=>'AdminController@viewTourBooking',
        'as'=>'admin.view.tour.booking'
    ]);

    Route::post('/hotel/commission',[
        'uses'=>'CommissionController@assignHotelCommission',
        'as'=>'assign.hotel.commission'
    ]);

    Route::post('/vehicle/commission',[
        'uses'=>'CommissionController@assignVehicleCommission',
        'as'=>'assign.vehicle.commission'
    ]);

    Route::post('/tour/commission',[
        'uses'=>'CommissionController@assignTourCommission',
        'as'=>'assign.tour.commission'
    ]);

    Route::get('/hotel/room/types',[
        'uses'=>'RoomTypeController@index',
        'as'=>'roomtype.index'
    ]);
    Route::post('/hotel/room/types/store',[
        'uses'=>'RoomTypeController@store',
        'as'=>'roomtype.store'
    ]);
    Route::get('/room/types/delete/{id}',[
        'uses'=>'RoomTypeController@delete',
        'as'=>'roomtype.delete'
    ]);
    Route::get('/agents/list',[
        'uses'=>'AdminController@agentList',
        'as'=>'admin.agent.list'
    ]);
    Route::get('/agents/details/{id}',[
        'uses'=>'AdminController@agentDetails',
        'as'=>'admin.agent.details'
    ]);

    Route::post('/agents/hotel/assign/commission',[
        'uses'=>'CommissionController@assignAgentHotelCommission',
        'as'=>'assign.agent.hotel.commission'
    ]);

    Route::post('/agents/vehicle/assign/commission',[
        'uses'=>'CommissionController@assignAgentVehicleCommission',
        'as'=>'assign.agent.vehicle.commission'
    ]);

    Route::post('/agents/tour/assign/commission',[
        'uses'=>'CommissionController@assignAgentTourCommission',
        'as'=>'assign.agent.tour.commission'
    ]);

    Route::get('/agents/edit/hotel/commission/{id}',[
        'uses'=>'CommissionController@edtAgentHotelCommission',
        'as'=>'edit.agent.hotel.commission'
    ]);
     Route::post('/agents/edit/hotel/commission',[
        'uses'=>'CommissionController@updateAgentHotelCommission',
        'as'=>'update.agent.hotel.commission'
    ]);

    Route::get('/agents/edit/tour/commission/{id}',[
        'uses'=>'CommissionController@edtAgentTourCommission',
        'as'=>'edit.agent.tour.commission'
    ]);
     Route::post('/agents/edit/tour/commission',[
        'uses'=>'CommissionController@updateAgentTourCommission',
        'as'=>'update.agent.tour.commission'
    ]);

    Route::get('/agents/edit/vehicle/commission/{id}',[
        'uses'=>'CommissionController@edtAgentVehicleCommission',
        'as'=>'edit.agent.vehicle.commission'
    ]);
    Route::post('/agents/edit/vehicle/commission',[
        'uses'=>'CommissionController@updateAgentVehicleCommission',
        'as'=>'update.agent.vehicle.commission'
    ]);
    Route::get('/agents/bookings/{id}',[
        'uses'=>'AdminController@agentBookings',
        'as'=>'admin.agent.booking'
    ]);


    
});