<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    public function index()
    {
        try {
            $deposits = Transaction::where('user_id', auth()->id())
                ->where('type', TransactionType::DEPOSIT)
                ->get();
            return view('deposit.index',compact('deposits'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function create()
    {
        return view('deposit.create');
    }

    public function store(TransactionRequest $request){
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $data['user_id'] = auth()->id();
                $data['date'] = now()->format('Y-m-d');
                $data['type'] = TransactionType::DEPOSIT;
                $data['fee'] = 0;

                Transaction::create($data);

                auth()->user()->update([
                    'balance' => auth()->user()->balance + $data['amount']
                ]);

                return redirect()->route('deposit.index')->with('success', 'Deposit created successfully');
            });
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
