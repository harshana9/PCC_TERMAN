<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Common Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

//Supplies
use App\Http\Controllers\StockFlow\Supplies\PurchaseController;
use App\Http\Controllers\StockFlow\Supplies\PurchasePDFController;
use App\Http\Controllers\StockFlow\Supplies\IssueToPccController;
use App\Http\Controllers\StockFlow\Supplies\IssueToPccPDFController;

//PCC
use App\Http\Controllers\StockFlow\PCC\IssueToVendorNewController;
use App\Http\Controllers\StockFlow\PCC\IssueToVendorNewPDFController;
use App\Http\Controllers\StockFlow\PCC\IssueToVendorUsedController;
use App\Http\Controllers\StockFlow\PCC\IssueToVendorUsedPDFController;
use App\Http\Controllers\StockFlow\PCC\RecallFromVendorController;
use App\Http\Controllers\StockFlow\PCC\RecallFromVendorPDFController;

//Vendor
use App\Http\Controllers\StockFlow\Vendor\DeployController;
use App\Http\Controllers\StockFlow\Vendor\ReplaceController;
use App\Http\Controllers\StockFlow\Vendor\ReplacePDFController;
use App\Http\Controllers\StockFlow\Vendor\DeployPDFController;

//Reports
use App\Http\Controllers\Reports\StockBalanceSheetController;
use App\Http\Controllers\Reports\DeployedTerminalsReportController;

//Terminal Traker
use App\Http\Controllers\StockFlow\TerminalTrakerController;

//Public Routes
Route::post('login', [AuthController::class, 'login']);

//Protected Routes
Route::group(['middleware'=>['auth:sanctum']], function()
{
    //Authentication
    Route::post('logout', [AuthController::class, 'logout']);

    //User
    Route::post('register', [UserController::class, 'register'])->middleware('restrictRole:admin');
    Route::get('user/view', [UserController::class, 'retrive'])->middleware('restrictRole:admin');
    Route::get('user/view/{id}', [UserController::class, 'find']);
    Route::put('user/update/{id}', [UserController::class, 'update']);//Controller allows only own data update
    Route::delete('user/delete/{id}', [UserController::class, 'delete'])->middleware('restrictRole:admin');

    //Vendor
    Route::post('vendor/create', [VendorController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('vendor/view', [VendorController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('vendor/view/{id}', [VendorController::class, 'find'])->middleware('restrictRole:moderator');
    Route::put('vendor/update/{id}', [VendorController::class, 'update'])->middleware('restrictRole:moderator');
    Route::delete('vendor/delete/{id}', [VendorController::class, 'delete'])->middleware('restrictRole:moderator');

    //Product
    Route::post('product/create', [ProductController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('product/view', [ProductController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('product/view/{id}', [ProductController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('product/view/byvendor/{id}', [ProductController::class, 'retrive_by_vendor'])->middleware('restrictRole:moderator');
    Route::put('product/update/{id}', [ProductController::class, 'update'])->middleware('restrictRole:moderator');
    Route::delete('product/delete/{id}', [ProductController::class, 'delete'])->middleware('restrictRole:moderator');

    //Supplies
    //Perchas Notes
    Route::post('supplies/purchase', [PurchaseController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('supplies/purchase/search/{page_size}/{keyword}', [PurchaseController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('supplies/purchase/search/{page_size}', [PurchaseController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('supplies/purchase/view/{id}', [PurchaseController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('supplies/purchase/pdf/{id}', [PurchasePDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Issue to PCC Notes
    Route::post('supplies/issuetopcc', [IssueToPccController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('supplies/issuetopcc/search/{page_size}/{keyword}', [IssueToPccController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('supplies/issuetopcc/search/{page_size}', [IssueToPccController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('supplies/issuetopcc/view/{id}', [IssueToPccController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('supplies/issuetopcc/pdf/{id}', [IssueToPccPDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');
    
    //PCC
    //Issue to Vendor (New Terminals)
    Route::post('pcc/issuetovendor/newterminal', [IssueToVendorNewController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/newterminal/search/{page_size}/{keyword}', [IssueToVendorNewController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/newterminal/search/{page_size}', [IssueToVendorNewController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/newterminal/view/{id}', [IssueToVendorNewController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/newterminal/pdf/{id}', [IssueToVendorNewPDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Issue to Vendor (Used Terminals)
    Route::post('pcc/issuetovendor/usedterminal', [IssueToVendorUsedController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/usedterminal/search/{page_size}/{keyword}', [IssueToVendorUsedController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/usedterminal/search/{page_size}', [IssueToVendorUsedController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/usedterminal/view/{id}', [IssueToVendorUsedController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('pcc/issuetovendor/usedterminal/pdf/{id}', [IssueToVendorUsedPDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Recall from Vendor
    Route::post('pcc/recall', [RecallFromVendorController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('pcc/recall/search/{page_size}/{keyword}', [RecallFromVendorController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('pcc/recall/search/{page_size}', [RecallFromVendorController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('pcc/recall/view/{id}', [RecallFromVendorController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('pcc/recall/pdf/{id}', [RecallFromVendorPDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Vendor
    //Deployment
    Route::post('vendor/deploy', [DeployController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('vendor/deploy/search/{page_size}/{keyword}', [DeployController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('vendor/deploy/search/{page_size}', [DeployController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('vendor/deploy/view/{id}', [DeployController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('vendor/deploy/pdf/{id}', [DeployPDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Replacement
    Route::post('vendor/replace', [ReplaceController::class, 'create'])->middleware('restrictRole:moderator');
    Route::get('vendor/replace/search/{page_size}/{keyword}', [ReplaceController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('vendor/replace/search/{page_size}', [ReplaceController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('vendor/replace/view/{id}', [ReplaceController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('vendor/replace/pdf/{id}', [ReplacePDFController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Terminal Traker
    Route::get('terminal/search/{page_size}/{keyword}', [TerminalTrakerController::class, 'retrive'])->middleware('restrictRole:moderator');
    Route::get('terminal/search/{page_size}', [TerminalTrakerController::class, 'retrive_all'])->middleware('restrictRole:moderator');
    Route::get('terminal/view/{id}', [TerminalTrakerController::class, 'find'])->middleware('restrictRole:moderator');
    Route::get('terminal/history/tid/{tid}', [TerminalTrakerController::class, 'tid_history'])->middleware('restrictRole:moderator');
    Route::get('terminal/history/sn/{sn}', [TerminalTrakerController::class, 'sn_history'])->middleware('restrictRole:moderator');
    Route::get('terminal/deployed_cities', [TerminalTrakerController::class, 'city_list'])->middleware('restrictRole:moderator');

    //Reports
    Route::get('reports/stockbalance/pdf', [StockBalanceSheetController::class, 'generatePDF'])->middleware('restrictRole:moderator'); 
    Route::post('reports/deployed/pdf', [DeployedTerminalsReportController::class, 'generatePDF'])->middleware('restrictRole:moderator');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'terminal_status'])->middleware('restrictRole:moderator');

});
