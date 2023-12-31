@if(isset($produto_detalhe->id))
    <form action="{{ route('produto-detalhe.update', ['produto_detalhe' => $produto_detalhe->id]) }}" method="POST">
    @csrf
    @method('PUT')
@else
    <form action="{{ route('produto-detalhe.store') }}" method="POST">
    @csrf
@endif

        <input type="text" name="produto_id" id="produto_id" value="{{ $produto_detalhe->produto_id ?? old('produto_id') }}" placeholder="ID do produto" class="borda-preta">
        {{ $errors->has('produto_id') ? $errors->first('produto_id') : '' }}

        <input type="text" name="comprimento" id="comprimento" value="{{ $produto_detalhe->comprimento ?? old('comprimento') }}" placeholder="Descrição" class="borda-preta">
        {{ $errors->has('comprimento') ? $errors->first('comprimento') : '' }}

        <input type="text" name="largura" id="largura" value="{{ $produto_detalhe->largura ?? old('largura') }}" placeholder="Largura" class="borda-preta">
        {{ $errors->has('largura') ? $errors->first('largura') : '' }}

        <input type="text" name="altura" id="altura" value="{{ $produto_detalhe->altura ?? old('altura') }}" placeholder="Altura" class="borda-preta">
        {{ $errors->has('altura') ? $errors->first('altura') : '' }}

        <select name="unidade_id" id="unidade_id">

            <option value="">-- Selecione a unidade de medida --</option>

            @foreach($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ ($produto_detalhe->unidade_id ?? old('unidade_id')) == $unidade->id ? 'selected' : '' }} >{{ $unidade->descricao }}</option>
            @endforeach

        </select>
        {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}

        <button type="submit">Cadastrar</button>

    </form>
