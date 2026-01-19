@extends('layouts.master')


@section('content')
<a href="?page=create">Add Student</a>


<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Action</th></tr>
@foreach($students as $s)
<tr>
<td>{{ $s['id'] }}</td>
<td>{{ $s['name'] }}</td>
<td>{{ $s['email'] }}</td>
<td>{{ $s['course'] }}</td>
<td>
<a href="?page=edit&id={{ $s['id'] }}">Edit</a>
<a href="?page=delete&id={{ $s['id'] }}">Delete</a>
</td>
</tr>
@endforeach
</table>
@endsection