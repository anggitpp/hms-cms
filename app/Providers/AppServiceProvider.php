<?php

namespace App\Providers;

use App\Models\Setting\Menu;
use App\Models\Setting\Parameter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $listFolder = DB::table("app_moduls")->select(DB::raw("CONCAT(target, '.*') as target"))->pluck("target")->toArray();
        view()->composer($listFolder, function ($view) {
            $parameter = Parameter::pluck('value', 'code')->toArray();
            if (\Auth::check()) {
                $arrURL = explode('/', $this->app->request->getRequestUri());//GET URL
                $modul = $arrURL[1];
                $param = !empty($arrURL[2]) ? explode('?', $arrURL[2])[1] ?? '' : ''; //GET LIST PARAM
                $menu = !empty($arrURL[2]) ? explode('?', $arrURL[2])[0] ?? '' : ''; //GET LIST PARAM
                $access = DB::table('app_user_accesses')
                    ->select('app_user_accesses.name', 'app_user_accesses.id')
                    ->join('app_menus', function ($join) use ($menu) {
                        $join->on('app_user_accesses.menu_id', 'app_menus.id');
                        $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
                        $join->where('app_menus.target', $menu);
                    })
                    ->join('app_moduls', function ($join) use ($arrURL) {
                        $join->on('app_menus.modul_id', 'app_moduls.id');
                        $join->where('app_moduls.target', $arrURL[1]);
                    })
                    ->pluck('app_user_accesses.id', 'app_user_accesses.name')->toArray(); //JOIN TO GET ACCESS
                if (!empty($arrURL[1])) {
                    $getModulId = DB::table('app_moduls')
                        ->where('target', $arrURL[1])
                        ->value('id'); //GET MODUL ID FROM URL
                    $moduls = DB::table('app_moduls')
                        ->select('app_moduls.id', 'app_moduls.name', 'app_moduls.target', 'app_moduls.icon', 'app_moduls.status', 'app_moduls.order',
                            'app_group_moduls.modul_id', 'app_group_moduls.group_id')
                        ->join('app_group_moduls', 'app_moduls.id', '=', 'app_group_moduls.modul_id')
                        ->where('app_group_moduls.group_id', \Auth::user()->group_id)
                        ->where('app_moduls.status', 't')
                        ->orderBy('order')
                        ->get(); // GET LIST MODUL FROM USER GROUP LOGIN
                    $submoduls = DB::table('app_sub_moduls')
                        ->select('app_sub_moduls.name', 'app_sub_moduls.id')
                        ->join('app_menus', function ($join) use ($getModulId) {
                            $join->on('app_sub_moduls.id', 'app_menus.sub_modul_id');
                            $join->where('app_sub_moduls.modul_id', DB::raw($getModulId));
                            $join->where('app_menus.status', 't');
                        })
                        ->join('app_user_accesses', function ($join) {
                            $join->on('app_menus.id', 'app_user_accesses.menu_id');
                            $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
                            $join->where('app_user_accesses.name', 'index');
                            $join->where('app_menus.status', 't');
                        })
                        ->groupBy('app_sub_moduls.id')
                        ->orderBy('app_sub_moduls.order')
                        ->get(); //GET LIST OF SUB MODULS WHO HAVE MENU WITH ACCESS
                    $menus = DB::table('app_menus')
                        ->select('app_menus.id','app_menus.sub_modul_id', 'app_menus.name', 'app_menus.target', 'app_menus.icon')
                        ->join('app_user_accesses', function ($join) {
                            $join->on('app_menus.id', 'app_user_accesses.menu_id');
                            $join->where('app_user_accesses.name', 'index');
                            $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
                            $join->where('app_menus.status', 't');
                            $join->where('app_menus.parent_id', 0);
                        })
                        ->orderBy('order')
                        ->get(); //GET LIST MENU WITH ACCESS
                    $submenus = DB::table('app_menus')
                        ->select('app_menus.parent_id', 'app_menus.name', 'app_menus.target', 'app_menus.icon')
                        ->join('app_user_accesses', function ($join) {
                            $join->on('app_menus.id', 'app_user_accesses.menu_id');
                            $join->where('app_user_accesses.name', 'index');
                            $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
                            $join->where('app_menus.status', 't');
                            $join->where('app_menus.parent_id','!=', 0);
                        })
                        ->get(); //GET LIST MENU WITH ACCESS
                    $menu = DB::table('app_menus')
                        ->select('app_menus.name', 'app_menus.target', 'app_moduls.target as modulTarget', 'app_moduls.name as modulName')
                        ->join('app_moduls', function ($join) use ($modul, $menu)
                        {
                           $join->on('app_moduls.id', 'app_menus.modul_id');
                           $join->where('app_moduls.target', $modul);
                           $join->where('app_menus.target', $menu);
                        })
                        ->get()->first();
                    $view->with('app_moduls', $moduls);
                    $view->with('app_sub_moduls', $submoduls);
                    $view->with('app_menus', $menus);
                    $view->with('app_sub_menus', $submenus);
                    $view->with('arrMenu', $menu);
                    $view->with('parameter', $param);
                    $view->with('access', $access);
                    $view->with('maincolor', '#7367F0');
                    $view->with('arr_parameter', $parameter);
                }
            }
        });
    }
}
