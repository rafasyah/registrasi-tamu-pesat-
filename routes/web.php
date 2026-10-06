<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDepartmentController;
use App\Http\Controllers\AdminHostController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GuestRegistrationController;
use App\Http\Controllers\TeacherScheduleController;
use App\Http\Controllers\TicketPassController;
use Illuminate\Support\Facades\Route;

// Public Guest Routes
Route::get('/', [GuestRegistrationController::class, 'index'])->name('home');
Route::get('/register', [GuestRegistrationController::class, 'index'])->name('guest.register');
Route::post('/register', [GuestRegistrationController::class, 'store'])->name('guest.store');
Route::get('/api/departments/{department}/hosts', [GuestRegistrationController::class, 'getHostsByDepartment'])->name('api.hosts.by_department');

// Ticket Pass & Lookup
Route::get('/tiket/{code}', [TicketPassController::class, 'show'])->name('ticket.show');
Route::get('/cek-tiket', [TicketPassController::class, 'lookup'])->name('ticket.lookup');
Route::post('/cek-tiket', [TicketPassController::class, 'search'])->name('ticket.search');

// Check-out & Feedback
Route::get('/check-out', [CheckoutController::class, 'index'])->name('guest.checkout');
Route::post('/check-out', [CheckoutController::class, 'processCheckout'])->name('guest.checkout.process');

// Authentication Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Teacher Authentication (separate login)
Route::get('/teacher/login', [AuthController::class, 'teacherLoginForm'])->name('teacher.login');
Route::post('/teacher/login', [AuthController::class, 'teacherLogin'])->name('teacher.login.post');

// Protected Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/visits/{visit}/status', [AdminDashboardController::class, 'updateStatus'])->name('visits.update_status');
    Route::get('/visits/{visit}/badge', [AdminDashboardController::class, 'printBadge'])->name('visits.print_badge');

    // Hosts Management
    Route::resource('hosts', AdminHostController::class)->except(['create', 'edit', 'show']);

    // Departments Management
    Route::resource('departments', AdminDepartmentController::class)->except(['create', 'edit', 'show']);

    // Reports & Export
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [AdminReportController::class, 'exportCsv'])->name('reports.export');
});

// Teacher Dashboard & Schedules
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules', [TeacherScheduleController::class, 'index'])->name('schedules.list');
    Route::get('/schedules/create', [TeacherScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [TeacherScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}', [TeacherScheduleController::class, 'show'])->name('schedules.show');
    Route::get('/schedules/{schedule}/edit', [TeacherScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{schedule}', [TeacherScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [TeacherScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/{schedule}/guest-visits', [TeacherScheduleController::class, 'attachGuestVisit'])->name('schedules.guest_visits.attach');
    Route::delete('/schedules/{schedule}/guest-visits/{guestVisit}', [TeacherScheduleController::class, 'detachGuestVisit'])->name('schedules.guest_visits.detach');

    // Notifications
    Route::get('/notifications', [TeacherScheduleController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [TeacherScheduleController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [TeacherScheduleController::class, 'markAllNotificationsRead'])->name('notifications.read_all');
});

// Redirect after login based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'teacher') {
        return redirect()->route('teacher.schedules.index');
    }

    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');
