<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounts\AgentLedgerController;
use App\Http\Controllers\Admin\ActivityLog\ActivitylogController;
use App\Http\Controllers\Admin\Agent\AgentController;
use App\Http\Controllers\Admin\Agent\AgentFailController;
use App\Http\Controllers\Admin\Agent\StafflistController;
use App\Http\Controllers\Admin\Airlines\AirlineController;
use App\Http\Controllers\Admin\Booking\BookingController;
use App\Http\Controllers\Admin\Booking\BookingOtherController;
use App\Http\Controllers\Admin\Control\ControlController;
use App\Http\Controllers\AirBooking\FailedBookingController;
use App\Http\Controllers\AirBooking\AirTicketController;
use App\Http\Controllers\AirMaterials\AllAirlineController;
use App\Http\Controllers\AirMaterials\AllAirportController;
use App\Http\Controllers\AirMaterials\PassengerController;
use App\Http\Controllers\AirMaterials\AirlinesController;
use App\Http\Controllers\AirMaterials\AirportController;
use App\Http\Controllers\AirMaterials\NotificationController;
use App\Http\Controllers\AirSearch\GroupFareController;
use App\Http\Controllers\AirSearch\ControlsController;
use App\Http\Controllers\Auth\AuthAgentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//agentLedger route
Route::get('/allLedger', [AgentLedgerController::class, 'index']);
Route::post('/storeLedger', [AgentLedgerController::class, 'store']);
Route::get('/editLedger/{id}', [AgentLedgerController::class, 'edit']);
Route::get('/updateLedger/{id}', [AgentLedgerController::class, 'update']);
Route::delete('/deleteLedger/{id}', [AgentLedgerController::class, 'destroy']);

//activitylog route
Route::get('/allActivityLog', [ActivitylogController::class, 'index']);
Route::post('/storeActivityLog', [ActivitylogController::class, 'store']);
Route::get('/editActivityLog/{id}', [ActivitylogController::class, 'edit']);
Route::put('/updateActivityLog/{id}', [ActivitylogController::class, 'update']);
Route::delete('/deleteActivityLog/{id}', [ActivitylogController::class, 'destroy']);

//agent route
Route::get('/allAgent', [AgentController::class, 'index']);
Route::post('/storeAgent', [AgentController::class, 'store']);
Route::get('/editAgent/{id}', [AgentController::class, 'edit']);
Route::put('/updateAgent/{id}', [AgentController::class, 'update']);
Route::delete('/deleteAgent/{id}', [AgentController::class, 'destroy']);

//agentFail route
Route::get('/allAgentFail', [AgentFailController::class, 'index']);
Route::post('/storeAgentFail', [AgentFailController::class, 'store']);
Route::get('/editAgentFail/{id}', [AgentFailController::class, 'edit']);
Route::put('/updateAgentFail/{id}', [AgentFailController::class, 'update']);
Route::delete('/deleteAgentFail/{id}', [AgentFailController::class, 'destroy']);


//staffList route
Route::get('/allstaffList', [StafflistController::class, 'index']);
Route::post('/storestaffList', [StafflistController::class, 'store']);
Route::get('/editstaffList/{id}', [StafflistController::class, 'edit']);
Route::put('/updatestaffList/{id}', [StafflistController::class, 'update']);
Route::delete('/deletestaffList/{id}', [StafflistController::class, 'destroy']);

//AirlineC route
Route::get('/allAirline', [AirlineController::class, 'index']);
Route::post('/storeAirline', [AirlineController::class, 'store']);
Route::get('/editAirline/{id}', [AirlineController::class, 'edit']);
Route::put('/updateAirline/{id}', [AirlineController::class, 'update']);
Route::delete('/deleteAirline/{id}', [AirlineController::class, 'destroy']);

