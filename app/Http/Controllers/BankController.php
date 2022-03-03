<?php

namespace App\Http\Controllers;

use App\Models\bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return bank::latest()->get();
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
        //
        $attributes = array(
            "name" => "required|min:3|unique:banks,name",
            "email" => "required|email|unique:banks,email",
        );
        $validator = Validator::make($request->all(), $attributes);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $bank = new bank();
            $bank->name = $request->name;
            $bank->email = $request->email;
            $bank->password = bcrypt('password');
            $newBank = $bank->save();
            if ($newBank) {
                $response = [
                    'bank' => $bank,
                ];
                return response($response, 201);
            } else {
                return response([
                    'message' => ['Sorry , something went wrong']
                ], 404);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bank $bank)
    {
        //
          $bank= bank::find($request->id);
        if ($bank) {
            $attributes = array(
                "name" => "required|min:3|unique:banks,name,{$bank->id}",
               // "email" => "required|email|unique:banks,email,{$company->id}",
               "email" => "required|min:3|unique:banks,email,{$bank->id}",
            );
            $validator = Validator::make($request->all(), $attributes);
            if ($validator->fails()) {
                return $validator->errors();
            } else {
                $bank->name = $request->name;
                $bank->email = $request->email;
                // $bank->password = $bank->password;
                $bank->save();
                if ($bank) {
                    $response = [
                        'message' => 'bank Updated',
                        'bank' => $bank
                    ];
                    return response($response, 201);
                } else {
                    return response([
                        'message' => 'These operation has failed'
                    ], 404);
                }
            }
        } else {
            return response([
                'message' => 'No bank Found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,bank $bank)
    {
        //
        $bank = bank::find($request->id);
        if ($bank) {
            $Data = $bank->delete();
            if ($Data) {
                $response = [
                    'message' => 'bank Deleted'
                ];
                return response($response, 201);
            } else {
                return response([
                    'message' => 'These operation has failed'
                ], 404);
            }
        } else {
            return response([
                'message' => 'No bank Found'
            ], 404);
        }
    }
    }

