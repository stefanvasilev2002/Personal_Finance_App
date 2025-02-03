<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BudgetController extends Controller
{
    use AuthorizesRequests;
    private function renewBudgets()
    {
        $expiredBudgets = auth()->user()->budgets()
            ->get()
            ->filter(function($budget) {
                return $budget->shouldRenew();
            });

        foreach ($expiredBudgets as $budget) {
            $budget->renewBudget();
        }
    }
    public function index()
    {
        $this->renewBudgets();
        $budgets = auth()->user()->budgets()
            ->with(['category' => function($query) {
                $query->where('type', '!=', 'income');
            }])
            ->whereHas('category', function($query) {
                $query->where('type', '!=', 'income');
            })
            ->get()
            ->map(function ($budget) {
                $budget->spent_amount = $budget->getCurrentSpending();
                $budget->remaining_days = $budget->getRemainingDays();
                $budget->daily_budget = $budget->getDailyBudget();
                $budget->spending_percentage = $budget->getSpendingPercentage();
                $budget->status = $budget->getStatus();
                $budget->is_active = $budget->isActive();
                return $budget;
            })
            ->sortByDesc(function($budget) {
                return $budget->end_date ?? $budget->getDefaultEndDate();
            })
            ->groupBy('category.type');

        $totalBudget = $budgets->flatten()
            ->filter(function ($budget) {
                return $budget->is_active;
            })
            ->sum('amount');

        $totalSpent = $budgets->flatten()
            ->filter(function ($budget) {
                return $budget->is_active;
            })
            ->sum('spent_amount');

        $remaining = $totalBudget - $totalSpent;

        $categories = Category::where('user_id', auth()->id())
            ->where('type', '!=', 'income')
            ->get()
            ->groupBy('type');

        return view('budgets.index', compact(
            'budgets',
            'categories',
            'totalSpent',
            'remaining',
            'totalBudget'
        ));
    }

    public function create()
    {
        $categories = auth()->user()->categories()
            ->where('type', '!=', 'income')
            ->get();

        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        if ($category->type === 'income') {
            return back()->withErrors(['category_id' => 'Income categories cannot have budgets']);
        }

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    $category = Category::find($value);
                    if ($category && $category->type === 'income') {
                        $fail('Income categories cannot have budgets.');
                    }
                },
            ],
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $budget = new Budget($validated);
        $budget->start_date = $validated['start_date'];
        $budget->period = $validated['period'];

        $validated['end_date'] = $validated['end_date'] ?? $budget->getDefaultEndDate();

        auth()->user()->budgets()->create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);

        if ($budget->category->type === 'income') {
            return redirect()->route('budgets.index')
                ->with('error', 'Income categories cannot have budgets');
        }

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

        if ($budget->category->type === 'income') {
            return redirect()->route('budgets.index')
                ->with('error', 'Income categories cannot have budgets');
        }

        $categories = auth()->user()->categories()
            ->where('type', '!=', 'income')
            ->get();

        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        if ($budget->category->type === 'income') {
            return redirect()->route('budgets.index')
                ->with('error', 'Income categories cannot have budgets');
        }

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    $category = Category::find($value);
                    if ($category && $category->type === 'income') {
                        $fail('Income categories cannot have budgets.');
                    }
                },
            ],
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $budget->start_date = $validated['start_date'];
        $budget->period = $validated['period'];

        $validated['end_date'] = $validated['end_date'] ?? $budget->getDefaultEndDate();

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);

        if ($budget->category->type === 'income') {
            return redirect()->route('budgets.index')
                ->with('error', 'Income categories cannot have budgets');
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }
}
