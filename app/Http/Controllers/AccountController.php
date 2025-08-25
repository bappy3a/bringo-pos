<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::forUserBusiness()->orderBy('is_default', 'desc')->orderBy('name')->paginate(10);
        return view('account.index', compact('accounts'));
    }

    public function create()
    {
        return view('account.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'type' => 'required|in:cash,bank,mobile,other',
            'opening_balance' => 'nullable|numeric|min:0',
            'is_default' => 'nullable|boolean',
        ]);

        $account = Account::create([
            'business_id' => Auth::user()->business_id,
            'name' => $request->name,
            'type' => $request->type,
            'opening_balance' => (float)($request->opening_balance ?? 0),
            'current_balance' => (float)($request->opening_balance ?? 0),
            'is_default' => (bool)$request->boolean('is_default'),
            'is_active' => true,
        ]);

        if ($account->is_default) {
            Account::forUserBusiness()->where('id', '!=', $account->id)->update(['is_default' => false]);
        }

        flash()->success('Account created');
        return redirect()->route('accounts.index');
    }

    public function edit(Account $account)
    {
        $this->authorizeAccount($account);
        return view('account.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorizeAccount($account);
        $request->validate([
            'name' => 'required|string|max:191',
            'type' => 'required|in:cash,bank,mobile,other',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $account->update([
            'name' => $request->name,
            'type' => $request->type,
            'is_default' => (bool)$request->boolean('is_default'),
            'is_active' => (bool)$request->boolean('is_active', true),
        ]);

        if ($account->is_default) {
            Account::forUserBusiness()->where('id', '!=', $account->id)->update(['is_default' => false]);
        }

        flash()->success('Account updated');
        return redirect()->route('accounts.index');
    }

    public function destroy(Account $account)
    {
        $this->authorizeAccount($account);
        if ($account->transactions()->exists()) {
            flash()->error('Cannot delete account with transactions');
            return back();
        }
        $account->delete();
        flash()->success('Account deleted');
        return redirect()->route('accounts.index');
    }

    private function authorizeAccount(Account $account): void
    {
        if ($account->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}


