@extends('layouts.master')


@section('content')
<form method="post" action="?page=update&id={{ $student['id'] }}">
Name: <input name="name" value="{{ $student['name'] }}"><br><br>
Email: <input name="email" value="{{ $student['email'] }}"><br><br>
Course: <input name="course" value="{{ $student['course'] }}"><br><br>
<button>Update</button>
</form>
@endsection