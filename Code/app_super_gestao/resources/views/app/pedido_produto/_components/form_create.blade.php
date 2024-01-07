<form action="{{ route('pedido-produto.store', ['pedido' => $pedido->id]) }}" method="POST">

    @csrf

    <select name="produto_id" id="produto_id">

        <option value="">-- Selecione um Produto --</option>

        @foreach($produtos as $produto)
            <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }} >{{ $produto->nome }}</option>
        @endforeach

    </select>

    {{ $errors->has('produto_id') ? $errors->first('produto_id') : '' }}

    <button type="submit">Cadastrar</button>

</form>
