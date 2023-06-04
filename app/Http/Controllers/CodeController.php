<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class CodeController extends Controller
{
    public function view()
    {
        // Get authenticated user
        $user = Auth::user();
        //get User data
        $UserId = $user->id;

        //Check if the user have a ready code not expired 

        $code = Code::where('client_id', $UserId)
        ->orderBy('id', 'desc')
        ->first();

        if ($code) {
            $expirationDate = $code->expiration_date;
            $currentDateTime = Carbon::now();
            if($expirationDate === $currentDateTime || $expirationDate < $currentDateTime )
            {
                return view('GeneratePage');

            }else
	    {
            $code_generate = $code->code;
		   return view('GeneratePage', [
                    'Check' => false,
                    'code_generate' => $code_generate,
                ]);
	    }
        } else {
        // Code not found, handle accordingly

            // Check if user is authenticated and retrieve the username
            $username = $user ? $user->name : null;
        
                // Pass the username to the view
            return view('GeneratePage', ['Username' => $username]);
        }
        

    }

    public function generateCode(Request $request)
    {
        // Generate unique code
        $code = substr(md5(uniqid()), 0, 8);

        // Get authenticated user and retrieve the user ID
        $user = Auth::user();
        $userID = $user ? $user->id : 8;
        $email = $user->email;
        $name = $user->name;

        $expiration_date = now()->addHours(24); // Add 24 hours to the current date

        // Store the generated code in the database
        $codeEntry = Code::create([
            'code' => $code,
            'client_id' => $userID,
            'expiration_date' => $expiration_date,
            'Clientname' => $name,
            'email' => $email
        ]);

        return response()->json(['code' => $codeEntry->code]);
    }

    public function dashboard()
    {
        $codeCount = Code::count();

        $clients = DB::table('codes')
        ->select('client_id','Clientname', 'email')
        ->distinct('client_id')
        ->get();

    

        // Prepare the $codeData variable
        $codeData = Code::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'))
        ->get();
        return view('dashboard',['codeCount'=> $codeCount,'codeData'=>$codeData,'clients'=>$clients ]);
    }

    public function Verificationcode(Request $request)
    {
        $code = $request->input('code');

        // Perform the code availability check
        $codeRecord = Code::where('code', $code)->first();
    
        if ($codeRecord) {
            $currentDateTime = Carbon::now();
            $expirationDate = Carbon::parse($codeRecord->expiration_date);
    
            if ($expirationDate >= $currentDateTime) {
                // Code is still available
                $message = "Code toujours disponible";
                $colorClass = "alert-success";
            } else {
                // Code has expired
                $message = "Code non disponible";
                $colorClass = "alert-danger";
            }
        } else {
            // Code not found
            $message = "Code introuvable";
            $colorClass = "alert-warning";
        }
    
        return view('VérificationCode', [
            'message' => $message,
            'colorClass' => $colorClass,
        ]);
    }

}