//Booking route
Route::get('/allBooking', [BookingController::class, 'index']);
Route::post('/storeBooking', [BookingController::class, 'store']);
Route::get('/editBooking/{id}', [BookingController::class, 'edit']);
Route::put('/updateBooking/{id}', [BookingController::class, 'update']);
Route::delete('/deleteBooking/{id}', [BookingController::class, 'destroy']);

//Bookingother route
Route::get('/allBookingother', [BookingOtherController::class, 'index']);
Route::post('/storeBookingother', [BookingOtherController::class, 'store']);
Route::get('/editBookingother/{id}', [BookingOtherController::class, 'edit']);
Route::put('/updateBookingother/{id}', [BookingOtherController::class, 'update']);
Route::delete('/deleteBookingother/{id}', [BookingOtherController::class, 'destroy']);

//Control route
Route::get('/allControl', [ControlController::class, 'index']);
Route::post('/storeControl', [ControlController::class, 'store']);
Route::get('/editControl/{id}', [ControlController::class, 'edit']);
Route::put('/updateControl/{id}', [ControlController::class, 'update']);
Route::delete('/deleteControl/{id}', [ControlController::class, 'destroy']);

//bookingFailed route
Route::get('/allbookingFailed', [FailedBookingController::class, 'index']);
Route::post('/storebookingFailed', [FailedBookingController::class, 'store']);
Route::get('/editbookingFailed/{id}', [FailedBookingController::class, 'edit']);
Route::put('/updatebookingFailed/{id}', [FailedBookingController::class, 'update']);
Route::delete('/deletebookingFailed/{id}', [FailedBookingController::class, 'destroy']);

//AirTicket route
Route::get('/allAirTicket', [AirTicketController::class, 'index']);
Route::post('/storeAirTicket', [AirTicketController::class, 'store']);
Route::get('/editAirTicket/{id}', [AirTicketController::class, 'edit']);
Route::put('/updateAirTicket/{id}', [AirTicketController::class, 'update']);
Route::delete('/deleteAirTicket/{id}', [AirTicketController::class, 'destroy']);

//AllAirline route
Route::get('/AllAirline', [AllAirlineController::class, 'index']);
Route::post('/storeAllAirline', [AllAirlineController::class, 'store']);
Route::get('/editAllAirline/{id}', [AllAirlineController::class, 'edit']);
Route::put('/updateAllAirline/{id}', [AllAirlineController::class, 'update']);
Route::delete('/deleteAllAirline/{id}', [AllAirlineController::class, 'destroy']);

//AllAirport route
Route::get('/AllAirport', [AllAirportController::class, 'index']);
Route::post('/storeAllAirport', [AllAirportController::class, 'store']);
Route::get('/editAllAirport/{id}', [AllAirportController::class, 'edit']);
Route::put('/updateAllAirport/{id}', [AllAirportController::class, 'update']);
Route::delete('/deleteAllAirport/{id}', [AllAirportController::class, 'destroy']);

//Passenger route
Route::get('/AllPassenger', [PassengerController::class, 'index']);
Route::post('/storePassenger', [PassengerController::class, 'store']);
Route::get('/editPassenger/{id}', [PassengerController::class, 'edit']);
Route::put('/updatePassenger/{id}', [PassengerController::class, 'update']);
Route::delete('/deletePassenger/{id}', [PassengerController::class, 'destroy']);

//Airline route
Route::get('/allAirline', [AirlinesController::class, 'index']);
Route::post('/storeAirline', [AirlinesController::class, 'store']);
Route::get('/editAirline/{id}', [AirlinesController::class, 'edit']);
Route::put('/updateAirline/{id}', [AirlinesController::class, 'update']);
Route::delete('/deleteAirline/{id}', [AirlinesController::class, 'destroy']);

//Airport route
Route::get('/allAirport', [AirportController::class, 'index']);
Route::post('/storeAirport', [AirportController::class, 'store']);
Route::get('/editAirport/{id}', [AirportController::class, 'edit']);
Route::put('/updateAirport/{id}', [AirportController::class, 'update']);
Route::delete('/deleteAirport/{id}', [AirportController::class, 'destroy']);

//Notification route
Route::get('/allNotification', [NotificationController::class, 'index']);
Route::post('/storeNotification', [NotificationController::class, 'store']);
Route::get('/editNotification/{id}', [NotificationController::class, 'edit']);
Route::put('/updateNotification/{id}', [NotificationController::class, 'update']);
Route::delete('/deleteNotification/{id}', [NotificationController::class, 'destroy']);

//GroupFare route
Route::get('/allGroupFare', [GroupFareController::class, 'index']);
Route::post('/storeGroupFare', [GroupFareController::class, 'store']);
Route::get('/editGroupFare/{id}', [GroupFareController::class, 'edit']);
Route::put('/updateGroupFare/{id}', [GroupFareController::class, 'update']);
Route::delete('/deleteGroupFare/{id}', [GroupFareController::class, 'destroy']);

//Controls route
Route::get('/allControls', [ControlsController::class, 'index']);
Route::post('/storeControls', [ControlsController::class, 'store']);
Route::get('/editControls/{id}', [ControlsController::class, 'edit']);
Route::put('/updateControls/{id}', [ControlsController::class, 'update']);
Route::delete('/deleteControls/{id}', [ControlsController::class, 'destroy']);

//AuthAgent route
Route::get('/allAuthAgent', [AuthAgentController::class, 'index']);
Route::post('/storeAuthAgent', [AuthAgentController::class, 'store']);
Route::get('/editAuthAgent/{id}', [AuthAgentController::class, 'edit']);
Route::put('/updateAuthAgent/{id}', [AuthAgentController::class, 'update']);
Route::delete('/deleteAuthAgent/{id}', [AuthAgentController::class, 'destroy']);

//Coupon route
Route::get('/allCoupon', [App\Http\Controllers\Coupon\CouponController::class, 'index']);
Route::post('/storeCoupon', [App\Http\Controllers\Coupon\CouponController::class, 'store']);
Route::get('/editCoupon/{id}', [App\Http\Controllers\Coupon\CouponController::class, 'edit']);
Route::put('/updateCoupon/{id}', [App\Http\Controllers\Coupon\CouponController::class, 'update']);
Route::delete('/deleteCoupon/{id}', [App\Http\Controllers\Coupon\CouponController::class, 'destroy']);

//DepositRequest route
Route::get('/allDepositRequest', [App\Http\Controllers\Deposit\DepositRequestController::class, 'index']);
Route::post('/storeDepositRequest', [App\Http\Controllers\Deposit\DepositRequestController::class, 'store']);
Route::get('/editDepositRequest/{id}', [App\Http\Controllers\Deposit\DepositRequestController::class, 'edit']);
Route::put('/updateDepositRequest/{id}', [App\Http\Controllers\Deposit\DepositRequestController::class, 'update']);
Route::delete('/deleteDepositRequest/{id}', [App\Http\Controllers\Deposit\DepositRequestController::class, 'destroy']);

//BankContact route
Route::get('/allBankContact', [App\Http\Controllers\Deposit\BankContactController::class, 'index']);
Route::post('/storeBankContact', [App\Http\Controllers\Deposit\BankContactController::class, 'store']);
Route::get('/editBankContact/{id}', [App\Http\Controllers\Deposit\BankContactController::class, 'edit']);
Route::put('/updateBankContact/{id}', [App\Http\Controllers\Deposit\BankContactController::class, 'update']);
Route::delete('/deleteBankContact/{id}', [App\Http\Controllers\Deposit\BankContactController::class, 'destroy']);

//Airbooking route
Route::get('/allAirbooking', [App\Http\Controllers\FlyHub\AirbookingController::class, 'index']);
Route::post('/storeAirbooking', [App\Http\Controllers\FlyHub\AirbookingController::class, 'store']);
Route::get('/editAirbooking/{id}', [App\Http\Controllers\FlyHub\AirbookingController::class, 'edit']);
Route::put('/updateAirbooking/{id}', [App\Http\Controllers\FlyHub\AirbookingController::class, 'update']);
Route::delete('/deleteAirbooking/{id}', [App\Http\Controllers\FlyHub\AirbookingController::class, 'destroy']);

//Airbooking route
Route::get('/allGAirbooking', [App\Http\Controllers\Galileo\AirbookingController::class, 'index']);
Route::post('/storeGAirbooking', [App\Http\Controllers\Galileo\AirbookingController::class, 'store']);
Route::get('/editGAirbooking/{id}', [App\Http\Controllers\Galileo\AirbookingController::class, 'edit']);
Route::put('/updateGAirbooking/{id}', [App\Http\Controllers\Galileo\AirbookingController::class, 'update']);
Route::delete('/deleteGAirbooking/{id}', [App\Http\Controllers\Galileo\AirbookingController::class, 'destroy']);

//Notification route
Route::get('/allNotifications', [App\Http\Controllers\Notification\NotificationController::class, 'index']);
Route::post('/storeNotifications', [App\Http\Controllers\Notification\NotificationController::class, 'store']);
Route::get('/editNotifications/{id}', [App\Http\Controllers\Notification\NotificationController::class, 'edit']);
Route::put('/updateNotifications/{id}', [App\Http\Controllers\Notification\NotificationController::class, 'update']);
Route::delete('/deleteNotifications/{id}', [App\Http\Controllers\Notification\NotificationController::class, 'destroy']);

//Queues-booking route
Route::get('/allQbooking', [App\Http\Controllers\Queues\BookingController::class, 'index']);
Route::post('/storeQbooking', [App\Http\Controllers\Queues\BookingController::class, 'store']);
Route::get('/editQbooking/{id}', [App\Http\Controllers\Queues\BookingController::class, 'edit']);
Route::put('/updateQbooking/{id}', [App\Http\Controllers\Queues\BookingController::class, 'update']);
Route::delete('/deleteQbooking/{id}', [App\Http\Controllers\Queues\BookingController::class, 'destroy']);

//Queues-Passenger route
Route::get('/allQPassenger', [App\Http\Controllers\Queues\PassengerController::class, 'index']);
Route::post('/storeQPassenger', [App\Http\Controllers\Queues\PassengerController::class, 'store']);
Route::get('/editQPassenger/{id}', [App\Http\Controllers\Queues\PassengerController::class, 'edit']);
Route::put('/updateQPassenger/{id}', [App\Http\Controllers\Queues\PassengerController::class, 'update']);
Route::delete('/deleteQPassenger/{id}', [App\Http\Controllers\Queues\PassengerController::class, 'destroy']);

//Queues-StaffList route
Route::get('/allQStaffList', [App\Http\Controllers\Queues\StafflistController::class, 'index']);
Route::post('/storeQStaffList', [App\Http\Controllers\Queues\StafflistController::class, 'store']);
Route::get('/editQStaffList/{id}', [App\Http\Controllers\Queues\StafflistController::class, 'edit']);
Route::put('/updateQStaffList/{id}', [App\Http\Controllers\Queues\StafflistController::class, 'update']);
Route::delete('/deleteQStaffList/{id}', [App\Http\Controllers\Queues\StafflistController::class, 'destroy']);

//Queues-Ticketed route
Route::get('/allQTicketed', [App\Http\Controllers\Queues\TicketedController::class, 'index']);
Route::post('/storeQTicketed', [App\Http\Controllers\Queues\TicketedController::class, 'store']);
Route::get('/editQTicketed/{id}', [App\Http\Controllers\Queues\TicketedController::class, 'edit']);
Route::put('/updateQTicketed/{id}', [App\Http\Controllers\Queues\TicketedController::class, 'update']);
Route::delete('/deleteQTicketed/{id}', [App\Http\Controllers\Queues\TicketedController::class, 'destroy']);

//SearchHistory route
Route::get('/allSearchHistory', [App\Http\Controllers\SearchHistory\SearchHistoryController::class, 'index']);
Route::post('/storeSearchHistory', [App\Http\Controllers\SearchHistory\SearchHistoryController::class, 'store']);
Route::get('/editSearchHistory/{id}', [App\Http\Controllers\SearchHistory\SearchHistoryController::class, 'edit']);
Route::put('/updateSearchHistory/{id}', [App\Http\Controllers\SearchHistory\SearchHistoryController::class, 'update']);
Route::delete('/deleteSearchHistory/{id}', [App\Http\Controllers\SearchHistory\SearchHistoryController::class, 'destroy']);


//Search-Agent route
Route::get('/allSAgent', [App\Http\Controllers\SearchHistory\AgentController::class, 'index']);
Route::post('/storeSAgent', [App\Http\Controllers\SearchHistory\AgentController::class, 'store']);
Route::get('/editSAgent/{id}', [App\Http\Controllers\SearchHistory\AgentController::class, 'edit']);
Route::put('/updateSAgent/{id}', [App\Http\Controllers\SearchHistory\AgentController::class, 'update']);
Route::delete('/deleteSAgent/{id}', [App\Http\Controllers\SearchHistory\AgentController::class, 'destroy']);

//Staff route
Route::get('/allStaff', [App\Http\Controllers\Staff\StafflistController::class, 'index']);
Route::post('/storeStaff', [App\Http\Controllers\Staff\StafflistController::class, 'store']);
Route::get('/editStaff/{id}', [App\Http\Controllers\Staff\StafflistController::class, 'edit']);
Route::put('/updateStaff/{id}', [App\Http\Controllers\Staff\StafflistController::class, 'update']);
Route::delete('/deleteStaff/{id}', [App\Http\Controllers\Staff\StafflistController::class, 'destroy']);

//VisaInfo route
Route::get('/allVisaInfo', [App\Http\Controllers\Visa\VisaInfoController::class, 'index']);
Route::post('/storeVisaInfo', [App\Http\Controllers\Visa\VisaInfoController::class, 'store']);
Route::get('/editVisaInfo/{id}', [App\Http\Controllers\Visa\VisaInfoController::class, 'edit']);
Route::put('/updateVisaInfo/{id}', [App\Http\Controllers\Visa\VisaInfoController::class, 'update']);
Route::delete('/deleteVisaInfo/{id}', [App\Http\Controllers\Visa\VisaInfoController::class, 'destroy']);

//Visa route
Route::get('/allVisa', [App\Http\Controllers\Visa\VisaController::class, 'index']);
Route::post('/storeVisa', [App\Http\Controllers\Visa\VisaController::class, 'store']);
Route::get('/editVisa/{id}', [App\Http\Controllers\Visa\VisaController::class, 'edit']);
Route::put('/updateVisa/{id}', [App\Http\Controllers\Visa\VisaController::class, 'update']);
Route::delete('/deleteVisa/{id}', [App\Http\Controllers\Visa\VisaController::class, 'destroy']);

//TourPackages route
Route::get('/allTour', [App\Http\Controllers\Package\TourController::class, 'index']);
Route::post('/storeTour', [App\Http\Controllers\Package\TourController::class, 'store']);
Route::get('/editTour/{id}', [App\Http\Controllers\Package\TourController::class, 'edit']);
Route::put('/updateTour/{id}', [App\Http\Controllers\Package\TourController::class, 'update']);
Route::delete('/deleteTour/{id}', [App\Http\Controllers\Package\TourController::class, 'destroy']);

//DepositRequest route
Route::get('/all_D_Request', [App\Http\Controllers\Admin\DepositRequest\DepositRequestController::class, 'index']);
Route::post('/store_D_Request', [App\Http\Controllers\Admin\DepositRequest\DepositRequestController::class, 'store']);
Route::get('/edit_D_Request/{id}', [App\Http\Controllers\Admin\DepositRequest\DepositRequestController::class, 'edit']);
Route::put('/update_D_Request/{id}', [App\Http\Controllers\Admin\DepositRequest\DepositRequestController::class, 'update']);
Route::delete('/delete_D_Request/{id}', [App\Http\Controllers\Admin\DepositRequest\DepositRequestController::class, 'destroy']);

