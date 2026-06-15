<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CampaignUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;

// Public routes
Route::get('/', function () {
    $campaigns = \App\Models\Campaign::latest()->take(6)->get();
    return view('welcome', compact('campaigns'));
})->name('home');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaign.show')->whereNumber('campaign');
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

// Mock Google Auth
Route::get('/auth/google', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'googlePage'])->name('login.google');
Route::post('/auth/google/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'googleLogin'])->name('login.google.submit');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Verifikasi & Kelola User
    Route::get('/admin/verifikasi/campaigns', [CampaignController::class, 'verifikasiIndex'])->name('admin.verifikasi.campaigns');
    Route::get('/admin/verifikasi/donations', [DonationController::class, 'verifikasiIndex'])->name('admin.verifikasi.donations');
    Route::patch('/campaigns/{campaign}/verify', [CampaignController::class, 'verify'])->name('campaign.verify');
    Route::patch('/donations/{donation}/verify', [DonationController::class, 'verify'])->name('donation.verify');
    Route::get('/admin/users', [DashboardController::class, 'usersIndex'])->name('admin.users');
    Route::patch('/admin/users/{user}/toggle-status', [DashboardController::class, 'toggleUserStatus'])->name('admin.user.toggle');
    Route::get('/admin/reports', [DashboardController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/reports/export-csv', [DashboardController::class, 'exportCsv'])->name('admin.reports.csv');
    Route::get('/admin/reports/print', [DashboardController::class, 'printReport'])->name('admin.reports.print');
    Route::get('/admin/statistics', [DashboardController::class, 'statistics'])->name('admin.statistics');


    // Donatur khusus: Upload Bukti & Sertifikat
    Route::get('/donations/{donation}/upload-proof', [DonationController::class, 'showUploadProof'])->name('donation.upload-proof');
    Route::post('/donations/{donation}/upload-proof', [DonationController::class, 'uploadProof'])->name('donation.upload-proof.submit');
    Route::get('/donations/{donation}/certificate', [DonationController::class, 'certificate'])->name('donation.certificate');

    // Campaign management
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaign.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaign.edit');
    Route::patch('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaign.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaign.destroy');

    // Campaign Updates
    Route::get('/campaigns/{campaign}/updates/create', [CampaignUpdateController::class, 'create'])->name('campaign-update.create');
    Route::post('/campaigns/{campaign}/updates', [CampaignUpdateController::class, 'store'])->name('campaign-update.store');
    Route::get('/updates', [CampaignUpdateController::class, 'index'])->name('campaign-update.index');
    Route::get('/updates/{campaignUpdate}', [CampaignUpdateController::class, 'show'])->name('campaign-update.show');
    Route::get('/updates/{campaignUpdate}/edit', [CampaignUpdateController::class, 'edit'])->name('campaign-update.edit');
    Route::patch('/updates/{campaignUpdate}', [CampaignUpdateController::class, 'update'])->name('campaign-update.update');
    Route::delete('/updates/{campaignUpdate}', [CampaignUpdateController::class, 'destroy'])->name('campaign-update.destroy');

    // Category management
    Route::resource('category', CategoryController::class)->except(['index', 'show']);

    // Donation management
    Route::get('/donations', [DonationController::class, 'index'])->name('donation.index');
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donation.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donation.store');
    Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donation.show');
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donation.edit');
    Route::patch('/donations/{donation}', [DonationController::class, 'update'])->name('donation.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donation.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
