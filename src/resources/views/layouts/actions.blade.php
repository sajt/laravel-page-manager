<a class="btn btn-warning btn-sm" href="/page-manager/layouts/{{{ $item->id }}}/edit">
    <i class='fa fa-pencil'></i>
</a>

<a class="btn btn-warning btn-sm" href="/page-manager/layouts/{{{ $item->id }}}/sections">
  <i class='fa fa-list'></i>
</a>

<form method="POST" action="/page-manager/layouts/{{{ $item->id }}}" style="display:inline">
    <input name="_method" type="hidden" value="DELETE">
    @csrf
    <button  class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
</form>
