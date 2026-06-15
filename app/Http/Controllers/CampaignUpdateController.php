<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignUpdateController extends Controller
{

    public function index()
    {
        $updates = CampaignUpdate::with('campaign', 'user')->latest()->paginate(10);
        return view('campaign-update.index', compact('updates'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaign-update.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string|min:10',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'campaign_id' => $campaign->id,
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'konten' => $request->konten,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('campaign-updates', 'public');
            $data['gambar'] = $path;
        }

        CampaignUpdate::create($data);

        return redirect()->route('campaign.show', $campaign)->with('success', 'Update kampanye berhasil ditambahkan!');
    }

    public function show(CampaignUpdate $campaignUpdate)
    {
        return view('campaign-update.show', compact('campaignUpdate'));
    }

    public function edit(CampaignUpdate $campaignUpdate)
    {
        $this->authorize('update', $campaignUpdate->campaign);
        return view('campaign-update.edit', compact('campaignUpdate'));
    }

    public function update(Request $request, CampaignUpdate $campaignUpdate)
    {
        $this->authorize('update', $campaignUpdate->campaign);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string|min:10',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
        ];

        if ($request->hasFile('gambar')) {
            if ($campaignUpdate->gambar) {
                Storage::disk('public')->delete($campaignUpdate->gambar);
            }
            $path = $request->file('gambar')->store('campaign-updates', 'public');
            $data['gambar'] = $path;
        }

        $campaignUpdate->update($data);

        return redirect()->route('campaign.show', $campaignUpdate->campaign)->with('success', 'Update kampanye berhasil diperbarui!');
    }

    public function destroy(CampaignUpdate $campaignUpdate)
    {
        $this->authorize('update', $campaignUpdate->campaign);

        if ($campaignUpdate->gambar) {
            Storage::disk('public')->delete($campaignUpdate->gambar);
        }

        $campaign = $campaignUpdate->campaign;
        $campaignUpdate->delete();

        return redirect()->route('campaign.show', $campaign)->with('success', 'Update kampanye berhasil dihapus!');
    }
}
