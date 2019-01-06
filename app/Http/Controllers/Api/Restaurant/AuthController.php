<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Models\Restaurant;
use App\Models\Token;
use Hash;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:restaurants,email',
            'password' => 'required|confirmed',
            'phone' => 'required',
            'delivery_cost' => 'required|numeric',
            'minimum_charger' => 'required|numeric',
            'whatsapp' => 'required',
            'availability' => 'required',
            'region_id' => 'required',
            'categories' => 'required|array',
            'photo' => 'image'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $userToken = str_random(60);
        $request->merge(array('api_token' => $userToken));
        $request->merge(array('password' => bcrypt($request->password)));
        $user = Restaurant::create($request->all());

        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('photo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $user->update(['photo' => 'uploads/restaurants/' . $name]);
        }
        
        if ($user) {
            $data = [
                'api_token' => $userToken,
                'data' => $user->load('region')
            ];
            return responseJson(1,'تم التسجيل بنجاح',$data);
        } else {
            return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'photo' => 'image',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        if ($request->has('name')) {
            $request->user()->update($request->only('name'));
        }
        if ($request->has('email')) {
            $request->user()->update($request->only('email'));
        }
        if ($request->has('password')) {
            $request->merge(array('password' => bcrypt($request->password)));
            $request->user()->update($request->only('password'));
        }

        if ($request->has('phone')) {
            $request->user()->update($request->only('phone'));
        }

        if ($request->has('region_id')) {
            $request->user()->update($request->only('region_id'));
        }

        if ($request->has('whatsapp')) {
            $request->user()->update($request->only('whatsapp'));
        }
        if ($request->has('delivery_cost')) {
            $request->user()->update($request->only('delivery_cost'));
        }
        if ($request->has('minimum_charger')) {
            $request->user()->update($request->only('minimum_charger'));
        }
        if ($request->has('categories')) {
            $request->user()->categories()->sync($request->categories);
        }
        if ($request->has('availability')) {
            $request->user()->update($request->only('availability'));
        }
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $logo = $request->file('photo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $request->user()->update(['photo' => 'uploads/restaurants/' . $name]);
        }

        $data = [
            'user' => $request->user()->load('region')
        ];
        return responseJson(1,'تم تحديث البيانات',$data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Restaurant::where('email', $request->input('email'))->first();
        if ($user)
        {
            if (Hash::check($request->password, $user->password))
            {
//                if (($user->total_commissions - $user->total_payments) > 400)
//                {
//                    return responseJson(0,'الحساب موقوف لتخطي العمولات التي لم تسدد الحد المطلوب');
//                }
                if (($user->total_commissions - $user->total_payments) > 400)
                {
                    $data = [
                        'api_token' => $user->api_token,
                        'user' => $user->load('city'),
                    ];
                    return responseJson(
                        -1,
                        'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفرة',
                        $data
                    );
                }
                if ($user->activated == 0)
                {
                    return responseJson(0,'الحساب موقوف .. تواصل مع الإدارة');
                }
                $data = [
                    'api_token' => $user->api_token,
                    'user' => $user->load('region'),
                ];
                return responseJson(1,'تم تسجيل الدخول',$data);
            }else{
                return responseJson(0,'بيانات الدخول غير صحيحة');
            }
        }else{
            return responseJson(0,'بيانات الدخول غير صحيحة');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email' => 'required'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Restaurant::where('email',$request->email)->first();
        if ($user){
            $code = rand(111111,999999);
            $update = $user->update(['code' => $code]);
            if ($update)
            {
                // send email
                Mail::send('emails.reset', ['code' => $code], function ($mail) use($user) {
                    $mail->from('no-reply@ipda3.com', 'تطبيق سفرة');

                    $mail->to($user->email, $user->name)->subject('إعادة تعيين كلمة المرور');
                });

                return responseJson(1,'برجاء فحص بريدك الالكتروني');
            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'لا يوجد أي حساب مرتبط بهذا البريد الالكتروني');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function password(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'code' => 'required',
            'password' => 'confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        $user = Restaurant::where('code',$request->code)->where('code','!=',0)->first();

        if ($user)
        {
            $update = $user->update(['password' => bcrypt($request->password), 'code' => null]);
            if ($update)
            {
                return responseJson(1,'تم تغيير كلمة المرور بنجاح');
            }else{
                return responseJson(0,'حدث خطأ ، حاول مرة أخرى');
            }
        }else{
            return responseJson(0,'هذا الكود غير صالح');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'type' => 'required|in:android,ios',
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Token::where('token',$request->token)->delete();

        $request->user()->tokens()->create($request->all());
        return responseJson(1,'تم التسجيل بنجاح');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Token::where('token',$request->token)->delete();
        return responseJson(1,'تم الحذف بنجاح بنجاح');
    }
}
