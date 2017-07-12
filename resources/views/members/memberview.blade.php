<!DOCTYPE html>
<html>
<head>
<title>View Member</title>
<link href="/css/lib.css" rel="stylesheet">
</head>
<body>
<h1>{{ $member{'first_name'} $member{'last_name'} }} </h1>
<p>{{ $member{'gender'} }}</p>
<p>{{ $member{'address'} }}</p>
<p>{{ $member{'status'} }}</p>

<br/><hr/>

  <input type="button" class="book-action big" value="Return" onclick="window.location='{{ route('members.index') }}'">
</body>
</html>