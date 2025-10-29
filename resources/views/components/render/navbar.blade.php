<nav class="navbar navbar-expand-lg bg-body-tertiary mb-2">
    <div class="container-fluid">
    	<a class="navbar-brand" href="#">Applicazione di test</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          	<span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach($selectedNode->children as $item)
                @if(Auth::user()->canRead($item))
                <li class="nav-item">
                	<a class="nav-link" href="javascript:void(0)" onclick="createRefresh({{ $item->html->ref->id }}, '', 'targetMenuContainer')">{{ $item->html->label }}</a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
	</div>
</nav>
<div id="targetMenuContainer">

</div>
