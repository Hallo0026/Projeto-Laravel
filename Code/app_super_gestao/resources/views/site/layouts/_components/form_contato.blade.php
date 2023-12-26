{{ $slot }} <!-- Recebe o conteúdo que foi passado dentro da tag components -->

<form action="{{ route('site.contato') }}" method="POST">

    @csrf <!-- Token necessário pelo Laravel para enviar requisições POST -->

    <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Nome" class="{{ $classe }}">
    @if($errors->has('nome'))
        {{ $errors->first() }}
    @endif
    <br>

    <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="Telefone" class="{{ $classe }}">
    {{ $errors->has('telefone') ? $errors->first('telefone') : '' }}
    <br>

    <input type="text" name="email" value="{{ old('email') }}" placeholder="E-mail" class="{{ $classe }}">
    {{ $errors->has('email') ? $errors->first('email') : '' }}
    <br>

    <select name="motivo_contato" class="{{ $classe }}">

        <option value="">Qual o motivo do contato?</option>

        @foreach($motivo_contatos as $key => $motivo_contato)

            <option value="{{ $motivo_contato->id }}" {{ old('motivo_contatos') == $motivo_contato->id ? 'selected' : '' }}>{{ $motivo_contato->motivo_contato }}</option>

        @endforeach

    </select>
    {{ $errors->has('motivo_contato') ? $errors->first('motivo_contato') : '' }}
    <br>

    <textarea name="mensagem" class="{{ $classe }}">{{ (old('mensagem') != '') ? old('mensagem') : 'Preencha aqui a sua mensagem' }}
    </textarea>
    {{ $errors->has('mensagem') ? $errors->first('mensagem') : '' }}
    <br>

    <button type="submit" class="{{ $classe }}">ENVIAR</button>
</form>

<!--
@if($errors->any())

    <div style="position: absolute; top: 0px; left: 0px; width: 100%; text-align: center; background-color: darkred; color: white">

        @foreach($errors->all() as $erro)
            {{ $erro }} <br>
        @endforeach

    </div>

@endif
-->
