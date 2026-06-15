<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::withCount('campaigns')->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string',
            'warna' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        Category::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon,
            'warna' => $request->warna ?? '#198754',
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(Category $category)
    {
        $campaigns = $category->campaigns()->paginate(12);
        return view('category.show', compact('category', 'campaigns'));
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string',
            'warna' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon,
            'warna' => $request->warna ?? $category->warna,
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->campaigns()->count() > 0) {
            return redirect()->route('category.index')->with('error', 'Tidak bisa menghapus kategori yang masih memiliki kampanye!');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
