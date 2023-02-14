<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function trials()
    {
        return $this->hasMany(_Trial::class, 'user_id');
    }

    public function userValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'ime' => 'required|min:2|max:100',
            'email' => 'required|unique:users|email',
            'lozinka' => 'required|alpha_dash|min:6',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 400);
        } else {
            return response()->json('success', 200);
        }

    }

    public function createUser($request)
    {
        $validation = $this->userValidation($request);
        if ($validation->status() == 400) {
            return response()->json($validation, 400);
        }
        $user = User::create([
            'name' => $request->ime,
            'email' => $request->email,
            'password' => Hash::make($request->lozinka),
            'role_id' => $request->role
        ]);

        return response($user->refresh(), 200);
    }

    public function getUsers()
    {
        $users = User::orderBy('name')->get();
        return $users;
    }

    public function getUsersWithOutAdmin()
    {
        $users = User::orderBy('name')->where('role_id', 1)->get();
        return $users;
    }

    public function deleteUser($id)
    {
        $users = User::find($id);
        if (!$users || $id == Auth::user()->id) {
            return response('{}', 404);
        }
        $users->delete();
        return response('{}', 204);;
    }


}
