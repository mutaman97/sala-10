<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
class Tenantenvironment
{



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        if (tenant('status') == 1)
        {
            if (tenant('will_expire') < now())
            {
                $renew_url= url(env('APP_URL').'/partner/domain/renew/'.tenant('id'));
                return response()->view('errors.expired',compact('renew_url'));
            }

            $url=$request->getHost();
            $url=str_replace('www.','',$url);

            $url= preg_replace("/^([a-zA-Z0-9].*\.)?([a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z.]{2,})$/", '$2', $url);
            if ($url != env('APP_PROTOCOLESS_URL'))
            {
                if (tenant('custom_domain') != 'on')
                {
                    die('<center>Opps Custom domain not support</center>');
                }
            }

            $autoloaddata=getautoloadquery();

            $default_timezone=$autoloaddata['timezone'] ?? 'Africa/Khartoum';
            $default_language=$autoloaddata['default_language'] ?? 'en';
            $app_name=tenant('store_name');
            if (empty($app_name))
            {
                // $app_name=env('APP_NAME');
                $app_name= "Store Name";

            }

            \Config::set('app.name', $app_name);
            \Config::set('app.timezone', $default_timezone);


            if (Session::has('locale')==true)
            {
                \App::setlocale(\Session::get('locale'));
            }
            else
            {
                Session::put('locale',$default_language);
                \App::setlocale(\Session::get('locale'));
            }

            return $next($request);
        }

        elseif (tenant('status') == 2)
        {
            $support_url= url(env('APP_URL').'/partner/support');
            // echo "<center>Opps the store is temporary disabled...!!</center>";
            // echo "<center><a href=".$renew_url.">Submit a request</a></center>";
            // die();
            return response()->view('errors.pending',compact('support_url'));

        }

        elseif (tenant('status') == 3)
        {
            $renew_url= url(env('APP_URL').'/partner/domain/renew/'.tenant('id'));
            //  echo "<center>Subscription Expired Please Renew The Plan...</center>";
            //  echo "<center><a href=".$renew_url.">Renew Now</a></center>";

            //  die();
            return response()->view('errors.expired',compact('renew_url'));

        }

        elseif (tenant('status') == 0)
        {
            $support_url= url(env('APP_URL').'/partner/support/');
            // echo "<center>Opps the store is temporary disabled...!! Please contact support</center>";
            // echo "<center><a href=".$support_url.">Support</a></center>";

            // die();
            return response()->view('errors.disabled',compact('support_url'));

        }
        elseif (tenant('will_expire') < now())
        {
            $renew_url= url(env('APP_URL').'/partner/domain/renew/'.tenant('id'));
            // echo "<center>Subscription Expired Please Renew The Plan...</center>";
            // echo "<center><a href=".$renew_url.">Renew Now</a></center>";

            // die();
            return response()->view('errors.expired',compact('renew_url'));

        }


        return $next($request);

    }
}
