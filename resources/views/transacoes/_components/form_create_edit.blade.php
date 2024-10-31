@if (isset($transacao->id))
    <form action="{{ route('transacoes.update', ['transacao' => $transacao->id]) }}" id="TransacaoForm" method="post">
        @csrf
        @method('PUT')
@else
    <form action="{{ route('transacoes.store') }}" id="TransacaoForm" method="post">
        @csrf
@endif




<div class="mb-3">
    <label class="form-label">Valor</label>
    <input type="text" class="form-control" name="valor" id="valor" placeholder="0,00"
        value="{{ $transacao->valor ?? old('valor') }}">
</div>
<p class="text-center" style="color: red">
    {{ $errors->has('valor') ? $errors->first('valor') : '' }}</p>




 <!-- Campo Tipo de Transação -->
 <div class="form-group mt-3">
    <select class="form-control" name="tipo" id="tipo">
        <option selected disabled>Operação</option>
        <option value="1" {{ (old('tipo') ?? $transacao->tipo ?? '') == 1 ? 'selected' : '' }}>Entrada</option>
        <option value="2" {{ (old('tipo') ?? $transacao->tipo ?? '') == 2 ? 'selected' : '' }}>Saída</option>
    </select>
    <p class="text-danger">{{ $errors->first('tipo') }}</p>
</div>

<div class="mt-3 form-group">
    <select class="form-control" name="categoria" id="categoria" data-categoria-id="{{ $transacao->categoria_id ?? 'null' }}">
        <option selected disabled>Categorias</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ old('categoria', $transacao->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nome }}
            </option>
        @endforeach
    </select>
    <br>
    <p class="text-center mt-0" style="color: red">
        {{ $errors->has('categoria') ? $errors->first('categoria') : '' }} </p>
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
    <input type="text" class="form-control" id="descricao" name="descricao"
        value="{{ $transacao->descricao ?? old('descricao') }}">
    <p class="text-center mt-0" style="color: red">
        {{ $errors->has('descricao') ? $errors->first('descricao') : '' }} </p>


    <div class="text-center">
        <button type="submit" class="btn btn-primary mt-3" id="submitButton">
            @if (isset($transacao->id))
                Atualizar
            @else
                Cadastrar
            @endif
        </button>
    </div>


    </form>


    <script>
        function formatarValor(valor) {
            // Remove todos os caracteres que não sejam números
            valor = valor.replace(/\D/g, '');
    
            // Adiciona a vírgula antes dos últimos dois dígitos para representar os centavos
            valor = (valor / 100).toFixed(2) + '';
    
            // Separa a parte inteira da decimal
            let partes = valor.split('.');
    
            // Adiciona pontos de milhar na parte inteira
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
            // Junta parte inteira e decimal com vírgula
            return partes.join(',');
        }
    
        document.getElementById('valor').addEventListener('input', function(e) {
            // Obtém o valor atual do input
            let valorInput = e.target.value;
    
            // Formata o valor e atribui de volta ao input
            e.target.value = formatarValor(valorInput);
        });
    
        // Adiciona um evento para garantir que o valor enviado esteja em formato correto
        document.querySelector('form').addEventListener('submit', function(e) {
            let valorInput = document.getElementById('valor').value;
    
            // Remove a formatação antes de enviar para o servidor
            let valorSemFormatacao = valorInput.replace(/\./g, '').replace(',', '.');
    
            // Atualiza o valor do input com o formato correto
            document.getElementById('valor').value = valorSemFormatacao;
        });
    </script>
    

    <script>
        document.getElementById('TransacaoForm').addEventListener('submit', function(e) {
            // Previne o envio repetido
            const submitButton = document.getElementById('submitButton');
            const loadingOverlay = document.getElementById('loadingOverlay');

            submitButton.disabled = true; // Desativa o botão
            loadingOverlay.style.display = 'flex'; // Mostra o overlay com o spinner centralizado
        });
    </script>
