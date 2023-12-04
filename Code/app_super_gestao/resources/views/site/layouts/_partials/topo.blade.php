<div class="topo">

    <div class="logo">
        <img src="{{ asset('img/logo.png') }}"> <!-- O helper asset por padrão sempre busca na pasta public -->
    </div>

    <div class="menu">
        <ul>
            <li><a href="{{ route('site.index') }}">Principal</a></li>
            <li><a href="{{ route('site.sobrenos') }}">Sobre Nós</a></li>
            <li><a href="{{ route('site.contato') }}">Contato</a></li>
        </ul>
    </div>

</div>
