@extends('page-manager::main')
@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">

          <div class="card-header {{{ isset($card['header']['tabs']) ? 'card-header-tabs' : '' }}} card-header-primary">
            	<div class="card-title ">
                <h4>
                  <span>{{{ $card['header']['caption'] }}}</span>
                  @if(isset($card['header']['actions']))
                    @foreach($card['header']['actions'] as $action)
                    <a href="{{{ $action['url'] }}}" class="pull-right btn btn-sm btn-info">
                      {{{ $action['caption'] }}}
                    </a>
                    @endforeach
                  @endif
                </h4>
              </div>
              @if(isset($card['header']['tabs']))
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    @foreach($card['header']['tabs'] as $tabKey => $tab)
                    <li class="nav-item">
                      @if(isset($tab['redirect']))
                      <a class="nav-link {{{ \Request::path() == $tab['url'] ? 'active' : '' }}}" href="{{{ $tab['url'] }}}">
                      @else
                      <a class="nav-link {{{ $tabKey == 0 ? 'active' : '' }}}" href="#{{{ $tab['url'] }}}" data-toggle="tab">
                      @endif
                        <i class="material-icons">language</i>{{{ $tab['caption'] }}}
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
              @endif
          </div>

          <div class="card-body">
              {!! $card['body'] !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection