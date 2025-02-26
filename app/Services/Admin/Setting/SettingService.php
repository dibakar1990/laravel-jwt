<?php

namespace App\Services\Admin\Setting;

use App\Models\Setting;
use App\ResponseTrait;

class SettingService
{
    use ResponseTrait;

    public function __construct()
    {
        //
    }

    public static function SettingUpdateOrInsert($key, $value)
    {
        $setting = Setting::where(['key' => $key['key']])->first();
        if ($setting) {
            $setting->value = $value['value'];
            $setting->save();
        } else {
            $setting = new Setting();
            $setting->key = $key['key'];
            $setting->value = $value['value'];
            $setting->save();
        }
    }
}
