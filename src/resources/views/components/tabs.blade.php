<div class="tab-content">
  @foreach($tabs as $tabKey => $tab)
  <div class="tab-pane {{{ $tabKey == 0 ? 'active' : '' }}}" id="{{{ $tab['url'] }}}">
    {!! $tab['content'] !!}
  </div>
  @endforeach
</div>