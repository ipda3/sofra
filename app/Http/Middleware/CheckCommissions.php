<?php

namespace App\Http\Middleware;

use Closure;

class CheckCommissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($request->user()->total_commissions - $request->user()->total_payments) > 400)
        {
            return responseJson(-1,'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفرة');
        }
        return $next($request);
    }
}
