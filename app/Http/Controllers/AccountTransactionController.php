<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountTransactionController extends Controller
{
    public function index()
    {
        $transactions = AccountTransaction::where('business_id', Auth::user()->business_id)
            ->with(['account:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('account.transactions', compact('transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ]);

        $account = Account::findOrFail($request->account_id);
        $this->authorizeAccount($account);

        DB::transaction(function () use ($request, $account) {
            $account->increment('current_balance', (float)$request->amount);
            AccountTransaction::create([
                'business_id' => Auth::user()->business_id,
                'account_id' => $account->id,
                'type' => 'deposit',
                'transactionable_type' => 'credit',
                'amount' => (float)$request->amount,
                'note' => $request->note,
                'transacted_at' => now(),
            ]);
        });

        flash()->success('Deposit added');
        return back();
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ]);
        $account = Account::findOrFail($request->account_id);
        $this->authorizeAccount($account);
        if ($account->current_balance < (float)$request->amount) {
            flash()->error('Insufficient balance');
            return back();
        }

        DB::transaction(function () use ($request, $account) {
            $account->decrement('current_balance', (float)$request->amount);
            AccountTransaction::create([
                'business_id' => Auth::user()->business_id,
                'account_id' => $account->id,
                'type' => 'withdraw',
                'transactionable_type' => 'debate',
                'amount' => (float)$request->amount,
                'note' => $request->note,
                'transacted_at' => now(),
            ]);
        });

        flash()->success('Withdrawal recorded');
        return back();
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required|different:to_account_id|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ]);

        $from = Account::findOrFail($request->from_account_id);
        $to = Account::findOrFail($request->to_account_id);
        $this->authorizeAccount($from);
        $this->authorizeAccount($to);
        if ($from->current_balance < (float)$request->amount) {
            flash()->error('Insufficient balance');
            return back();
        }

        DB::transaction(function () use ($request, $from, $to) {
            $amount = (float)$request->amount;
            $from->decrement('current_balance', $amount);
            $to->increment('current_balance', $amount);

            AccountTransaction::create([
                'business_id' => Auth::user()->business_id,
                'account_id' => $from->id, 
                'transactionable_type' => 'debate',
                'type' => 'transfer_out',
                'amount' => $amount,
                'note' => $request->note,
                'transacted_at' => now(),
            ]);

            AccountTransaction::create([
                'business_id' => Auth::user()->business_id,
                'account_id' => $to->id,
                'type' => 'transfer_in',
                'transactionable_type' => 'credit',
                'amount' => $amount,
                'note' => $request->note,
                'transacted_at' => now(),
            ]);
        });

        flash()->success('Transfer completed');
        return back();
    }

    private function authorizeAccount(Account $account): void
    {
        if ($account->business_id !== Auth::user()->business_id) {
            abort(403);
        }
    }
}


