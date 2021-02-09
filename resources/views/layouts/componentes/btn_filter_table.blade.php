@php
    if(!isset($tabla))$tabla = '';
    if(!isset($class_btn))$class_btn = 'btn-primary';
    if(!isset($align_menu))$align_menu = 'dropdown-menu-right';
@endphp
<div class="btn-group">
    <button class="btn {{$class_btn}} dropdown-toggle btn-filter-colums-table" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-tabla="{{$tabla}}">
        <i class="fas fa-columns"></i>
    </button>

    <div class="dropdown-menu {{$align_menu}} padding-20">
    </div>
</div>