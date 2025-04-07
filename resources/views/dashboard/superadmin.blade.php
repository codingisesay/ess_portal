@extends('superadmin_view/superadmin_layout')  <!-- Extending the layout file -->

@section('content')  <!-- Defining the content section -->
<div class="w3-main" style="margin-inline: auto;">

<div class="w3-twothird">
  <h5>Feeds</h5>
  <table class="w3-table w3-bordered">
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Points</th>
</tr>
<tr>
<td>Jill</td>
<td>Smith</td>
<td>50</td>
</tr>
<tr>
<td>Eve</td>
<td>Jackson</td>
<td>94</td>
</tr>
<tr>
<td>Adam</td>
<td>Johnson</td>
<td>67</td>
</tr>
</table>
</div>
</div>
</div>
<hr>
@endsection