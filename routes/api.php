<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/register',[AuthController::class,'store']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::find($id);

    if ($user) {
        $user->markEmailAsVerified();
        return response()->json(['message' => 'Email verified successfully.']);
    }

    return response()->json(['message' => 'User not found.'], 404);
});


// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     // dd($request);
//     $request->fulfill();
 
//     // return redirect('/home');
// })->middleware('auth')->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');