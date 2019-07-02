<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transactions as Transaction;
use App\User;

use Illuminate\Support\Facades\Validator;
use App\Traits\GatewayTrait;
use DB;

class TransactionController extends Controller
{
    use GatewayTrait;
    /**
     * Create a new VerifyHashController instance.
     *
     * @return void
     *
    */
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    /**
     * Handle transaction process
     * @param  Request $request Illuminate\Http\Request
     * @return mixed json encode
     */
    public function transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'account_number' => 'required',
            'nominal' => 'required',
        ]);

        if ($validator->fails()) 
        {
            $this->success = false;
            $this->message = 'Please input all form!';

            return $this->json();
        }
        else
        {
            $inputs = $request->all();
            DB::beginTransaction();
            if($inputs['type'] == 'credit')
            {
                $model = new Transaction;
                $model->type = $inputs['type'];
                $model->account_number = $inputs['account_number'];
                $model->nominal = $inputs['nominal'];
                $model->save();

                $customer = Customer::where('account_number',$inputs['account_number'])->first();
                $customer->balance = $customer->balance + $inputs['nominal'];
                $customer->save();
            }
            else
            {
                $model = new Transaction;
                $model->type = $inputs['type'];
                $model->account_number = $inputs['account_number'];
                $model->nominal = $inputs['nominal'];
                $model->save();

                $customer = Customer::where('account_number',$inputs['account_number'])->first();
                $customer->balance = $customer->balance - $inputs['nominal'];
                $customer->save();
            }
            DN::commit();
            $data = [
                'transaction_id' => $model->save(),
                'type'           => $inputs['type'],
                'account_number' => $inputs['account_number'],
                'transaction_date' => $model->created_at,
            ];

            $this->success = true;
            $this->data    = $data;
            $this->message = 'Transaction success!';

            return $this->json();
        }
    }

    /**
     * Check Balance
     * @param  Request $request Illuminate\Http\Request
     * @return mixed json encode
     */
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required',
        ]);

        if ($validator->fails()) 
        {
            $this->success = false;
            $this->message = 'Please input all form!';

            return $this->json();
        }
        else
        {
            $model = Customer::where('account_number', $request->account_number)->first();
            $this->success = true;
            $this->data    = $model->toArray();
            $this->message = 'Transaction success!';

            return $this->json();

        }
    }

}
