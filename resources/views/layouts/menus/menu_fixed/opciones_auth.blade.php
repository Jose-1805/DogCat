@if(Auth::user()->rol->superadministrador == "si")
    @include('layouts.menus.menu_fixed.opciones_superadministrador')
@else
    @include('layouts.menus.menu_fixed.opciones_user')
@endif