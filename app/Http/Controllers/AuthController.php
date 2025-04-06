<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function handleTelegramCallback(Request $request) {
        $data = $request->all();

        if ($this->isValidTelegramData($data)) {
            $user = User::firstOrCreate(
                ['telegram_id' => $data['id']],
                [
                    'name' => $data['username'],
                    'profile_photo_url' => $data['photo_url'],
                ]
            );

            Auth::login($user, true);

            return Redirect::route('dashboard');
        } else {
            return Redirect::route('login')->withErrors(['Invalid Telegram data']);
        }
    }

    private function isValidTelegramData($data) {
        $checkHash = $data['hash'];
        unset($data['hash']);

        $dataCheckArr = [];
        foreach ($data as $key => $value) {
            $dataCheckArr[] = $key . '=' . $value;
        }
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);

        $secretKey = hash('sha256', config('nutgram.token'), true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        return hash_equals($hash, $checkHash);
    }
}
