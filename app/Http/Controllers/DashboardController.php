<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Category;
use App\Models\User;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin') {
            // Stats global
            $totalCampaigns = Campaign::count();
            $activeCampaigns = Campaign::where('status', 'aktif')->count();
            $totalTarget = Campaign::sum('target');
            $totalCollected = Campaign::sum('terkumpul');
            $totalDonations = Donation::where('status', 'completed')->count();
            $totalDonated = Donation::where('status', 'completed')->sum('amount');
            $totalUsers = User::count();

            // Antrean verifikasi
            $pendingCampaigns = Campaign::with('user')->where('status', 'pending')->latest()->get();
            $pendingDonations = Donation::with('campaign', 'user')->where('status', 'pending')->latest()->get();

            // Recent activities
            $recentCampaigns = Campaign::latest()->limit(5)->get();
            $recentDonations = Donation::latest()->limit(5)->get();

            // Charts
            $campaignsByCategory = Category::withCount('campaigns')->get();
            $categoryLabels = $campaignsByCategory->pluck('nama')->toArray();
            $categoryData = $campaignsByCategory->pluck('campaigns_count')->toArray();

            $donationsByMonth = [];
            $monthLabels = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthLabels[] = $month->format('M Y');
                $donationsByMonth[] = Donation::where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount');
            }

            $campaignStatus = Campaign::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $statusLabels = array_keys($campaignStatus);
            $statusData = array_values($campaignStatus);

            $topCampaigns = Campaign::withSum(['donations' => function ($query) {
                    $query->where('status', 'completed');
                }], 'amount')
                ->orderBy('donations_sum_amount', 'desc')
                ->limit(5)
                ->get();
            $topCampaignLabels = $topCampaigns->pluck('judul')->toArray();
            $topCampaignData = $topCampaigns->pluck('donations_sum_amount')->map(fn($v) => $v ?? 0)->toArray();

            return view('dashboard', compact(
                'role', 'totalCampaigns', 'activeCampaigns', 'totalTarget', 'totalCollected',
                'totalDonations', 'totalDonated', 'totalUsers', 'pendingCampaigns', 'pendingDonations',
                'recentCampaigns', 'recentDonations', 'categoryLabels', 'categoryData', 'monthLabels',
                'donationsByMonth', 'statusLabels', 'statusData', 'topCampaignLabels', 'topCampaignData'
            ));
        } elseif ($role === 'fundraiser') {
            // Stats fundraiser
            $campaigns = $user->campaigns()->latest()->get();
            $totalCampaigns = $campaigns->count();
            $activeCampaigns = $campaigns->where('status', 'aktif')->count();
            $totalTarget = $campaigns->sum('target');
            $totalCollected = $campaigns->sum('terkumpul');

            // Total donations made to fundraiser's campaigns
            $campaignIds = $campaigns->pluck('id');
            $donations = Donation::with('campaign', 'user')
                ->whereIn('campaign_id', $campaignIds)
                ->where('status', 'completed')
                ->latest()
                ->get();
            $totalDonations = $donations->count();
            $totalDonated = $donations->sum('amount');

            $recentCampaigns = $campaigns->take(5);
            $recentDonations = $donations->take(5);

            // Charts (Donation per month for fundraiser campaigns)
            $donationsByMonth = [];
            $monthLabels = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthLabels[] = $month->format('M Y');
                $donationsByMonth[] = Donation::whereIn('campaign_id', $campaignIds)
                    ->where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount');
            }

            // Campaigns by status
            $statusCounts = [
                'pending' => $campaigns->where('status', 'pending')->count(),
                'aktif' => $campaigns->where('status', 'aktif')->count(),
                'selesai' => $campaigns->where('status', 'selesai')->count(),
                'ditolak' => $campaigns->where('status', 'ditolak')->count(),
            ];
            $statusLabels = array_keys($statusCounts);
            $statusData = array_values($statusCounts);

            return view('dashboard', compact(
                'role', 'totalCampaigns', 'activeCampaigns', 'totalTarget', 'totalCollected',
                'totalDonations', 'totalDonated', 'recentCampaigns', 'recentDonations',
                'monthLabels', 'donationsByMonth', 'statusLabels', 'statusData'
            ));
        } else {
            // Role: donatur
            $donations = Donation::with('campaign')
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            $totalDonations = $donations->count();
            $totalDonated = $donations->where('status', 'completed')->sum('amount');
            $supportedCampaignsCount = $donations->where('status', 'completed')->pluck('campaign_id')->unique()->count();

            // Certificates
            $certificates = Certificate::whereHas('donation', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('donation.campaign')
                ->latest()
                ->get();

            // Chart (Donatur donation per month)
            $donationsByMonth = [];
            $monthLabels = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthLabels[] = $month->format('M Y');
                $donationsByMonth[] = Donation::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount');
            }

            return view('dashboard', compact(
                'role', 'totalDonations', 'totalDonated', 'supportedCampaignsCount',
                'donations', 'certificates', 'monthLabels', 'donationsByMonth'
            ));
        }
    }

    public function usersIndex(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $search = $request->input('search');
        $role = $request->input('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($role && $role !== 'Semua Role') {
            $query->where('role', strtolower($role));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $totalUsers = User::count();
        $totalDonatur = User::where('role', 'donatur')->count();
        $totalFundraiser = User::where('role', 'fundraiser')->count();
        $totalAdmin = User::where('role', 'admin')->count();

        $recentActivities = [];

        $recentCampaigns = Campaign::with('user')->latest()->take(3)->get();
        foreach ($recentCampaigns as $c) {
            $recentActivities[] = [
                'text' => ($c->user->name ?? 'Fundraiser') . ' membuat campaign baru "' . $c->judul . '"',
                'time' => $c->created_at ? $c->created_at->diffForHumans() : 'baru saja'
            ];
        }

        $recentDonations = Donation::with('campaign')->where('status', 'completed')->latest()->take(3)->get();
        foreach ($recentDonations as $d) {
            $recentActivities[] = [
                'text' => $d->donor_name . ' melakukan donasi Rp ' . number_format($d->amount, 0, ',', '.') . ' untuk "' . ($d->campaign->judul ?? 'Campaign') . '"',
                'time' => $d->created_at ? $d->created_at->diffForHumans() : 'baru saja'
            ];
        }

        // Sort by time desc
        usort($recentActivities, function ($a, $b) {
            return $b['time'] <=> $a['time'];
        });
        $recentActivities = array_slice($recentActivities, 0, 5);

        return view('admin.users', compact(
            'users', 'totalUsers', 'totalDonatur', 'totalFundraiser', 'totalAdmin', 'recentActivities', 'search', 'role'
        ));
    }


    public function toggleUserStatus(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri!');
        }

        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status user ' . $user->name . ' berhasil diubah menjadi ' . $newStatus . '!');
    }

    public function reports()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $totalDonationAmount = Donation::where('status', 'completed')->sum('amount');
        $totalCampaigns = Campaign::count();
        $totalUsers = User::count();
        $pendingVerifications = Campaign::where('status', 'pending')->count() + Donation::where('status', 'pending')->count();

        $monthlyReports = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyReports[] = [
                'month_name' => $month->format('F Y'),
                'month_val' => $month->month,
                'year_val' => $month->year,
                'donations_sum' => Donation::where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount'),
                'campaigns_count' => Campaign::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'users_count' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }

        return view('admin.reports', compact('totalDonationAmount', 'totalCampaigns', 'totalUsers', 'pendingVerifications', 'monthlyReports'));
    }

    public function exportCsv()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-crowdfunding-" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Bulan', 'Total Donasi (Rp)', 'Total Campaign Baru', 'Total User Baru']);

            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $donations = Donation::where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount');
                $campaigns = Campaign::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
                $users = User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();

                fputcsv($file, [$month->format('F Y'), $donations, $campaigns, $users]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printReport()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $totalDonationAmount = Donation::where('status', 'completed')->sum('amount');
        $totalCampaigns = Campaign::count();
        $totalUsers = User::count();
        $pendingVerifications = Campaign::where('status', 'pending')->count() + Donation::where('status', 'pending')->count();

        $monthlyReports = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyReports[] = [
                'month_name' => $month->format('F Y'),
                'donations_sum' => Donation::where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('amount'),
                'campaigns_count' => Campaign::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'users_count' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }

        return view('admin.print-report', compact('totalDonationAmount', 'totalCampaigns', 'totalUsers', 'pendingVerifications', 'monthlyReports'));
    }

    public function statistics()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $donationsByMonth = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthLabels[] = $month->format('M Y');
            $donationsByMonth[] = Donation::where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('amount');
        }

        $categories = Category::withCount('campaigns')->get();
        if ($categories->isEmpty()) {
            $categoryLabels = ['Kesehatan', 'Pendidikan', 'Sosial', 'Bencana Alam', 'Lingkungan'];
            $categoryData = [
                Campaign::where('kategori', 'Kesehatan')->count(),
                Campaign::where('kategori', 'Pendidikan')->count(),
                Campaign::where('kategori', 'Sosial')->count(),
                Campaign::where('kategori', 'Bencana Alam')->count(),
                Campaign::where('kategori', 'Lingkungan')->count()
            ];
        } else {
            $categoryLabels = $categories->pluck('nama')->toArray();
            $categoryData = $categories->pluck('campaigns_count')->toArray();
        }

        $usersByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $usersByMonth[] = User::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return view('admin.statistics', compact('monthLabels', 'donationsByMonth', 'categoryLabels', 'categoryData', 'usersByMonth'));
    }
}

