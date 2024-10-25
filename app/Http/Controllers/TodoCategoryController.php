<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoCategory;

class TodoCategoryController extends Controller
{
    public function index()
    {
        $categories = TodoCategory::all();
        return view('todo_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('todo_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
        ]);

        TodoCategory::create($request->all());
        return redirect()->route('todo_categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = TodoCategory::find($id);
        if (is_null($category)) {
            return redirect()->route('todo_categories.index')->with('error', 'Category not found.');
        }
        return view('todo_categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = TodoCategory::find($id);
        if (is_null($category)) {
            return redirect()->route('todo_categories.index')->with('error', 'Category not found.');
        }
        return view('todo_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
        ]);

        $category = TodoCategory::find($id);
        if (is_null($category)) {
            return redirect()->route('todo_categories.index')->with('error', 'Category not found.');
        }
        $category->update($request->all());
        return redirect()->route('todo_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = TodoCategory::find($id);
        if (is_null($category)) {
            return redirect()->route('todo_categories.index')->with('error', 'Category not found.');
        }
        $category->delete();
        return redirect()->route('todo_categories.index')->with('success', 'Category deleted successfully.');
    }
}
