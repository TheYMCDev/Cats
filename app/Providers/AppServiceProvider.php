<?php

namespace App\Providers;

use App\Http\Repositories\CatRepository;
use App\Http\Repositories\QueryUserRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\VaccineRepository;
use App\Http\Services\BaseService;
use App\Http\Services\CatService;
use App\Http\Services\QueryUserService;
use App\Http\Services\VaccinesService;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\UserService;
use App\Http\Repositories\BaseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserService::class, UserRepository::class);
        $this->app->bind(CatService::class, CatRepository::class);
        $this->app->bind(VaccinesService::class, VaccineRepository::class);
        $this->app->bind(BaseService::class,BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
