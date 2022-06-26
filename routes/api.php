<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ItTrainController;
use App\Http\Controllers\ItConsultController;
use App\Http\Controllers\ManagedItController;
use App\Http\Controllers\CompCareController;
use App\Http\Controllers\ProceduresController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AdminCampaignController;
use App\Http\Controllers\AdminNoticesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CostsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\NotesController;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Mail;

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
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::post('/sales/store', [SalesController::class, 'store']);
Route::get('/sales', [SalesController::class, 'index']);
Route::get('/sales/{id}', [SalesController::class, 'find']);
Route::get('/sales/download/{id}', [SalesController::class, 'download']);
Route::get('/sales/view/{id}', [SalesController::class, 'view']);
Route::get('/tickets', [TicketController::class, 'index']);

Route::prefix('/tickets')->group(
    function () {
        Route::get('/managed_it', [TicketController::class, 'get_managedIt_tickets']);
        Route::get('/it_training', [TicketController::class, 'get_itTraining_tickets']);
        Route::get('/comp_care', [TicketController::class, 'get_computercare_tickets']);
    }
);


Route::prefix('/courses')->group(
    function () {
        Route::get('/', [CoursesController::class, 'index']);
        Route::post('/store', [CoursesController::class, 'store']);
        Route::put('/edit', [CoursesController::class, 'update']);
        Route::delete('/delete/{id}', [CoursesController::class, 'destroy']);
    }
);

Route::prefix('/stat')->group(
    function () {
        Route::get('/tickets', [StatController::class, 'ticketsData']);
        Route::get('/test', [StatController::class, 'testFunc']);
    }
);

Route::prefix('/reports')->group(
    function () {
        Route::get('/is', [ReportsController::class, 'getIncomeStatementReport']);
        Route::get('/gr', [ReportsController::class, 'getGeneralReport']);
        Route::get('/cdr', [ReportsController::class, 'getClientDataReport']);
        Route::get('/er', [ReportsController::class, 'getExpensesDataReport']);
        Route::get('/rr', [ReportsController::class, 'getRevenuesDataReport']);
    }
);

Route::prefix('/purchases')->group(
    function () {
        Route::post('/store', [PurchasesController::class, 'store']);
        Route::get('/', [PurchasesController::class, 'index']);
    }
);


Route::prefix('/costs')->group(
    function () {
        Route::get('/', [CostsController::class, 'index']);
        Route::get('/{id}', [CostsController::class, 'categoryCosts']);
        Route::post('/store', [CostsController::class, 'store']);
        Route::put('/edit', [CostsController::class, 'update']);
        Route::delete('/delete/{id}', [CostsController::class, 'destroy']);
    }
);

Route::prefix('/users')->group(
    function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/edit', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    }
);



Route::prefix('/invoices/')->group(
    function () {
        Route::post('offer', [InvoicesController::class, 'offer']);
        Route::post('balance', [InvoicesController::class, 'balance']);
    }
);

// Route::post('/ticket/store', [TicketController::class, 'store']);
// Route::put('/ticket/{id}', [TicketController::class, 'close_ticket']);
// Route::put('/ticket/check/{id}', [TicketController::class, 'check_ticket']);


Route::get('/comp_care/tickets', [CompCareController::class, 'index']);
// Route::prefix('/ticket/comp_care')->group(
//     function () {
//         Route::post('/store', [CompCareController::class, 'store']);
//     }
// );


Route::prefix('/procedure')->group(
    function () {
        Route::post('/store', [ProceduresController::class, 'store']);
        Route::delete('/{id}', [ProceduresController::class, 'delete_procedure']);
        Route::get('/{id}', [ProceduresController::class, 'get_procedures']);
        Route::get('/', [ProceduresController::class, 'all_procedures']);
    }
);




Route::prefix('/ticket')->group(
    function () {
        Route::post('/managed_it/store', [ManagedItController::class, 'store']);
        Route::post('/it_consult/store', [ItConsultController::class, 'store']);
        Route::post('/it_train/store', [ItTrainController::class, 'store']);
        Route::post('/comp_care/store', [CompCareController::class, 'store']);
        Route::post('/store', [TicketController::class, 'store']);
        Route::put('/{id}', [TicketController::class, 'close_ticket']);
        Route::get('/{id}', [TicketController::class, 'get_ticket']);
        Route::post('/check/', [TicketController::class, 'check_ticket']);
        Route::put('/addhandler', [TicketController::class, 'handle_ticket']);
    }

);

Route::post('/client/store', [ClientController::class, 'store']);
Route::get('/clients', [ClientController::class, 'getClients']);

// Route::post('/ticket/it_train/store', [ItTrainController::class, 'store']);

// Route::post('/ticket/it_consult/store', [ItConsultController::class, 'store']);


// Route::post('/ticket/managed_it/store', [ManagedItController::class, 'store']);
Route::get('/firstUser', [RegisterController::class, 'firstUser']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);
Route::post('/registerUser', [RegisterController::class, 'register']);
Route::put('/changePswd', [RegisterController::class, 'changePswd']);

Route::prefix('/campaigns')->group(
    function () {
        Route::post('/store', [AdminCampaignController::class, 'store']);
        Route::get('/', [AdminCampaignController::class, 'get']);
        Route::get('/{id}', [AdminCampaignController::class, 'getCampaignsCategory']);
        // Route::put('/{id}', [AdminCampaignController::class, 'checkCamp']);
    }


);
Route::get('/campaigners/{id}', [AdminCampaignController::class, 'campaigners']);
Route::put('/campaign/{id}', [AdminCampaignController::class, 'checkCamp']);
Route::get('/campaignScore/{id}', [AdminCampaignController::class, 'getCampScore']);
Route::prefix('/notices')->group(
    function () {
        Route::post('/store', [AdminNoticesController::class, 'store']);
        Route::get('/', [AdminNoticesController::class, 'get']);
        Route::put('/edit', [AdminNoticesController::class, 'update']);
        Route::delete('/delete/{id}', [AdminNoticesController::class, 'destroy']);
        Route::get('/thismonth', [AdminNoticesController::class, 'thisMonthNotices']);
    }


);


Route::prefix('/notes')->group(
    function () {
        Route::post('/store', [NotesController::class, 'store']);
        Route::get('/{id}', [NotesController::class, 'index']);
        Route::put('/edit', [NotesController::class, 'update']);
        Route::delete('/delete/{id}', [NotesController::class, 'destroy']);
    }


);

// Route::post('/notices/store', [AdminNoticesController::class, 'store']);


//Notice email Route

Route::get('/notify', function () {
    Mail::to('sammasikini1@gmail.com')->send(new NoticeMail());
    return new NoticeMail();
});
