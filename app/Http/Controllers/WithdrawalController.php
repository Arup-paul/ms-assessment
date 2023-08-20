<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Enums\TransactionType;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        try {
            $withdraws = Transaction::where('user_id', auth()->id())
                ->where('type', TransactionType::WITHDRAWAL)
                ->get();
            return view('withdraw.index',compact('withdraws'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create()
    {
        return view('withdraw.create');
    }

    public function store(TransactionRequest $request){

        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $authUser = auth()->user();



                $withdrawalFee = 0;
                $withdrawalAmount = $data['amount'];
                if($authUser->account_type ==  AccountType::INDIVIDUAL) {
                    $firstFreeAmount = 1000; // $1,000 is free from fee
                    $freeMonthlyWithdrawalLimit = 5000; // First $5,000 per month is free from fee
                    $individualFeeRate = 0.015;

                    if ($withdrawalAmount > $firstFreeAmount) {
                        $withdrawalFee = (($withdrawalAmount - $firstFreeAmount) * $individualFeeRate) / 100;
                    }

                    // 5k free withdrawal limit per month
                      $totalCurrentMonthWithDraw =   Transaction::where('user_id', $authUser->id)
                            ->where('type', TransactionType::WITHDRAWAL)
                            ->whereMonth('date', Carbon::now()->month)
                            ->sum('amount');

                    $remainingFreeAmount = 0;
                    if($totalCurrentMonthWithDraw > $freeMonthlyWithdrawalLimit) {
                        $remainingFreeAmount = 0;
                    }else{
                        $remainingFreeAmount = $freeMonthlyWithdrawalLimit - $totalCurrentMonthWithDraw;
                    }

                    if ($withdrawalAmount > $remainingFreeAmount) {
                        $withdrawalAmount = $withdrawalAmount - ($remainingFreeAmount + $firstFreeAmount);

                        $withdrawalFee = ($withdrawalAmount * $individualFeeRate) / 100;
                    } else{
                        $withdrawalFee = 0;
                    }

                    // Apply fee logic for Friday withdrawals
                    if (Carbon::now()->isFriday()) {
                        $withdrawalFee = 0;
                    }

                }elseif ($authUser->account_type ==  AccountType::BUSINESS) {
                    $businessFeeRate = 0.025;

                    if ($withdrawalAmount > 50000) {
                        $businessFeeRate = 0.015;
                    }

                    $withdrawalFee = ($withdrawalAmount * $businessFeeRate) / 100;
                }


                $totalAmount = $withdrawalAmount + $withdrawalFee;
                 if($authUser->balance < $totalAmount) {
                    return redirect()->back()->with('error', 'Insufficient balance');
                 }


                $data['user_id'] = auth()->id();
                $data['type'] = TransactionType::WITHDRAWAL;
                $data['fee'] = $withdrawalFee;
                $data['date'] = now()->format('Y-m-d');

                Transaction::create($data);


                auth()->user()->update([
                    'balance' => auth()->user()->balance -  $totalAmount
                ]);

                return redirect()->route('withdraw.index')->with('success', 'Withdrawal created successfully');
            });
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
