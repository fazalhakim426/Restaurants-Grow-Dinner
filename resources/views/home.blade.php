@extends('layouts.app')
@php
    if(isset($id) && $component == "templates") {
        $component = (isset($group) ? "{$group}-{$component}-" : "").$id;
        $title = __("{$id}" );
    } else {
        $component = (isset($group) ? "{$group}-" : "").$component;
        $title = __("{$component}" );
    }
    if(strpos($title, 'page-titles.') !== false) {
        $title = "404 Page Not Found";
    }
@endphp
@section('title')
   {{ $title }} | {{ config('app.name', 'Restaurants') }}
@endsection
@section('content')
<dynamic-component component="{{ $component }}" access_token="{{ $access_token }}" id="{{ $id ?? "" }}" />
@endsection
