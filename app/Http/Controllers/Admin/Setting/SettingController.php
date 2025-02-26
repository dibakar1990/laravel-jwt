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
        //dd($paypal);
        return view('admin.setting.index', compact(
            'data', 
            'allTimezones',
            'stripe',
            'paypal',
            'razorpay'
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

    public function paymentSettings(PaymentSettingRequest $request)
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
}
