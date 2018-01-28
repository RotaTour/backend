<?php 
    if(!isset($localClass)){
        $localClass = "place";
    }
    if(!isset($localId)){
        $localId = '1';
    }
?>
<div>
    <form action="{{route('comment.add')}}" method="post" id="commentForm" onsubmit="addComment()" role="form" >
    {{ csrf_field() }}
    <input type="hidden" name="localId" value="{{$localId}}">
    <input type="hidden" name="localClass" value="{{$localClass}}">
    <div class="form-group">
        <textarea name="body" id="body" rows="2"  class="form-control" placeholder="Faça um comentário"></textarea>
        <div class="m-t-20"></div>
        <input type="submit" value="Comentar" class="btn btn-primary btn-sm">
    </div>
</div>
<script type="text/javascript">
var localId = {{$localId}};
var localClass = "{{$localClass}}";
var comment = "";

function getComment()
{
    comment = document.getElementById('body').value;
    console.log("Os valores são: \nId: "+localId+"\nComment: "+comment);
    document.getElementById('commentInput').value = "";
}
</script>