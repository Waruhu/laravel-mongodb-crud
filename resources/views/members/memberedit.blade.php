<!DOCTYPE html>
<html>
<head><title>Edit Book</title>
<link href="/css/lib.css" rel="stylesheet">
</head>
<body>
<h1>Welcome to My Library</h1>
<h2>Edit Data Member</h2>

<hr/>

<form action="{{ route('members.update',['id' =>  $member{'_id'} ]) }}" method="post">
{{ csrf_field() }}
<label for="first_name">First Name</label><input type="text" name="first_name" value="{{ $member{'first_name'} }}">
<label for="last_name">Last Name</label><input type="text" name="last_name" value="{{ isset( $member{'last_name'} ) ?  $member{'last_name'} : ' - ' }}">
<label for="gender">Gender</label><input type="text" name="gender" value="{{ $member{'gender'} }}">
<label for="address">Address</label><input type="text" name="address" value="{{ $member{'address'} }}">
<label for="status">Status</label><input type="text" name="status" value="{{ $member{'status'} }}">
<br/><hr/>

  <input type="button" class="book-action big" value="Cancel" onclick="window.location='{{ route('members.index') }}'"/>
  <input type="reset" class="book-action big" />
  <input type="hidden" name="_method" value="PUT"/>
  <input type="submit" class="book-action big" name="sub" value="Submit"/>

</form>



</body>
</html>