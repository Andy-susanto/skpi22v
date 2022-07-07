<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $durasi = 6000;
            if (auth()->check()) {
                $role_ids = [];
                foreach (auth()->user()->roles as $role) {
                    $role_ids[] = $role->id_role;
                }

                if(Cache::has('menu')){
                    $menus = Cache::get('menu');
                }else{
                    $menus = Menu::where('parent_id', 0)->whereHas('roles', function ($q) use ($role_ids) {
                        $q->whereIn('id_role', $role_ids);
                    })->orderBy('urutan', 'asc')->get();
                    Cache::put('menu',$menus,$durasi);
                }

                foreach ($menus as $menu) {
                    if (count($menu->submenus) == 0) {
                        $event->menu->add($menu->nama_menu);
                    } else {

                        $event->menu->add($menu->nama_menu);

                        if(Cache::has('submenus')){
                            $submenus = Cache::get('submenus');
                        }else{
                            $submenus = Menu::where('parent_id', $menu->id_menu)->whereHas('roles', function ($q) use ($role_ids) {
                                $q->whereIn('id_role', $role_ids);
                            })->orderBy('urutan', 'asc')->get();
                            Cache::put("submenus",$submenus,$durasi);
                        }

                        foreach ($submenus as $submenu) {
                            if (count($submenu->submenus) == 0) {

                                $event->menu->add(['text' => $submenu->nama_menu, 'url' => $submenu->url, 'icon' => $submenu->icon]);

                            } else {

                                $anothermenu = [];
                                if(Cache::has("subsubmenus")){
                                    $subsubmenus = Cache::get('subsubmenus');
                                }else{
                                    $subsubmenus = Menu::where('parent_id', $submenu->id_menu)->whereHas('roles', function ($q) use ($role_ids) {
                                        $q->whereIn('id_role', $role_ids);
                                    })->orderBy('nama_menu', 'asc')->get();
                                    Cache::put("subsubmenus",$subsubmenus,$durasi);
                                }

                                foreach ($subsubmenus as $subsubmenu) {
                                    $subsubmenu2['text'] = $subsubmenu->nama_menu;
                                    $subsubmenu2['url'] = $subsubmenu->url;
                                    $anothermenu[] = $subsubmenu2;
                                }

                                $event->menu->add(['text' => $submenu->nama_menu, 'url' => $submenu->url, 'icon' => $submenu->icon, 'submenu' => $anothermenu]);
                            }
                        }


                    }
                }
            }
        });
    }
}
