@extends('layouts.app')

@section('content')
<chats-component :user="{{ auth()->user() }}"/>
@endsection
