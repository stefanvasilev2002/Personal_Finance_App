<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $accounts = auth()->user()->accounts;
        return view('accounts.index',
            compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:checking,savings,credit',
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3'
        ]);

        auth()->user()->accounts()->create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        $transactions = $account
            ->transactions()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('accounts.show',
            compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        return view('accounts.edit',
            compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:checking,savings,credit',
            'currency' => 'required|string|size:3'
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
