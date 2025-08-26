<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Account;
use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::forUserBusiness()
            ->with(['category', 'account', 'user:id,first_name,last_name'])
            ->orderBy('expense_date', 'asc')
            ->paginate(10);
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::forUserBusiness()->where('is_active', true)->orderBy('name')->get();
        $accounts = Account::forUserBusiness()->where('is_active', true)->orderByDesc('is_default')->orderBy('name')->get();
        return view('expense.create', compact('categories', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'nullable|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'reference_no' => 'nullable|string|max:191',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $expense = Expense::create([
                'business_id' => Auth::user()->business_id,
                'user_id' => Auth::id(),
                'expense_category_id' => $request->expense_category_id,
                'account_id' => $request->account_id,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'expense_date' => $request->expense_date,
                'reference_no' => $request->reference_no,
            ]);

            // Handle receipt upload
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('expenses/receipts', 'public');
                $expense->update(['receipt' => $receiptPath]);
            }

            // If account selected, create account transaction and update balance
            if ($request->filled('account_id')) {
                $account = Account::forUserBusiness()->find($request->account_id);
                if ($account) {
                    $account->decrement('current_balance', (float)$request->amount);
                    AccountTransaction::create([
                        'business_id' => Auth::user()->business_id,
                        'account_id' => $account->id,
                        'type' => 'withdraw',
                        'amount' => (float)$request->amount,
                        'transactionable_type' => Expense::class,
                        'transactionable_id' => $expense->id,
                        'note' => 'Expense: ' . $request->title,
                        'transacted_at' => now(),
                    ]);
                }
            }

            DB::commit();
            flash()->success('Expense created successfully!');
            return redirect()->route('expenses.index');

        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to create expense. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function show(Expense $expense)
    {
        if ($expense->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        $expense->load(['category', 'account', 'user']);
        return view('expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        if ($expense->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        $categories = ExpenseCategory::forUserBusiness()->where('is_active', true)->orderBy('name')->get();
        $accounts = Account::forUserBusiness()->where('is_active', true)->orderByDesc('is_default')->orderBy('name')->get();
        return view('expense.edit', compact('expense', 'categories', 'accounts'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:191',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'account_id' => 'nullable|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'reference_no' => 'nullable|string|max:191',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Handle receipt upload
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('expenses/receipts', 'public');
                $expense->receipt = $receiptPath;
            }

            $expense->update([
                'expense_category_id' => $request->expense_category_id,
                'account_id' => $request->account_id,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'expense_date' => $request->expense_date,
                'reference_no' => $request->reference_no,
            ]);

            DB::commit();
            flash()->success('Expense updated successfully!');
            return redirect()->route('expenses.index');

        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to update expense. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Expense $expense)
    {
        if ($expense->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // If expense was paid from account, reverse the transaction
            if ($expense->account_id) {
                $account = $expense->account;
                $account->increment('current_balance', $expense->amount);
                
                // Delete the account transaction
                AccountTransaction::where('transactionable_type', Expense::class)
                    ->where('transactionable_id', $expense->id)
                    ->delete();
            }

            $expense->delete();
            DB::commit();

            flash()->success('Expense deleted successfully!');
            return redirect()->route('expenses.index');

        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Failed to delete expense. Please try again.');
            return redirect()->back();
        }
    }
}
