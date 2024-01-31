<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Sanctum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
       
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
           
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->all()[0], 422);
            }

      
            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            ]);

        

            // $token = $user->createToken('api-token')->plainTextToken;

            return $this->success(
                // 'token' => $token,
                $user, 'User created successfully'
            );
        }catch (\Exception $e) {
            // Log::error(_CLASS_ . "->" . _FUNCTION_ . " | Exception:" . $e->getMessage());
            return $this->error('something went wrong');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Use the Eloquent model to retrieve the customer
        $customer = User::where('email', $request->email)
        ->first();


        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return $this->error('Invalid credentials');
        }

        // Use Sanctum's createToken method on the Eloquent model instance
        $token = $customer->createToken('token_name')->plainTextToken;
        return $this->success(['token' => $token], 'Login successful');
    }

}
