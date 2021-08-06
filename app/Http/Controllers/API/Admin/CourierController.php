<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Courier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\OrderShipment;

class CourierController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4',
            'password' => 'required',
        ]);

        $courier = Courier::where('username', $request->username)->first();

        if (! $courier || ! Hash::check($request->password, $courier->password)) {
            return response([
                'success' => false,
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $courier->tokens()->delete();
        $token = $courier->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'courier' => $courier
        ], 200);
    }

    public function show(Request $request)
    {
        return $request->user();
    }

    public function orders(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->orders
        ], 200);
    }

    public function orders_new(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->orders->where('status', 'new')->values()
        ], 200);
    }

    public function orders_active(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->orders->where('status', 'active')->values()
        ], 200);
    }
    
    public function orders_history(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->orders->whereIn('status', ['completed', 'returned'])->values()
        ], 200);
    }
    
    public function orders_completed(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->orders->where('status', 'completed')
        ], 200);
    }
    
    public function set_active($orderID)
    {
        $shipment= DB::table('order_shipment')->where('order_id',$orderID)->first();
        
        if($shipment) {
            $shiporder = OrderShipment::where('shipment_id', $shipment->shipment_id)->first();
            $shiporder->status = "active";
            $shiporder->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Order status updated to active successfully.'
            ], 200);
        }
        return response([
            'success' => false,
            'message' => 'Something went wrong.'
        ], 400);
    }

    public function set_completed($orderID)
    {
        $shipment= DB::table('order_shipment')->where('order_id',$orderID)->first();
        
        if($shipment) {
            $shiporder = OrderShipment::where('shipment_id', $shipment->shipment_id)->first();
            $shiporder->status = "completed";
            $shiporder->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated to completed successfully.'
            ], 200);
        }
        return response([
            'success' => false,
            'message' => 'Something went wrong.'
        ], 400);
    }

    public function tours(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()->tours
        ], 200);
    }

    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         // 'otp_code' => 'required'
    //         'otp_code' => 'required|digits:4'
    //     ]);

    //     $courier = Courier::where('email', $request->email)->first();

    //     if (! $courier) {
    //         return response([
    //             'success' => false,
    //             'message' => 'The provided email doesn\'t existe.'
    //         ], 404);
    //     }

    //     // rah msse7t had field mn database table
    //     $courier->code_otp = $request->otp_code;
    //     $courier->save();
        
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Code OTP saved successfully.'
    //     ], 200);
    // }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $courier = Courier::where('email', $request->email)->first();

        if (! $courier) {
            return response([
                'success' => false,
                'message' => 'The provided email doesn\'t exist.'
            ], 401);
        }

        $courier->password = Hash::make($request->password);
        $courier->save();

        $courier->tokens()->delete();
        $token = $courier->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'courier' => $courier
        ], 200);
    }

    public function logout(Request $request)
    {
        if(!$request->user()->tokens()->delete()) {
            return response([
                'success' => false,
                'message' => 'Something went wrong!'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => "You logged out successfully."
        ], 200);
    }
}
