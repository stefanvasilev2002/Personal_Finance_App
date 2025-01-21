<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BudgetController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $budgets = auth()->user()->budgets()
            ->with('category')
            ->get()
            ->groupBy('category.type');

        $totalBudget = $budgets->flatten()->sum('amount');

        $totalSpent = $budgets->flatten()->sum(function ($budget) {
            return $budget->getCurrentSpending();
        });

        $remaining = $totalBudget - $totalSpent;

        $categories = Category::where('user_id', auth()->id())
            ->get()
            ->groupBy('type');

        return view('budgets.index',
            compact(
                'budgets',
                'categories',
                'totalSpent',
                'remaining',
                'totalBudget'));
    }

    public function create()
    {
        $categories = auth()->user()->categories;
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        auth()->user()->budgets()->create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);

        $spending = $budget->category
            ->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$budget->start_date, $budget->end_date ?? now()])
            ->sum('amount');

        return view('budgets.show', compact('budget', 'spending'));
    }

    public function edit(Budget $budget)
    {
        $this->authorize('update', $budget);
        $categories = auth()->user()->categories;

        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }
}
