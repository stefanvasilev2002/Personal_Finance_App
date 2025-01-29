<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->orderBy('name')->get();

        return view('categories.index',
            compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:income,expense',
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'icon' => 'required|string|max:50'
        ]);

        $validated['user_id'] = auth()->id();
        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit',
            compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:income,expense',
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'icon' => 'required|string|max:50'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (str_starts_with($category->name, 'Other ')) {
            return redirect()->route('categories.index')
                ->with('error', 'Default categories cannot be deleted.');
        }

        $defaultCategory = Category::createDefaultCategory($category->type, auth()->id());

        \DB::beginTransaction();

        try {
            $category->transactions()->update([
                'category_id' => $defaultCategory->id
            ]);

            $category->budgets()->update([
                'category_id' => $defaultCategory->id
            ]);

            $category->delete();

            \DB::commit();

            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully. Related items have been moved to the default category.');
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->route('categories.index')
                ->with('error', 'An error occurred while deleting the category.');
        }
    }
}
