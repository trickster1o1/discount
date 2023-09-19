<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreMenuRequest;
use App\Http\Requests\Admin\UpdateMenuRequest;
use App\Models\Admin\Menu;
use App\Models\Admin\Permission;
use Illuminate\Http\Request;
use Toastr;

class MenuController extends Controller
{
    private $menuCode = 'ADMINMENU';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize($this->menuCode, 'INDEX');
        $menus = Menu::with('subMenus')->where('status', '!=', 'deleted')->orderBy('position')->get();
        return view('Admin.menus.index', compact('menus') + array('menucode' => $this->menuCode));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize($this->menuCode, 'CREATE');
        return view('Admin.menus.create', array('menucode' => $this->menuCode));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        authorize($this->menuCode, 'CREATE');
        $validated = $request->validated();
        Menu::create($validated);
        Toastr::success('Menu Added Successfully', 'Sucess');
        return redirect()->route('menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        authorize($this->menuCode, 'SHOW');
        return view('Admin.menus.show', [
            'menu' => $menu->load('permissions')
        ]);
    }

    public function assign(Request $request, Menu $menu)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validate([
            'permissions.*' => 'nullable|in:' . permissions()->pluck('id')->implode(',')
        ]);
        if (!isset($validated['permissions'])) {
            $menu->load('permissions')->permissions()->detach();
            return back();
        }
        $permissions = Permission::whereIn('id', $validated['permissions'])->get();
        $menu->permissions()->sync($permissions);
        Toastr::success('Permission Assigned Successfully', 'Sucess');
        return redirect()->route('menus.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        authorize($this->menuCode, 'UPDATE');
        return view('Admin.menus.edit', compact('menu') + array('menucode' => $this->menuCode));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        authorize($this->menuCode, 'UPDATE');
        $validated = $request->validated();
        $menu->update($validated);
        Toastr::success('Menu Updated Successfully', 'Sucess');
        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        authorize($this->menuCode, 'DESTROY');
        $menu = Menu::where('id', '=', $menu->id);
        $menu->update(['status' => 'deleted']);
        Toastr::success('Menu Deleted Successfully', 'Sucess');
        return redirect()->route('menus.index');
    }
}
