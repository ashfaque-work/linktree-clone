<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Appearance;

class MaxProfileRule implements Rule
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function passes($attribute, $value)
    {
        $user = auth()->user();
        $userType = $user->userDetail->user_type;

        if ($userType == 'premium') {
            $count = Appearance::where('user_id', $this->userId)->count();
            return $count < 10;
        } else {
            $count = Appearance::where('user_id', $this->userId)->count();
            return $count < 1;
        }
    }

    public function message()
    {
        return "You have exceeded the maximum limit of profile creation. Please update your Subscription.";
    }
}