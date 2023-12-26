{{ $slot }} <!-- Recebe o conteúdo que foi passado dentro da tag components -->

<form action="{{ route('site.contato') }}" method="POST">

    @csrf <!-- Token necessário pelo Laravel para enviar requisições POST -->

    <input type="text" name="nome" placeholder="Nome" class="{{ $classe }}">
    <br>
    <input type="text" name="telefone" placeholder="Telefone" class="{{ $classe }}">
    <br>
    <input type="text" name="email" placeholder="E-mail" class="{{ $classe }}">
    <br>
    <select name="motivo_contato" class="{{ $classe }}">
        <option value="">Qual o motivo do contato?</option>
        <option value="1">Dúvida</option>
        <option value="2">Elogio</option>
        <option value="3">Reclamação</option>
    </select>
    <br>
    <textarea name="mensagem" class="{{ $classe }}">Preencha aqui a sua mensagem</textarea>
    <br>
    <button type="submit" class="{{ $classe }}">ENVIAR</button>
</form>

<div style="position: absolute; top: 0px; left: 0px; width: 100%; background-color: darkred;">
    <pre>
        {{ print_r($errors) }}
    </pre>
</div>
