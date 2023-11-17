<?php

use App\Http\Controllers\Api\Complaint\ComplaintController;





Route::prefix('complaints')->group(function () {
    Route::post('/store', [ComplaintController::class, 'store']);
    Route::get('/', [ComplaintController::class, 'index']);
});
