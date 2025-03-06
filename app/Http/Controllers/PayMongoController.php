<?php

namespace App\Http\Controllers;

use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Http\Request;
use DB;
use URL;
use Redirect;

class PayMongoController extends Controller
{
    public function CreatePayment(Request $request) 
    {
        $data = [];
        $data['page_title'] = 'Diagnose Transactions';

        $data['transaction_details'] = DB::table('returns_header')
            ->leftJoin('model', 'returns_header.model', '=', 'model.id')
            ->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
            ->leftJoin('returns_payments', 'returns_header.id', '=', 'returns_payments.header_id')
            ->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group', 'payment_level')
            ->where('returns_header.id',$request->id)->first();

        return view('payment-gateway')->with('data', $data);
    }

    public function CreatePaymentProcess(Request $request) 
    {
        $data['transaction_details'] = DB::table('returns_header')
            ->leftJoin('model', 'returns_header.model', '=', 'model.id')
            ->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
            ->leftJoin('returns_payments', 'returns_header.id', '=', 'returns_payments.header_id')
            ->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group', 'payment_level')
            ->where('returns_header.id',$request->id)->first();

        if($data['transaction_details']->repair_status == 8){
            $payment_type = "Diagnostic Fee";
            $payment_cost = $data['transaction_details']->diagnostic_cost;
        }else if($data['transaction_details']->repair_status == 2){
            $payment_type = "Down Payment Fee";
            $payment_cost = $data['transaction_details']->downpayment_cost;
        }else if($data['transaction_details']->repair_status == 7){
            $payment_type = "Final Payment Fee";
            $payment_cost = $data['transaction_details']->final_payment_cost;
        }

        if(!empty($request->monthyear))
        {
            $expire_date = explode("/", $request->monthyear);
            $month =   intval($expire_date[0]);
            $year = intval($expire_date[1]);
        }else{
            $month = 0;
            $year = 0;
        }

        try{
            $paymentMethod = Paymongo::paymentMethod()->create([
                'type' => 'card',
                'details' => [
                    'card_number' => $request->cardnumber,
                    'exp_month'   => $month,
                    'exp_year'    => $year,
                    'cvc'         => $request->cvc,
                ],
                'billing' => [
                    'name'        => $data['transaction_details']->first_name." ".$data['transaction_details']->last_name,
                    'email'       => $data['transaction_details']->email,
                    'phone'       => $data['transaction_details']->contact_no
                ],
            ]);

            Paymongo::paymentMethod()->find($paymentMethod->id());

            $description = $data['transaction_details']->reference_no." - ".$payment_type ;

            $paymentIntent = Paymongo::paymentIntent()->create([
                'amount'                 => number_format($payment_cost, 2, '.', ''),
                'payment_method_allowed' => ['card'],
                'payment_method_options' => [
                    'card' => ['request_three_d_secure' => 'automatic']
                ],
                'description' => $description,
                'statement_descriptor' => 'Service Center',
                'currency' => "PHP",
            ]);
            Paymongo::paymentIntent()->find($paymentIntent->id());
            
            $successfulPayment = $paymentIntent->attach($paymentMethod->id());  

            DB::table('returns_payments')->where('header_id',$request->id)->update([
                'payment_intent_id' => $successfulPayment->id(),
                'payment_status'	=> $successfulPayment->status()     
            ]);
       
            if(!empty($successfulPayment->payments()))
            {
                $Payment = DB::table('returns_payments')->where('header_id',$request->id)->first();
                $payment_link = 'https://dashboard.paymongo.com/payments/'.$successfulPayment->payments()[0]['id'];
                $payment_date = date('Y-m-d H:i:s', $successfulPayment->payments()[0]['attributes']['paid_at']);
    
                if($data['transaction_details']->repair_status == 8)
                {
                    DB::table('returns_payments')->where('header_id',$request->id)->update([
                        'diagnostic_fee_payment_id' =>  $successfulPayment->payments()[0]['id'],
                        'payment_status'	        =>  $successfulPayment->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->id)->update([
                        'diagnostic_fee_payment_url'          =>  $payment_link,
                        'diagnostic_fee_payment_date_created' =>  $payment_date
                    ]);
    
                }else if($data['transaction_details']->repair_status == 2)
                {
                    DB::table('returns_payments')->where('header_id',$request->id)->update([
                        'downpayment_id'            =>  $successfulPayment->payments()[0]['id'],
                        'payment_status'	        =>  $successfulPayment->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->id)->update([
                        'down_payment_url'          =>  $payment_link,
                        'down_payment_date_created' =>  $payment_date
                    ]);
    
                }else if($data['transaction_details']->repair_status == 7)
                { 
                    DB::table('returns_payments')->where('header_id',$request->id)->update([
                        'final_payment_id'          =>  $successfulPayment->payments()[0]['id'],
                        'payment_status'	        =>  $successfulPayment->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->id)->update([
                        'final_payment_url' =>  $payment_link,
                        'final_payment_date_created' =>  $payment_date
                    ]);
                }   
    
                return redirect()->back()->with('success', 'Amount has been paid!');
            }else{

                if(!empty($successfulPayment->next_action()) && $successfulPayment->status() == 'awaiting_next_action' &&  $successfulPayment->next_action()['type'] == 'redirect')
                {
                    $pending_payment = array();
                    $pending_payment['payment_intent_id'] = $successfulPayment->id();
                    $pending_payment['payment_url'] = $successfulPayment->next_action()['redirect']['url'];
              
                    return redirect()->back()->with('pending_payment', $pending_payment);
                }
            }

        } catch (\Exception $e) {
            
            $err_message = json_decode($e->getMessage())->errors[0]->detail;
            $err_sub_code = json_decode($e->getMessage())->errors[0]->sub_code;
            $card_src = json_decode($e->getMessage())->errors[0]->source->pointer;
            
            if($err_sub_code = "fraudulent" || $err_sub_code = "processor_blocked" || $err_sub_code = "lost_card" || $err_sub_code = "stolen_card" || $err_sub_code = "blocked"){ 
                $error_message = " The card has been declined by the issuing bank. Please contact them for more information.";
            }else{
                if($card_src == "details.card_number"){
                    $CardDetail = "Card Number";
                }else if($card_src == "details.exp_month"){
                    $CardDetail = "Card Expiry Month";
                }else if($card_src == "details.exp_year"){
                    $CardDetail = "Card Expiry Year";
                }else if($card_src == "details.cvc"){
                    $CardDetail = "CVC";
                }else 
                $error_message = str_replace($card_src, $CardDetail, $err_message);
            }
            return back()->withError($error_message);
        }
    }

    public function CheckPaymentIntent(Request $request) 
    {
        $transaction_details = DB::table('returns_header')
            ->leftJoin('model', 'returns_header.model', '=', 'model.id')
            ->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
            ->leftJoin('returns_payments', 'returns_header.id', '=', 'returns_payments.header_id')
            ->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group', 'payment_level')
            ->where('returns_header.id',$request->header_id)->first();
            
        if(!empty($request->payment_intent)){
            $PaymentIntent = Paymongo::paymentIntent()->find($request->payment_intent);
            if(!empty($PaymentIntent->payments()[0]['id']))
            {
                $Payment = DB::table('returns_payments')->where('header_id',$request->header_id)->first();
                $payment_link = 'https://dashboard.paymongo.com/payments/'.$PaymentIntent->payments()[0]['id'];
                $payment_date = date('Y-m-d H:i:s', $PaymentIntent->payments()[0]['attributes']['paid_at']);
    
                if($transaction_details->repair_status == 8)
                {
                    DB::table('returns_payments')->where('header_id',$request->header_id)->update([
                        'diagnostic_fee_payment_id' =>  $PaymentIntent->payments()[0]['id'],
                        'payment_status'	        =>  $PaymentIntent->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->header_id)->update([
                        'diagnostic_fee_payment_url'          =>  $payment_link,
                        'diagnostic_fee_payment_date_created' =>  $payment_date
                    ]);
    
                }else if($transaction_details->repair_status == 2)
                {
                    DB::table('returns_payments')->where('header_id',$request->header_id)->update([
                        'downpayment_id'            =>  $PaymentIntent->payments()[0]['id'],
                        'payment_status'	        =>  $PaymentIntent->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->header_id)->update([
                        'down_payment_url'          =>  $payment_link,
                        'down_payment_date_created' =>  $payment_date
                    ]);
    
                }else if($transaction_details->repair_status == 7)
                { 
                    DB::table('returns_payments')->where('header_id',$request->header_id)->update([
                        'final_payment_id'          =>  $PaymentIntent->payments()[0]['id'],
                        'payment_status'	        =>  $PaymentIntent->payments()[0]['attributes']['status']
                    ]);
    
                    DB::table('returns_header')->where('id',$request->header_id)->update([
                        'final_payment_url' =>  $payment_link,
                        'final_payment_date_created' =>  $payment_date
                    ]);
                }   
            }
            
            return($PaymentIntent->payments()[0]['id']);
        }
    }
    
    public function GetGcashLink(Request $request) 
    {
        $billing_details = DB::table('returns_header')->where('id',$request->id)->first();
        $SourceID = DB::table('returns_payments')->where('header_id',$request->id)->value('id');
          
        if($billing_details->repair_status == 8){
            $payment_cost = $billing_details->diagnostic_cost;
        }else if($billing_details->repair_status == 2){
            $payment_cost = $billing_details->downpayment_cost;
        }else if($billing_details->repair_status == 7){
            $payment_cost = $billing_details->final_payment_cost;
        }

        $Source = Paymongo::source()->create([
            'type'     => 'gcash',
            'amount'   => number_format($payment_cost, 2, '.', ''),
            'currency' => 'PHP',
            'billing' => [
                'name'        => $billing_details->first_name." ".$billing_details->last_name,
                'email'       => $billing_details->email,
                'phone'       => $billing_details->contact_no
            ],
            'redirect' => [
                'success' => URL::to('/')."/"."get-chargeable/".$SourceID,
                'failed' => 'https://links.staging.paymongo.dev/gcash/failed'
            ],
        ]);

        DB::table('returns_payments')->where('id',$SourceID)->update([
            'source'		    => $Source->id(),
            'payment_status'	=> $Source->status()      
        ]);

        return redirect($Source->redirect()["checkout_url"]);
    }

    public function GetGrabpayLink(Request $request) 
    {
        $billing_details = DB::table('returns_header')->where('id',$request->id)->first();
        $SourceID = DB::table('returns_payments')->where('header_id',$request->id)->value('id');

        if($billing_details->repair_status == 8){
            $payment_cost = $billing_details->diagnostic_cost;
        }else if($billing_details->repair_status == 2){
            $payment_cost = $billing_details->downpayment_cost;
        }else if($billing_details->repair_status == 7){
            $payment_cost = $billing_details->final_payment_cost;
        }

        $Source = Paymongo::source()->create([
            'type'     => 'grab_pay',
            'amount'   => number_format($payment_cost, 2, '.', ''),
            'currency' => 'PHP',
            'billing'  => [
                'name'        => $billing_details->first_name." ".$billing_details->last_name,
                'email'       => $billing_details->email,
                'phone'       => $billing_details->contact_no
            ],
            'redirect' => [
                'success' => URL::to('/')."/"."get-chargeable/".$SourceID,
                'failed' => 'https://links.staging.paymongo.dev/grab_pay/failed'
            ],
        ]);

        DB::table('returns_payments')->where('id',$SourceID)->update([
            'source'		    => $Source->id(),
            'payment_status'	=> $Source->status()      
        ]);

        return redirect($Source->redirect()["checkout_url"]);
    }

    public function Chargeable(Request $request) 
    {
        $Payment = DB::table('returns_payments')->where('id',$request->id)->first();
        $Source = Paymongo::source()->find($Payment->source);

        $transaction_details = DB::table('returns_header')
            ->leftJoin('model', 'returns_header.model', '=', 'model.id')
            ->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
            ->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group')
            ->where('returns_header.id',$Payment->header_id)->first();
            
        if($transaction_details->repair_status == 8){
            $description = $transaction_details->reference_no." - Diagnostic Fee";
            $payment_cost = $transaction_details->diagnostic_cost;
        }else if($transaction_details->repair_status == 2){
            $description = $transaction_details->reference_no." - Downpayment";
            $payment_cost = $transaction_details->downpayment_cost;
        }else if($transaction_details->repair_status == 7){
            $description = $transaction_details->reference_no." - Final Payment";
            $payment_cost = $transaction_details->final_payment_cost;
        }

        if(!empty($Source) && $Source->status() == "chargeable")
        {
            $payment_id = Paymongo::payment()->create([
                'amount'        => number_format($payment_cost, 2, '.', ''),
                'currency'      => 'PHP',
                'description'   => $description,
                'statement_descriptor' => 'Service Center',
                'source' => [
                    'id'    => $Source->id(),
                    'type'  => $Source->type()
                ]
            ]);

            $payment_link = 'https://dashboard.paymongo.com/payments/'.$payment_id->id();
            $payment_date = date('Y-m-d H:i:s', $payment_id->paid_at());
            if($transaction_details->repair_status == 8){
                DB::table('returns_payments')->where('id',$request->id)->update([
                    'diagnostic_fee_payment_id' => $payment_id->id(),
                    'payment_status'	        => $payment_id->status() 
                ]);

                DB::table('returns_header')->where('id',$Payment->header_id)->update([
                    'diagnostic_fee_payment_url'          =>  $payment_link,
                    'diagnostic_fee_payment_date_created' =>  $payment_date
                ]);
                
            }else if($transaction_details->repair_status == 2){
                DB::table('returns_payments')->where('id',$request->id)->update([
                    'downpayment_id'            => $payment_id->id(),
                    'payment_status'	        => $payment_id->status() 
                ]);

                DB::table('returns_header')->where('id',$Payment->header_id)->update([
                    'down_payment_url'          =>  $payment_link,
                    'down_payment_date_created' =>  $payment_date
                ]);

            }else if($transaction_details->repair_status == 7)
            {
                DB::table('returns_payments')->where('id',$request->id)->update([
                    'final_payment_id'          => $payment_id->id(),
                    'payment_status'	        => $payment_id->status() 
                ]);

                DB::table('returns_header')->where('id',$Payment->header_id)->update([
                    'final_payment_url'          =>  $payment_link,
                    'final_payment_date_created' =>  $payment_date
                ]);
            }   

            if($Source->source_type() == 'gcash')
            {
                return redirect('https://links.staging.paymongo.dev/gcash/success');
            }else if($Source->source_type() == 'grab_pay')
            {
                return redirect('https://links.staging.paymongo.dev/grab_pay/success');
            }
            
        }else{
    
            if($Source->source_type() == 'gcash')
            {
                return redirect('https://links.staging.paymongo.dev/gcash/failed');
            }else if($Source->source_type() == 'grab_pay')
            {
                return redirect('https://links.staging.paymongo.dev/grab_pay/failed');
            }
        }
    }
}
