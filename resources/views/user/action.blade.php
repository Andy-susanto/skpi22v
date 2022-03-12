<a class='btn btn-sm btn-info text-white' href="{{route('user.edit',$q->id)}}"><i class='fa fa-edit'></i> Edit</a> |
<a class='btn btn-sm btn-danger btn-sm' onclick="confirmation('{{$q->id}}')"><i class='fa fa-trash'></i> Delete</a>
<form action="{{route('user.destroy',$q->id)}}" method='post' id="{{$q->id}}">
    @csrf
    @method('delete')
</form>
