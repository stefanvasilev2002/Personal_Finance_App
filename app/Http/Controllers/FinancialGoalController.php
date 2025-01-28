<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FinancialGoalController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $goals = auth()->user()->financialGoals()
            ->orderBy('target_date')
            ->get();

        return view('financial-goals.index',
            compact('goals'));
    }

    public function create()
    {
        return view('financial-goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        auth()->user()->financialGoals()->create($validated);

        return redirect()->route('financial-goals.index')
            ->with('success', 'Financial goal created successfully.');
    }

    public function show(FinancialGoal $financialGoal)
    {
        $this->authorize('view', $financialGoal);

        return view('financial-goals.show',
            compact('financialGoal'));
    }

    public function edit(FinancialGoal $financialGoal)
    {
        $this->authorize('update', $financialGoal);

        return view('financial-goals.edit',
            compact('financialGoal'));
    }

    public function update(Request $request, FinancialGoal $financialGoal)
    {
        $this->authorize('update', $financialGoal);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string'
        ]);

        $financialGoal->update($validated);

        return redirect()->route('financial-goals.index')
            ->with('success', 'Financial goal updated successfully.');
    }

    public function destroy(FinancialGoal $financialGoal)
    {
        $this->authorize('delete', $financialGoal);
        $financialGoal->delete();

        return redirect()->route('financial-goals.index')
            ->with('success', 'Financial goal deleted successfully.');
    }

    public function updateProgress(Request $request, FinancialGoal $financialGoal)
    {
        $this->authorize('update', $financialGoal);

        $validated = $request->validate([
            'current_amount' => 'required|numeric|min:0'
        ]);

        $financialGoal->update($validated);

        return redirect()->back()
            ->with('success', 'Progress updated successfully.');
    }
}
