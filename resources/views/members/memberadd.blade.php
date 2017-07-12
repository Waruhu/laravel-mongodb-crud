<!DOCTYPE html>
<html>
<head><title>Book Index</title>
<link href="/css/lib.css" rel="stylesheet">
</head>
<body>
<h1>Welcome to My Library</h1>
<h2>Add Member</h2>

<hr/>

<form action="{{ route('members.store') }}" method="post">

 {{ csrf_field() }} 

  <label for="first_name">First Name</label><input type="text" name="first_name" value=""><br>
  <label for="last_name">Last Name</label><input type="text" name="last_name" value=""><br>
  <label for="gender">Gender</label><input type="text" name="gender" value=""><br>
  <label for="address">Address</label><input type="text" name="address" value=""><br>
  <label for="status">Status</label><input type="text" name="status" value=""><br>
  <br/><hr/>

  <input type="button" class="book-action big" value="Cancel" onclick="window.location='{{ route('members.index') }}'">
  <input type="reset" class="book-action big">
  <input type="submit" class="book-action big" value="Submit">

</form>


</body>
</html>
