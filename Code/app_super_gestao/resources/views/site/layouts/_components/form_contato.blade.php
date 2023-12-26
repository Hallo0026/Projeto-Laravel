{{ $slot }} <!-- Recebe o conteúdo que foi passado dentro da tag components -->

<form action="{{ route('site.contato') }}" method="POST">

    @csrf <!-- Token necessário pelo Laravel para enviar requisições POST -->

    <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Nome" class="{{ $classe }}">
    <br>
    <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="Telefone" class="{{ $classe }}">
    <br>
    <input type="text" name="email" value="{{ old('email') }}" placeholder="E-mail" class="{{ $classe }}">
    <br>
    <select name="motivo_contatos_id" class="{{ $classe }}">

        <option value="">Qual o motivo do contato?</option>

        @foreach($motivo_contatos as $key => $motivo_contato)

            <option value="{{ $motivo_contato->motivo_contato }}" {{ old('motivo_contatos_id') == $motivo_contato->motivo_contato ? 'selected' : '' }}>{{ $motivo_contato->motivo_contato }}</option>

        @endforeach

    </select>
    <br>
    <textarea name="mensagem" class="{{ $classe }}">{{ (old('mensagem') != '') ? old('mensagem') : 'Preencha aqui a sua mensagem' }}
    </textarea>
    <br>
    <button type="submit" class="{{ $classe }}">ENVIAR</button>
</form>

<div style="position: absolute; top: 0px; left: 0px; width: 100%; background-color: darkred;">
    <pre>
        {{ print_r($errors) }}
    </pre>
</div>
