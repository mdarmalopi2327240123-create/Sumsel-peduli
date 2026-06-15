<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Campaign::with('user', 'donations')->orderBy('created_at', 'desc');

        if ($user) {
            if ($user->role === 'fundraiser') {
                $query->where('user_id', $user->id);
            } elseif ($user->role === 'donatur') {
                $query->where('status', 'aktif');
            }
            // Admin sees all campaigns of all statuses
        } else {
            // Guest sees only active campaigns
            $query->where('status', 'aktif');
        }

        $campaigns = $query->paginate(12);

        return view('campaign.index', compact('campaigns'));
    }

    public function create()
    {
        $this->authorize('create', Campaign::class);
        return view('campaign.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|string',
            'target' => 'required|numeric|min:100000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = Auth::user()->role === 'admin' ? 'aktif' : 'pending';
        $validated['terkumpul'] = 0;

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('campaigns', 'public');
            $validated['gambar'] = $path;
        }

        Campaign::create($validated);

        $msg = Auth::user()->role === 'admin' 
            ? 'Kampanye berhasil dibuat dan langsung aktif!' 
            : 'Kampanye berhasil dibuat! Menunggu verifikasi admin sebelum tampil di publik.';

        return redirect()->route('campaign.index')
            ->with('success', $msg);
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('user', 'donations');
        $donations = $campaign->donations()->latest()->paginate(10);

        return view('campaign.show', compact('campaign', 'donations'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view('campaign.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'kategori' => 'required|string',
            'target' => 'required|numeric|min:100000',
            'status' => 'required|in:pending,aktif,selesai',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($campaign->gambar) {
                Storage::disk('public')->delete($campaign->gambar);
            }
            $path = $request->file('gambar')->store('campaigns', 'public');
            $validated['gambar'] = $path;
        }

        $campaign->update($validated);

        return redirect()->route('campaign.show', $campaign)
            ->with('success', 'Kampanye berhasil diperbarui!');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        if ($campaign->gambar) {
            Storage::disk('public')->delete($campaign->gambar);
        }

        $campaign->delete();

        return redirect()->route('campaign.index')
            ->with('success', 'Kampanye berhasil dihapus!');
    }

    public function verifikasiIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat mengakses halaman ini.');
        }

        $campaigns = Campaign::with('user')->where('status', 'pending')->latest()->paginate(15);

        return view('admin.verifikasi-campaign', compact('campaigns'));
    }

    public function verify(Request $request, Campaign $campaign)

    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat memverifikasi campaign.');
        }

        $validated = $request->validate([
            'status' => 'required|in:aktif,ditolak'
        ]);

        $campaign->update([
            'status' => $validated['status']
        ]);

        // Create notification for fundraiser
        \App\Models\Notification::create([
            'user_id' => $campaign->user_id,
            'title' => 'Status Kampanye Diperbarui',
            'message' => "Kampanye \"" . $campaign->judul . "\" Anda telah " . ($validated['status'] === 'aktif' ? 'disetujui dan aktif.' : 'ditolak oleh admin.'),
            'type' => $validated['status'] === 'aktif' ? 'success' : 'danger',
            'is_read' => false
        ]);

        return redirect()->route('campaign.show', $campaign)
            ->with('success', 'Status kampanye berhasil diperbarui!');
    }
}
