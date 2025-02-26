<?php

namespace App\Http\Controllers\Admin\Setting;

use App\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\PaymentSettingRequest;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Models\Setting;
use App\Models\Timezone;
use App\ResponseTrait;
use App\Services\Admin\Setting\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ResponseTrait;
    private $fileService;
    private $settingService;

    public function __construct(FileService $fileService, SettingService $settingService)
    {
        $this->fileService = $fileService;
        $this->settingService = $settingService;
    }

    public function index()
    {
        $allTimezones = Timezone::orderBy('offset')->get();
        $data = [];
        $settings = Setting::all();
        foreach ($settings as $setting) {
            $data[$setting->key] = $setting->value;
        }
        $stripe = [];
        $stripePayment = Setting::where('key', 'stripe_credentials')->first();
        if (!empty($stripePayment)) {
            $stripe_credentials = json_decode($stripePayment->value, true);
            $stripe['publishable_key'] = $stripe_credentials['publishable_key'];
            $stripe['secret_key'] = $stripe_credentials['secret_key'];
            $stripe['currency'] = $stripe_credentials['currency'];
        }
        $paypal = [];
        $paypalPayment = Setting::where('key', 'paypal_credentials')->first();
        if (!empty($paypalPayment)) {
            $paypal_credentials = json_decode($paypalPayment->value, true);
            $paypal['paypal_mode'] = $paypal_credentials['paypal_mode'];
            $paypal['paypal_currency'] = $paypal_credentials['paypal_currency'];
            $paypal['app_id'] = $paypal_credentials['app_id'];
            $paypal['paypal_client_secret'] = $paypal_credentials['paypal_client_secret'];
            $paypal['paypal_client_id'] = $paypal_credentials['paypal_client_id'];
        }
        $razorpay = [];
        $razorpayPayment = Setting::where('key', 'razorpay_credentials')->first();
        if (!empty($razorpayPayment)) {
            $razorpay_credentials = json_decode($razorpayPayment->value, true);
            $razorpay['razorpay_key'] = $razorpay_credentials['razorpay_key'];
            $razorpay['razorpay_secret'] = $razorpay_credentials['razorpay_secret'];
        }
        $mailSetting = [];
        $mail = Setting::where('key','mail_config')->first();
        if (!empty($mail)) {
            $mail_credentials = json_decode($mail->value, true);
            $mailSetting['mail_driver'] = $mail_credentials['mail_driver'];
            $mailSetting['mail_host'] = $mail_credentials['mail_host'];
            $mailSetting['mail_port'] = $mail_credentials['mail_port'];
            $mailSetting['mail_address'] = $mail_credentials['mail_address'];
            $mailSetting['username'] = $mail_credentials['username'];
            $mailSetting['password'] = $mail_credentials['password'];
            $mailSetting['from_name'] = $mail_credentials['from_name'];
            $mailSetting['encryption'] = $mail_credentials['encryption'];
        }
        //dd($paypal);
        return view('admin.setting.index', compact(
            'data', 
            'allTimezones',
            'stripe',
            'paypal',
            'razorpay',
            'mailSetting'
        ));
    }

    public function store(SettingRequest $request)
    {
        //dd($request->all());
        SettingService::SettingUpdateOrInsert(['key' => 'app_name'], ['value' => $request->app_name]);
        SettingService::SettingUpdateOrInsert(['key' => 'email'], ['value' => $request->email]);
        SettingService::SettingUpdateOrInsert(['key' => 'phone'], ['value' => $request->phone]);
        SettingService::SettingUpdateOrInsert(['key' => 'developed_by'], ['value' => $request->developed_by]);
        SettingService::SettingUpdateOrInsert(['key' => 'timezone'], ['value' => $request->timezone]);
        SettingService::SettingUpdateOrInsert(['key' => 'address'], ['value' => $request->address]);
        SettingService::SettingUpdateOrInsert(['key' => 'description'], ['value' => $request->description]);
        if ($request->hasFile('file')) {
            $uploaded_file = $request->file('file');
            $file_path = $this->fileService->store($uploaded_file, '/logo');
            SettingService::SettingUpdateOrInsert(['key' => 'logo'], ['value' => $file_path]);
        }
        if ($request->hasFile('fav_file')) {
            $uploaded_file = $request->file('fav_file');
            $file_path = $this->fileService->store($uploaded_file, '/logo');
            SettingService::SettingUpdateOrInsert(['key' => 'fav_icon'], ['value' => $file_path]);
        }
        $redirect = route('admin.settings.index');
        return  $this->success($redirect, 'Setting updated successfully.');
       
    }

    public function paymentSettings(Request $request)
    {
        SettingService::SettingUpdateOrInsert(
            ['key' => 'stripe_credentials'],
            [
                'value' => json_encode([
                    "publishable_key" => $request['publishable_key'],
                    "secret_key" => $request['secret_key'],
                    "currency" => $request['currency'],
                ])
            ]
        );
        SettingService::SettingUpdateOrInsert(
            ['key' => 'paypal_credentials'],
            [
                'value' => json_encode([
                    "paypal_mode" => $request['paypal_mode'],
                    "app_id" => $request['app_id'],
                    "paypal_currency" => $request['paypal_currency'],
                    "paypal_client_secret" => $request['paypal_client_secret'],
                    "paypal_client_id" => $request['paypal_client_id'],
                ])
            ]
        );
        SettingService::SettingUpdateOrInsert(
            ['key' => 'razorpay_credentials'],
            [
                'value' => json_encode([
                    "razorpay_key" => $request['razorpay_key'],
                    "razorpay_secret" => $request['razorpay_secret'],
                ])
            ]
        );
        $redirect = route('admin.settings.index');
        return  $this->success($redirect, 'Payment setting updated successfully.');
    }

    public function smtpSettings(Request $request)
    {
        SettingService::SettingUpdateOrInsert(
            ['key' => 'mail_config'],
            [
                'value' => json_encode([
                    "mail_driver" => $request['mail_driver'],
                    "mail_host" => $request['mail_host'],
                    "mail_port" => $request['mail_port'],
                    "mail_address" => $request['mail_address'],
                    "username" => $request['username'],
                    "password" => $request['password'],
                    "from_name" => $request['from_name'],
                    "encryption" => $request['encryption'],
                ])
            ]
        );
        $redirect = route('admin.settings.index');
        return  $this->success($redirect, 'Mail setting updated successfully.');
    }

    public function seoSettings(Request $request)
    {
        $seoSetting= Setting::where('key','seo_data')->first();
        if (!empty($seodata)) {
            $seo = json_decode($seoSetting->value, true);
        }

        
            if ($request->hasFile('og_image')) {
                $uploaded_file = $request->file('og_image');
                $file_path = $this->fileService->store($uploaded_file, '/logo');
            }
        
        SettingService::SettingUpdateOrInsert(
            ['key' => 'seo_data'],
            [
                'value' => json_encode([
                    "meta_title" => $request['meta_title'],
                    "meta_description" => $request['meta_description'],
                    "og_title" => $request['og_title'],
                    "og_description" => $request['og_description'],
                    "og_image" => $file_path,
                ])
            ]
        );
        $redirect = route('admin.settings.index');
        return  $this->success($redirect, 'Mail setting updated successfully.');
    }
}
