<?php

namespace App\Http\Controllers;

use App\Models\PaslonCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaslonCategoryController extends Controller
{
    public function index()
    {
        $paslonCategories = PaslonCategory::all();
        return view('paslon_categories.index', compact('paslonCategories'));
    }

    public function tampilUser()
    {
        $paslonCategories = PaslonCategory::all();
        return view('user.voting', compact('paslonCategories'));
    }

    public function create()
    {
        return view('paslon_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'vision_mission' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        PaslonCategory::create([
            'image' => $imagePath,
            'name' => $validated['name'],
            'vision_mission' => $validated['vision_mission'],
        ]);

        return redirect()->route('paslon_categories.index')->with('success', 'Category created successfully.');
    }

    public function show(PaslonCategory $paslonCategory)
    {
        return view('paslon_categories.show', compact('paslonCategory'));
    }

    public function edit(PaslonCategory $paslonCategory)
    {
        return view('paslon_categories.edit', compact('paslonCategory'));
    }

    public function update(Request $request, PaslonCategory $paslonCategory)
    {
        $validated = $request->validate([
            'image' => 'sometimes|image|max:2048',
            'name' => 'required|string|max:255',
            'vision_mission' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($paslonCategory->image);
            $imagePath = $request->file('image')->store('images', 'public');
            $paslonCategory->image = $imagePath;
        }

        $paslonCategory->update([
            'name' => $validated['name'],
            'vision_mission' => $validated['vision_mission'],
        ]);

        return redirect()->route('paslon_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(PaslonCategory $paslonCategory)
    {
        Storage::disk('public')->delete($paslonCategory->image);
        $paslonCategory->delete();
        return redirect()->route('paslon_categories.index')->with('success', 'Category deleted successfully.');
    }
}
