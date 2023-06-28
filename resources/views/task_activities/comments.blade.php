@if(!empty($comments) && count($comments) > 0)
@foreach($comments as $comment)
<p>{{ ((Auth::user()->id == $comment->created_by)?'You':getUserName($comment->created_by)).' : '.$comment->comment }}</p>
@endforeach
@endif