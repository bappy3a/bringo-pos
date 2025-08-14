<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\BusinessesStoreRequest;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registerBusinessFrom()
    {
        $businesses = Business::count();
        if ($businesses > 0) {
            return redirect()->route('register');
        }

        $currencys = Currency::orderBy('country')->get();
        $timezones = json_file_to_collect(asset('json/timezone.json'));
        return view('auth.register-business', compact('currencys', 'timezones'));
    }
    public function registerBusiness(BusinessesStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('uploads');
                $request->merge(['logo_image' => $logoPath]);
            }

            $user = $this->storeUser($request->only([
                'business_id',
                'first_name',
                'last_name',
                'username',
                'email',
                'password',
                'language',
            ]), null);

            $request->merge(['owner_id' => $user->id]);
            $business = $this->businessCreteOrUpdate($request->only([
                'name',
                'start_date',
                'industry',
                'trade_license',
                'tax_id',
                'fiscal_year_starts',
                'phone_no',
                'default_profit_percent',
                'owner_id',
                'time_zone',
                'logo_image',
                'fy_start_month',
                'accounting_method',
                'default_sales_discount',
                'sell_price_tax',
                'currency_id',
                'sku_prefix',
                'enable_tooltip',
            ]));

            $businessLocation = $this->businessLocaionCreteOrUpdate($request->only([
                'business_id',
                'name',
                'landmark',
                'country',
                'state',
                'city',
                'zip_code',
                'mobile',
                'alternate_number',
                'email',
            ]), $business->id);

            DB::commit();
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function businessCreteOrUpdate($request)
    {
    // $request is an array here, so cast to object if needed
    $request = (object)$request;
        $business = new Business();
        $business->name = $request->name;
        $business->start_date = $request->start_date;
        $business->industry = $request->industry;
        $business->trade_license = $request->trade_license;
        $business->tax_id = $request->tax_id;
        $business->fiscal_year_starts = $request->fiscal_year_starts ?? null;
        $business->phone_no = $request->phone_no ?? null;
        $business->default_profit_percent = $request->default_profit_percent ?? 0;
        $business->owner_id = $request->owner_id ?? null;
        $business->time_zone = $request->time_zone;
        $business->time_zone = $request->time_zone;
        $business->fy_start_month = $request->fy_start_month ?? true;
        $business->accounting_method = $request->accounting_method ?? 'fifo';
        $business->default_sales_discount = $request->default_sales_discount ?? null;
        $business->sell_price_tax = $request->sell_price_tax ?? 'includes';
        $business->currency_id = $request->currency_id;
        $business->logo = $request->logo_image;
        $business->sku_prefix = $request->sku_prefix ?? null;
        $business->enable_tooltip = $request->enable_tooltip ?? true;
        $business->save();
        return $business;
    }

    public function businessLocaionCreteOrUpdate($request, $business_id)
    {
    // $request is an array here, so cast to object if needed
    $request = (object)$request;
        $location = new BusinessLocation();
        $location->business_id = $business_id;
        $location->name = $request->name;
        $location->landmark = $request->landmark ?? 'landmark';
        $location->country = $request->country;
        $location->state = $request->state;
        $location->city = $request->city;
        $location->zip_code = $request->zip_code;
        $location->mobile = $request->mobile ?? null;
        $location->alternate_number = $request->alternate_number ?? null;
        $location->email = $request->email ?? null;
        $location->save();
        return $location;
    }

    public function storeUser($request, $business_id)
    {
    // $request is an array here, so cast to object if needed
    $request = (object)$request;
        $user = new User();
        $user->business_id = $business_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->language = $request->language ?? 'en';
        $user->status = $request->active ?? 'active';
        $user->save();
        auth()->login($user);
        return $user;
    }
}
