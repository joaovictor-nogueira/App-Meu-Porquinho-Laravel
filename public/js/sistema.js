document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const categoriaSelect = document.getElementById('categoria');

    // Função para carregar categorias
    function carregarCategorias(tipo) {
        categoriaSelect.innerHTML = '<option selected disabled>Categorias</option>';

        if (tipo) {
            fetch(`/categorias/${tipo}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        option.textContent = categoria.nome;

                        // Seleciona a categoria correta no modo de edição
                        const categoriaId = categoriaSelect.dataset.categoriaId; // Obtém o valor do data-categoria-id
                        if (categoria.id == categoriaId) {
                            option.selected = true;
                        }

                        categoriaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar categorias:', error));
        }
    }

    // Evento de mudança no tipo de operação
    tipoSelect.addEventListener('change', function() {
        carregarCategorias(this.value);
    });

    // Verifica o tipo inicial ao carregar a página
    if (tipoSelect.value) {
        carregarCategorias(tipoSelect.value);
    }
});
