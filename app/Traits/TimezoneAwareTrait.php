<?php

namespace App\Traits;

trait TimezoneAwareTrait
{
    protected function timezone_db()
    {
        return config('app.timezone');
    }

    protected function timezone_admin()
    {
        return config('services.timezone.admin');
    }

    protected function timezone_user()
    {
        return config('app.user_timezone');
    }
}
