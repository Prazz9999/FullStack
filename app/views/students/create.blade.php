@extends('layouts.master')


@section('content')
<form method="post" action="?page=store">
Name: <input name="name"><br><br>
Email: <input name="email"><br><br>
Course: <input name="course"><br><br>
<button>Add</button>
</form>
@endsection