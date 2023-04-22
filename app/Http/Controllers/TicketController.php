<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\tickets;

class TicketController extends Controller
{

    public function getTickets(Request $request)
    {
        $token = $request->header('Authorization');
        
        $user = DB::table('users')
                    ->where('token', $token)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $expiryTime = Carbon::parse($user->expiry_time);

        if ($expiryTime->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }
       

        $tickets = DB::table('tickets')->get();

        return response()->json(['tickets' => $tickets], 200);
    }

    public function store(Request $request)
    {
        $token = $request->header('Authorization');
        
        $user = DB::table('users')
                    ->where('token', $token)
                    ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $expiryTime = Carbon::parse($user->expiry_time);

        if ($expiryTime->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }
        $validatedData = $request->validate([
            'tags' => 'required',
            'subject' => 'required',
            'body' => 'required',
           ]);
           
           
        $ticket = tickets::create([
            'tags' => $validatedData['tags'],
            'subject' => $validatedData['subject'],
            'body' => $validatedData['body'],
            'status' => 'open',
            'owner' => $user->username,
        ]);

        return response()->json(['ticket' => $ticket], 201);
    }

    public function updateTicket(Request $request,$id)
    {
        
        
        $token = $request->header('Authorization');

        $data = $request->all();
        $user = DB::table('users')
                    ->where('token', $token)
                    ->first();


        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $expiryTime = Carbon::parse($user->expiry_time);

        if ($expiryTime->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }
       

        $ticket = tickets::find($id);

        // Check if the ticket exists
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        if (isset($data['tags'])) {
            $ticket->tags = $data['tags'];
        }
    
        if (isset($data['subject'])) {
            $ticket->subject = $data['subject'];
        }
        if (isset($data['body'])) {
            $ticket->body = $data['body'];
        }

        if (isset($data['status'])) {
            $ticket->status = $data['status'];
        }
        if (isset($data['owner'])) {
            $ticket->owner = $data['owner'];
        }
        if (isset($data['assign_to'])) {
            $ticket->assign_to = $data['assign_to'];
        }

        $ticket->save();
        return response()->json(['ticket' => 'ticket updated succesfully.' ], 200);
    }
}