//DeletedAgent route
Route::get('/allDeletedAgent', [App\Http\Controllers\Admin\Agent\DeleteAgentController::class, 'index']);
Route::post('/storeDeletedAgent', [App\Http\Controllers\Admin\Agent\DeleteAgentController::class, 'store']);
Route::get('/editDeletedAgent/{id}', [App\Http\Controllers\Admin\Agent\DeleteAgentController::class, 'edit']);
Route::put('/updateDeletedAgent/{id}', [App\Http\Controllers\Admin\Agent\DeleteAgentController::class, 'update']);
Route::delete('/deleteDeletedAgent/{id}', [App\Http\Controllers\Admin\Agent\DeleteAgentController::class, 'destroy']);

//Refund route
Route::get('/allRefund', [App\Http\Controllers\Admin\Ticketed\RefundController::class, 'index']);
Route::post('/storeRefund', [App\Http\Controllers\Admin\Ticketed\RefundController::class, 'store']);
Route::get('/editRefund/{id}', [App\Http\Controllers\Admin\Ticketed\RefundController::class, 'edit']);
Route::put('/updateRefund/{id}', [App\Http\Controllers\Admin\Ticketed\RefundController::class, 'update']);
Route::delete('/deleteRefund/{id}', [App\Http\Controllers\Admin\Ticketed\RefundController::class, 'destroy']);

//Reissue route
Route::get('/allReissue', [App\Http\Controllers\Admin\Ticketed\ReissueController::class, 'index']);
Route::post('/storeReissue', [App\Http\Controllers\Admin\Ticketed\ReissueController::class, 'store']);
Route::get('/editReissue/{id}', [App\Http\Controllers\Admin\Ticketed\ReissueController::class, 'edit']);
Route::put('/updateReissue/{id}', [App\Http\Controllers\Admin\Ticketed\ReissueController::class, 'update']);
Route::delete('/deleteReissue/{id}', [App\Http\Controllers\Admin\Ticketed\ReissueController::class, 'destroy']);

//Voided route
Route::get('/allVoided', [App\Http\Controllers\Admin\Ticketed\VoidController::class, 'index']);
Route::post('/storeVoided', [App\Http\Controllers\Admin\Ticketed\VoidController::class, 'store']);
Route::get('/editVoided/{id}', [App\Http\Controllers\Admin\Ticketed\VoidController::class, 'edit']);
Route::put('/updateVoided/{id}', [App\Http\Controllers\Admin\Ticketed\VoidController::class, 'update']);
Route::delete('/deleteVoided/{id}', [App\Http\Controllers\Admin\Ticketed\VoidController::class, 'destroy']);

//Note route
Route::get('/allNote', [App\Http\Controllers\Admin\Notes\NoteController::class, 'index']);
Route::post('/storeNote', [App\Http\Controllers\Admin\Notes\NoteController::class, 'store']);
Route::get('/editNote/{id}', [App\Http\Controllers\Admin\Notes\NoteController::class, 'edit']);
Route::put('/updateNote/{id}', [App\Http\Controllers\Admin\Notes\NoteController::class, 'update']);
Route::delete('/deleteNote/{id}', [App\Http\Controllers\Admin\Notes\NoteController::class, 'destroy']);

//Ticketing route
Route::get('/allTicketing', [App\Http\Controllers\Admin\Ticketing\TicketingController::class, 'index']);
Route::post('/storeTicketing', [App\Http\Controllers\Admin\Ticketing\TicketingController::class, 'store']);
Route::get('/editTicketing/{id}', [App\Http\Controllers\Admin\Ticketing\TicketingController::class, 'edit']);
Route::put('/updateTicketing/{id}', [App\Http\Controllers\Admin\Ticketing\TicketingController::class, 'update']);
Route::delete('/deleteTicketing/{id}', [App\Http\Controllers\Admin\Ticketing\TicketingController::class, 'destroy']);


