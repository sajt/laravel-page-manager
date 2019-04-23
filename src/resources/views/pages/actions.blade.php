<a class="btn btn-warning btn-sm" href="/page-manager/pages/{{{ $item->id }}}/edit">
    <i class='fa fa-pencil'></i>
</a>

<form method="POST" action="/page-manager/pages/{{{ $item->id }}}" style="display:inline">
    <input name="_method" type="hidden" value="DELETE">
    @csrf
    <button  class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
</form>
