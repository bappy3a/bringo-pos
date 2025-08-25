<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::forUserBusiness()->orderBy('name')->paginate(10);
        return view('expense.category.index', compact('categories'));
    }

    public function create()
    {
        return view('expense.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        ExpenseCategory::create([
            'business_id' => Auth::user()->business_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => true,
        ]);

        flash()->success('Expense category created successfully!');
        return redirect()->route('expense-categories.index');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->business_id !== Auth::user()->business_id) {
            abort(403);
        }
        return view('expense.category.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $expenseCategory->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        flash()->success('Expense category updated successfully!');
        return redirect()->route('expense-categories.index');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->business_id !== Auth::user()->business_id) {
            abort(403);
        }

        if ($expenseCategory->expenses()->exists()) {
            flash()->error('Cannot delete category with expenses');
            return back();
        }

        $expenseCategory->delete();
        flash()->success('Expense category deleted successfully!');
        return redirect()->route('expense-categories.index');
    }
}
