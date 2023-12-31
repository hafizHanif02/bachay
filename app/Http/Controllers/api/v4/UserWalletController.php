<?php

namespace App\Http\Controllers\api\v4;

use App\Http\Controllers\Controller;
use App\Model\AddFundBonusCategories;
use Illuminate\Http\Request;
use App\Model\WalletTransaction;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

class UserWalletController extends Controller
{
    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $wallet_status = Helpers::get_business_settings('wallet_status');

        if($wallet_status == 1)
        {
            $user = $request->user();
            $total_wallet_balance = $user->wallet_balance;
            $wallet_transactio_list = WalletTransaction::where('user_id',$user->id)
                                                    ->latest()
                                                    ->paginate($request['limit'], ['*'], 'page', $request['offset']);

            return response()->json([
                'limit'=>(integer)$request->limit,
                'offset'=>(integer)$request->offset,
                'total_wallet_balance'=>$total_wallet_balance,
                'total_wallet_transactio'=>$wallet_transactio_list->total(),
                'wallet_transactio_list'=>$wallet_transactio_list->items()
            ],200);

        }else{

            return response()->json(['message' => translate('access_denied!')], 422);
        }
    }

    public function bonus_list(Request $request)
    {
        $add_fund_bonus_list = AddFundBonusCategories::where('is_active', 1)
            ->whereDate('start_date_time', '<=', date('Y-m-d'))
            ->whereDate('end_date_time', '>=', date('Y-m-d'))
            ->get();

        return response()->json(['add_fund_bonus_list'=>$add_fund_bonus_list], 200);
    }
}
