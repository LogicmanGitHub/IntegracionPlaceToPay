<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos=Pago::All();
        return view('pagos.index',compact('pagos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pagos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'referencia' => 'required',
            'descripcion' => 'required',
            'moneda' => 'required',
            'monto' => 'required'
        ]);



        $fecha_actual=date('Y-m-d');

        //login
        $login = "6dd490faf9cb87a9862245da41170ff2";
        //secretkey
        $secretKey =  "024h1IlD";


        $status=realizarPagoBasico(['login' => $login,
                                    'secretkey' => $secretKey,
                                    'referencia' => $request->referencia,
                                    'descripcion' => $request->descripcion,
                                    'moneda' => $request->moneda,
                                    'monto' => $request->monto]);

        try{
            $pago = new Pago(array(
                    'fecha'  => $fecha_actual,
                    'referencia' =>$request->referencia,
                    'descripcion' => $request->descripcion,
                    'moneda' => $request->moneda,
                    'monto' => $request->monto,
                    'status' => $status

            ));

            $result=$pago->save();

        } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }

        return redirect(action('PagoController@index'));

    }

}



function realizarPagoBasico($datos) {

            //generar seed
            $seed= date('c');

            //generar nonce

            if (function_exists('random_bytes')) {
                $nonce = bin2hex(random_bytes(16));
            } elseif (function_exists('openssl_random_pseudo_bytes')) {
                $nonce = bin2hex(openssl_random_pseudo_bytes(16));
            } else {
                $nonce = mt_rand();
            }

            $nonceBase64 = base64_encode($nonce);

            //generar trankey

            $tranKey = base64_encode(sha1($nonce . $seed . $datos['secretkey'], true));


            //auth del api
            $auth= array("login" => $datos['login'], 
                         "seed" => $seed,
                         "nonce" => $nonceBase64, 
                         "tranKey" => $tranKey);

            $payment=array("reference" => $datos['referencia'], 
                           "description" => $datos['descripcion'],
                           "amount" => ["currency" => $datos['moneda'], "total" => $datos['monto']]);
                
    
            $data = array("auth" => $auth, 
                          "payment" => $payment,
                          "expiration" => "2019-08-01T00:00:00-05:00",
                          "returnUrl" => "https://dev.placetopay.com/redirection/sandbox/session/5976030f5575d",
                           "ipAddress" => "127.0.0.1",                             
                           "userAgent" => "PlacetoPay Sandbox"                              
                           );



            $payload = json_encode($data);


            $ch = curl_init('https://test.placetopay.com/redirection/api/session');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload))
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            //execute post
            try {
                $result = curl_exec($ch);

            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }


            //close connection
            curl_close($ch);


            $responseArray=json_decode($result,true);

            return $responseArray['status']['status'];

}
