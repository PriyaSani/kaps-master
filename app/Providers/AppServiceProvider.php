<?php

namespace App\Providers;

use App\Model\UserModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){

            if (Auth::check()) {

                $checkPermission = UserModule::where('employee_id',Auth::guard()->user()->id)->with(['module'])->get();

                $module = array();

                if(!is_null($checkPermission)){
                    foreach($checkPermission as $pk => $pv){
                        $module[] = $pv->module->slug;
                    }
                }

                /*View::share('module',$module);*/
                view()->share('module',$module);
            }
        });
    }
}
