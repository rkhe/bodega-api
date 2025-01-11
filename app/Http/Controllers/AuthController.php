<?php

namespace App\Http\Controllers;

use App\Libraries\UserHistoryLibrary;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Laravel\Sanctum\PersonalAccessToken;
use UserStatuses;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where(['email' => $fields['email']])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        return response()->json([
            'message' => 'User successfully logged in.',
            'user' => $user,
            'token' => $user->createToken('gpwmstoken')->plainTextToken
        ], 201);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // cannot create admin account
        $fields = $request->validate([
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'user_role_id' => 'required|integer',
        ]);

        if ($fields['user_role_id'] === 1 && $fields['email'] != 'richardkhe@outlook.com')
            throw new InvalidArgumentException("User Role is not valid.");

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($request->password),
            'user_role_id' => $fields['user_role_id'],
            'user_status_id' => $fields['user_status_id'] ?? UserStatuses::ACTIVE,
        ]);

        $token = $user->createToken('gpwmstoken')->plainTextToken;

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $fields['email'])->first();
        $this->changeAccessing($user->id, null);
        $user->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $fields['email'])->first();
        return response()->json($user, 200);
    }

    public function verify()
    {
        return response()->json(["message" => "Authenticated."], 200);
    }

    /**
     * Verify if a URL has been accessed. 
     * Returns user's full name if found, set current user's accessing when not.
     * @param Request $request 
     * @return void
     */
    public function accessing(Request $request)
    {
        $url = $request->url;
        $check = false;
        $lockingPages = ['dispatch2/edit', 'picklist/create/', 'picklist/edit', 'picklist/confirmation'];
        // set check = true when url contains one of these pages
        foreach ($lockingPages as $p) {
            if (strpos($url, $p) !== false) {
                $check = true;
                break;
            }
        }

        if ($check) {
            $user = User::where('accessing', $url)->first();
            if ($user && $user->id != $request->user_id) {
                $accessToken = PersonalAccessToken::where('tokenable_id', $user->id)->orderBy('updated_at', 'desc')->first();
                if ($accessToken != null) {
                    $last_used_at = $accessToken->last_used_at;
                    if (!$last_used_at) $last_used_at = $accessToken->created_at;

                    $expiration = config('sanctum.expiration');
                    if (!$expiration || $last_used_at->gt(now()->subMinutes($expiration))) {
                        // return if invalid or accessed
                        $currentUser = User::find($request->user_id);
                        return response()->json([
                            'success' => false,
                            'accessed_by' => $user->full_name,
                            'last_accessed' => $currentUser->accessing,
                        ], 200);
                    } else if ($user->id != $request->user_id) {
                        $this->changeAccessing($user->id, null); // update previous user accessing to null
                    }
                }
            }
        }

        $this->changeAccessing($request->user_id, $url); // update current user accessing

        /** let's not log everything for now */
        // UserHistoryLibrary::log($request->user_id, $url, $request->getClientIp());

        return response()->json(['success' => true], 200);
    }

    #endregion
}
