<?php

namespace App\Providers;

use App\Models\Kegiatan;
use App\Repositories\BeasiswaRepository;
use App\Repositories\FileRepository;
use App\Repositories\HkiRepository;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\KBAsingRepository;
use App\Repositories\KegiatanRepository;
use App\Repositories\KewirausahaanRepository;
use App\Repositories\PublikasiRepository;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind(
            CrudInterface::class,
            BeasiswaRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            FileRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            HkiRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            PublikasiRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            KBAsingRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            KewirausahaanRepository::class
        );
        $this->app->bind(
            CrudInterface::class,
            KegiatanRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
