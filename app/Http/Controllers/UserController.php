<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class UserController extends Controller
{
    //

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        $this->authorize('HRD', $this->user);
        return view('user.index', [
            'users' => User::all(),
        ]);
    }

    public function tambahPengguna(Request $request)
    {
        $this->authorize('HRD', $this->user);
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ]);

        $password = $request->password ? $request->password : '12345678';

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        Mail::send('emails.register', ['username' => $request->username, 'password' => $password], function (Message $message) use ($request) {
            $message->to($request->email)
                ->subject('Your Account Information');
        });

        return redirect('user')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('HRD', $this->user);
        $validatedData = $request->validate([
            'role' => 'required',
        ]);

        User::where('id', $user->id)->update($validatedData);

        return redirect('user')->with('success', 'User berhasil diupdate');
    }
}
