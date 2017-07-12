<!DOCTYPE html>
<html>
<head>
<title>Member Index</title>
<link href="/css/lib.css" rel="stylesheet">
</head>
<body>
<h1>Welcome to Library</h1>
<h2>Index of Members</h2>
<table>

<th>No</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Address</th><th>Status</th><th>Action</th>
<tbody>
@foreach ($members as $i => $member)
		<tr>
			<td>{{ $i+1 }}</td>
			<td>{{ $member{'first_name'} }}</td>
			<td>{{ isset( $member{'last_name'} ) ?  $member{'last_name'} : ' - ' }}</td>
 			<td>{{ $member{'gender'} }}</td>
 			<td>{{ $member{'address'} }}</td>
             <td>{{ $member{'status'} }}</td>
 			<td><form action="members/{{ $member{'_id'} }}" method="POST">
 				{{ csrf_field() }}
 				<input type="button" class="member-action" value="View" onclick="window.location='{{ route('members.show', ['book' => $member{'_id'}]) }}'"> &nbsp;
 				<input type="button" class="member-action" value="Edit" onclick="window.location='{{ route('members.edit', ['book' => $member{'_id'}]) }}'"> &nbsp;
				<input type="hidden" class="member-action" name="_method" value="DELETE"/>
				<input type="submit" class="member-action" name="del" value="Delete"/>
				</form>
			</td>

		</tr>
@endforeach
</tbody>
</table>
<hr/>

<input type="button" class="book-action big" value="Add a Member" onclick="window.location='{{ route('members.create') }}'">
</body>
</html>