<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Numberphone;

class NumberphoneController extends Controller
{
    public function output()
    {
        $data = Numberphone::get();
        $ganjil = array();
        $genap = array();
        foreach($data as $a){
            $b = substr($this->decryptData($a->no_hp), -1);
            if($b%2 == 1){
                $ganjil[] = ['id'=>$a->id,'no_hp'=>$this->decryptData($a->no_hp),'provider' => $this->decryptData($a->provider)];                        
            }
            if($b%2 == 0){
                $genap[] = ['id'=>$a->id,'no_hp'=>$this->decryptData($a->no_hp),'provider' => $this->decryptData($a->provider)];                        
            }
        }

        return response()->json([
            'status' => "1",
            'ganjil' => $ganjil,
            'genap' => $genap
        ]);
    }

    public function auto()
    {   
        $numberPrefixes = ['0812', '0813', '0814'];
        $provider = ['xl','telkom','tri'];
        $a = array();                
        
        for ($i = 1; $i <= 25; ++$i) {
            $c = $numberPrefixes[array_rand($numberPrefixes)].''.$this->randomNumberSequence();
            $a[]=['no_hp'=>$this->encryptData($c),'provider' => $this->encryptData($provider[array_rand($provider)])];                        
        }
        try{
            Numberphone::insert($a); // Eloquent approach
            return response()->json([
                'status' => "1",
                'message' => "success"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
        
        
    }

    public function randomNumberSequence($requiredLength = 7, $highestDigit = 8) {
        $sequence = '';
        for ($i = 0; $i < $requiredLength; ++$i) {
            $sequence .= mt_rand(0, $highestDigit);
        }
        return $sequence;
    }

    public function encryptData($value){
        $encrypt_method = "AES-256-CBC";
        $secret_key = '7aE3OKIZxusugQdpk3gwNi9x63MRAFLgkMJ4nyil88ZYMyjqTSE3FIo8L5KJghfi';
        $secret_iv = '7aE3OKIZxusugQdpk3gwNi9x63MRAFLgkMJ4nyil88ZYMyjqTSE3FIo8L5KJghfi';
        
        $key = hash('sha256', $secret_key);
                
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
                        
        $encryptValue = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
        $encryptValue = base64_encode($encryptValue);

        return $encryptValue;
    }

    public function decryptData($value)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = '7aE3OKIZxusugQdpk3gwNi9x63MRAFLgkMJ4nyil88ZYMyjqTSE3FIo8L5KJghfi';
        $secret_iv = '7aE3OKIZxusugQdpk3gwNi9x63MRAFLgkMJ4nyil88ZYMyjqTSE3FIo8L5KJghfi';
        
        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $decryptValue = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);

        return $decryptValue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('output');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try{
            $np = new Numberphone;
            $np->no_hp = $this->encryptData($request->no_hp);
            $np->provider = $this->encryptData($request->provider);        
            $np->save();   
            return response()->json([
                'status' => "1",
                'message' => "success"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Numberphone::find($id);
        $data->no_hp = $this->decryptData($data->no_hp);
        $data->provider = $this->decryptData($data->provider);
        return view('edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $id;
        try{
            $data = Numberphone::find($id);
            $data->no_hp = $this->encryptData($request->no_hp);
            $data->provider = $this->encryptData($request->provider);        
            $data->save();
            return redirect('output');
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try{
            $data = Numberphone::find($id);
            $data->delete();
            return response()->json([
                'status' => "1",
                'message' => "success"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "0",
                'error' => $e->getMessage()
            ]);
        }

    }
}
