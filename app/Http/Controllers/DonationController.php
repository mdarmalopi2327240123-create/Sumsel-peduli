<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Donation::with('campaign', 'user')->orderBy('created_at', 'desc');

        if ($user->role === 'fundraiser') {
            $campaignIds = $user->campaigns()->pluck('id');
            $query->whereIn('campaign_id', $campaignIds);
        } elseif ($user->role === 'donatur') {
            $query->where('user_id', $user->id);
        }

        $donations = $query->paginate(15);

        return view('donation.index', compact('donations'));
    }

    public function create()
    {
        $campaigns = Campaign::where('status', 'aktif')
            ->orWhere('status', 'pending')
            ->get();

        return view('donation.create', compact('campaigns'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Donation::class);

        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:10000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'donor_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['transaction_id'] = 'TXN-' . time() . '-' . rand(1000, 9999);

        $donation = Donation::create($validated);

        // For pending donations, we DO NOT update campaign terkumpul yet.
        // It will be updated when the admin verifies it.

        return redirect()->route('donation.upload-proof', $donation)
            ->with('success', 'Donasi berhasil didaftarkan! Silakan unggah bukti transfer pembayaran Anda.');
    }

    public function show(Donation $donation)
    {
        $donation->load('campaign', 'user');

        return view('donation.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $this->authorize('update', $donation);

        $campaigns = Campaign::all();

        return view('donation.edit', compact('donation', 'campaigns'));
    }

    public function update(Request $request, Donation $donation)
    {
        $this->authorize('update', $donation);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:10000',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'donor_phone' => 'nullable|string|max:20',
            'status' => 'required|in:pending,completed,failed',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        // Update campaign terkumpul if amount changed
        $oldAmount = $donation->amount;
        if ($oldAmount != $validated['amount']) {
            $campaign = $donation->campaign;
            $campaign->terkumpul -= $oldAmount;
            $campaign->terkumpul += $validated['amount'];
            $campaign->save();
        }

        $donation->update($validated);

        return redirect()->route('donation.show', $donation)
            ->with('success', 'Donasi berhasil diperbarui!');
    }

    public function destroy(Donation $donation)
    {
        $this->authorize('delete', $donation);

        $campaign = $donation->campaign;
        if ($donation->status === 'completed') {
            $campaign->terkumpul -= $donation->amount;
            $campaign->save();
        }

        $donation->delete();

        return redirect()->route('campaign.show', $campaign->id)
            ->with('success', 'Donasi berhasil dihapus!');
    }

    public function showUploadProof(Donation $donation)
    {
        if (Auth::id() !== $donation->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('donation.upload-proof', compact('donation'));
    }

    public function uploadProof(Request $request, Donation $donation)
    {
        if (Auth::id() !== $donation->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk mengunggah bukti.');
        }

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('bukti_transfer')) {
            if ($donation->bukti_transfer) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($donation->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')->store('proofs', 'public');
            $donation->update([
                'bukti_transfer' => $path
            ]);
        }

        return redirect()->route('donation.show', $donation)
            ->with('success', 'Bukti transfer berhasil diunggah! Mohon menunggu verifikasi dari Admin.');
    }

    public function verifikasiIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat mengakses halaman ini.');
        }

        $donations = Donation::with('campaign', 'user')->where('status', 'pending')->latest()->paginate(15);

        return view('admin.verifikasi-donasi', compact('donations'));
    }

    public function verify(Request $request, Donation $donation)

    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat memverifikasi donasi.');
        }

        $validated = $request->validate([
            'status' => 'required|in:completed,failed'
        ]);

        $oldStatus = $donation->status;
        $newStatus = $validated['status'];

        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            // Update campaign terkumpul
            $campaign = $donation->campaign;
            $campaign->terkumpul += $donation->amount;
            $campaign->save();

            // Create certificate automatically
            $noCert = 'CERT/' . date('Ymd') . '/' . $donation->id . '/' . rand(100, 999);
            \App\Models\Certificate::create([
                'user_id' => $donation->user_id,
                'donation_id' => $donation->id,
                'nomor_sertifikat' => $noCert,
                'tanggal_terbit' => now()
            ]);

            // Create notification for donatur
            \App\Models\Notification::create([
                'user_id' => $donation->user_id,
                'title' => 'Donasi Berhasil Diverifikasi',
                'message' => "Donasi Anda sebesar Rp " . number_format($donation->amount, 0, ',', '.') . " untuk \"" . $campaign->judul . "\" telah diverifikasi oleh Admin. Sertifikat Anda sudah terbit!",
                'type' => 'success',
                'is_read' => false
            ]);
        } elseif ($oldStatus === 'completed' && $newStatus === 'failed') {
            // Deduct campaign terkumpul
            $campaign = $donation->campaign;
            $campaign->terkumpul -= $donation->amount;
            $campaign->save();

            // Delete certificate if exists
            $donation->certificate()->delete();

            // Create notification for donatur
            \App\Models\Notification::create([
                'user_id' => $donation->user_id,
                'title' => 'Verifikasi Donasi Gagal',
                'message' => "Bukti transfer donasi Anda sebesar Rp " . number_format($donation->amount, 0, ',', '.') . " ditolak oleh Admin.",
                'type' => 'danger',
                'is_read' => false
            ]);
        } elseif ($newStatus === 'failed') {
            // Create notification for donatur
            \App\Models\Notification::create([
                'user_id' => $donation->user_id,
                'title' => 'Verifikasi Donasi Gagal',
                'message' => "Bukti transfer donasi Anda sebesar Rp " . number_format($donation->amount, 0, ',', '.') . " ditolak oleh Admin.",
                'type' => 'danger',
                'is_read' => false
            ]);
        }

        $donation->update([
            'status' => $newStatus
        ]);

        return redirect()->route('donation.show', $donation)
            ->with('success', 'Status donasi berhasil diperbarui!');
    }

    public function certificate(Donation $donation)
    {
        if ($donation->status !== 'completed') {
            abort(404, 'Sertifikat belum diterbitkan untuk donasi ini.');
        }

        if (Auth::id() !== $donation->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke sertifikat ini.');
        }

        $certificate = $donation->certificate;
        if (!$certificate) {
            $noCert = 'CERT/' . date('Ymd') . '/' . $donation->id . '/' . rand(100, 999);
            $certificate = \App\Models\Certificate::create([
                'user_id' => $donation->user_id,
                'donation_id' => $donation->id,
                'nomor_sertifikat' => $noCert,
                'tanggal_terbit' => now()
            ]);
        }

        return view('donation.certificate', compact('donation', 'certificate'));
    }
}
