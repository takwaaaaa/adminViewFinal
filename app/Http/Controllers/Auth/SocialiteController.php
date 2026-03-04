<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        if ($provider === 'twitter') {
            return Socialite::driver('twitter-oauth-2')
                ->scopes(['tweet.read', 'users.read', 'email'])
                ->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = $provider === 'twitter'
                ? Socialite::driver('twitter-oauth-2')->user()
                : Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Authentication failed. Please try again.']);
        }

        $email = $socialUser->getEmail();

        if (!$email) {
            return redirect()->route('login')
                ->withErrors(['email' => 'X did not share your email. Please enable email access in your X account settings, or sign in with email/password.']);
        }

        $existing = User::where('email', $email)->first();

        if ($existing) {
            if ($existing->isPending()) {
                Auth::login($existing);
                return redirect()->route('pending-approval');
            }

            if (!$existing->isApproved() || !$existing->isActive()) {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Your account has been deactivated. Please contact support.']);
            }

            Auth::login($existing, remember: true);
            return redirect()->intended(route('dashboard'));
        }

        // New user — pending approval
        $name = $socialUser->getName()
            ?? $socialUser->getNickname()
            ?? explode('@', $email)[0];

        $user = User::create([
            'name'              => $name,
            'email'             => $email,
            'password'          => bcrypt(\Str::random(24)),
            'email_verified_at' => now(),
            'role'              => 'user',
            'status'            => 'inactive',
            'approval_status'   => 'pending',
        ]);

        $superadmins = User::where('role', 'superadmin')
            ->where('status', 'active')
            ->where('approval_status', 'approved')
            ->get();

        foreach ($superadmins as $admin) {
            AdminNotification::create([
                'triggered_by' => $user->id,
                'type'         => 'new_signup',
                'message'      => "{$user->name} signed up via {$provider} and is awaiting approval.",
            ]);
        }

        Auth::login($user);
        return redirect()->route('pending-approval');
    }
}