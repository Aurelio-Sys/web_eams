<?php

namespace App\Http\Controllers\favMenu;

use App\Http\Controllers\Controller;
use App\Models\favMenu\FavMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavMenuController extends Controller
{
    public function index(Request $request)
    {
        $favMenus = FavMenu::get();

        return view('favmenu.index', compact('favMenus'));
    }

    public function store(Request $request)
    {
        $action = $request->favAction;

        $user_id = Auth::user()->id;
        $menuName = $request->menu_name;
        $menuUrl = $request->menu_url;
        $menuIcon = $request->menu_icon;

        DB::beginTransaction();

        try {
            if ($action == 'add') {
                $favMenu = new FavMenu();
                $favMenu->fm_user_id = $user_id;
                $favMenu->fm_menu_name = $menuName;
                $favMenu->fm_menu_url = $menuUrl;
                $favMenu->fm_menu_icon = $menuIcon;
                $favMenu->save();

                toast('Successfully added fav. menu');
            } else {
                $favMenu = FavMenu::where('id', $request->d_id)->first();
                if ($favMenu) {
                    $favMenu->delete();
                }
            }

            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err);
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $favMenu = FavMenu::where('id', $request->d_id)->first();

            if ($favMenu) {
                $favMenu->delete();
            }

            DB::commit();
            toast('Successfully deleted a fav. menu');
        } catch (\Exception $err) {
            DB::rollBack();
            toast('failed deleted a fav. menu');
        }
        
        return redirect()->back();
    }
}
