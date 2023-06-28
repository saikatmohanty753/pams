@if(isset($delays) && count($delays) > 0)
@foreach($delays as $delay)
<p>{{ ((Auth::user()->id == $delay->given_by)?'You':getUserName($delay->given_by)).' : '.$delay->reason }}</p>
@endforeach
@else
<p>No reason found</p>
@endif