//VisaCheckList route
Route::get('/allVisaCheckList', [App\Http\Controllers\Visa\VisaCheckListController::class, 'index']);
Route::post('/storeVisaCheckList', [App\Http\Controllers\Visa\VisaCheckListController::class, 'store']);
Route::get('/editVisaCheckList/{id}', [App\Http\Controllers\Visa\VisaCheckListController::class, 'edit']);
Route::put('/updateVisaCheckList/{id}', [App\Http\Controllers\Visa\VisaCheckListController::class, 'update']);
Route::delete('/deleteVisaCheckList/{id}', [App\Http\Controllers\Visa\VisaCheckListController::class, 'destroy']);

//GroupFare route
Route::get('/all_G_Fare', [App\Http\Controllers\Admin\GroupFare\GroupFareController::class, 'index']);
Route::post('/store_G_Fare', [App\Http\Controllers\Admin\GroupFare\GroupFareController::class, 'store']);
Route::get('/edit_G_Fare/{id}', [App\Http\Controllers\Admin\GroupFare\GroupFareController::class, 'edit']);
Route::put('/update_G_Fare/{id}', [App\Http\Controllers\Admin\GroupFare\GroupFareController::class, 'update']);
Route::delete('/delete_G_Fare/{id}', [App\Http\Controllers\Admin\GroupFare\GroupFareController::class, 'destroy']);

//PartialPayment route
Route::get('/allPartialPayment', [App\Http\Controllers\Admin\DepositRequest\PartialPaymentController::class, 'index']);
Route::post('/storePartialPayment', [App\Http\Controllers\Admin\DepositRequest\PartialPaymentController::class, 'store']);
Route::get('/editPartialPayment/{id}', [App\Http\Controllers\Admin\DepositRequest\PartialPaymentController::class, 'edit']);
Route::put('/updatePartialPayment/{id}', [App\Http\Controllers\Admin\DepositRequest\PartialPaymentController::class, 'update']);
Route::delete('/deletePartialPayment/{id}', [App\Http\Controllers\Admin\DepositRequest\PartialPaymentController::class, 'destroy']);

//SegmentOneWay route
Route::get('/allSegmentOneWay', [App\Http\Controllers\AirBooking\SegmentOneWayController::class, 'index']);
Route::post('/storeSegmentOneWay', [App\Http\Controllers\AirBooking\SegmentOneWayController::class, 'store']);
Route::get('/editSegmentOneWay/{id}', [App\Http\Controllers\AirBooking\SegmentOneWayController::class, 'edit']);
Route::put('/updateSegmentOneWay/{id}', [App\Http\Controllers\AirBooking\SegmentOneWayController::class, 'update']);
Route::delete('/deleteSegmentOneWay/{id}', [App\Http\Controllers\AirBooking\SegmentOneWayController::class, 'destroy']);

//SegmentReturnWay route
Route::get('/allSegmentReturnWay', [App\Http\Controllers\AirBooking\SegmentReturnWayController::class, 'index']);
Route::post('/storeSegmentReturnWay', [App\Http\Controllers\AirBooking\SegmentReturnWayController::class, 'store']);
Route::get('/editSegmentReturnWay/{id}', [App\Http\Controllers\AirBooking\SegmentReturnWayController::class, 'edit']);
Route::put('/updateSegmentReturnWay/{id}', [App\Http\Controllers\AirBooking\SegmentReturnWayController::class, 'update']);
Route::delete('/deleteSegmentReturnWay/{id}', [App\Http\Controllers\AirBooking\SegmentReturnWayController::class, 'destroy']);

//airSearch/oneway route
Route::get('/oneway', [App\Http\Controllers\AirSearch\OneWayController::class, 'Oneway']);
