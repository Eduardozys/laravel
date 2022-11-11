<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if(!auth()->check()){
            return redirect()->route('login');
        }

        if(!session()->has('cart')) return redirect()->route('home');

        $this->makePagSeguroSession();

         $cartItems = array_map(function ($line){
            return $line['amount'] * $line['price'];
        }, session()->get('cart'));

        $cartItems = array_sum($cartItems);



        return view('checkout', compact('cartItems'));
    }

    public function proccess(Request $request)
    {
        try { $dataPost = $request->all();

            $user = auth()->user();
            $cartItens = session()->get('cart');
            $reference ='XPTO';

            $creditCardPayment = new CreditCard($cartItens, $user, $dataPost, $reference);
            $result = $creditCardPayment->doPayment();


            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItens),
                'store_id' => 42
            ];

            $user->orders()->create($userOrder);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');


            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido criado com sucesso!',
                     'order' =>  $reference
                ]
            ]);

        }catch (\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao Processar Pedido!';
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
                ],401);
        }
    }

    public function thanks()
    {
        return view('thanks');
    }

    private function makePagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code')) {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }
}