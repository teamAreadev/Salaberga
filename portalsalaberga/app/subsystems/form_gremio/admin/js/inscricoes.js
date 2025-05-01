document.addEventListener('DOMContentLoaded', function() {
    const inscricoesContainer = document.getElementById('inscricoes-container');
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('status-filter');
    const refreshBtn = document.getElementById('refresh-btn');
    let inscricoes = [];

    // Função para carregar todas as inscrições
    async function carregarInscricoes() {
        try {
            const response = await fetch('../controllers/AdminController.php?action=listar-inscricoes');
            const data = await response.json();
            
            if (data.success) {
                inscricoes = data.inscricoes;
                renderizarInscricoes(inscricoes);
                atualizarContadores(inscricoes);
            } else {
                throw new Error(data.message || 'Erro ao carregar inscrições');
            }
        } catch (error) {
            console.error('Erro:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao carregar inscrições'
            });
        }
    }

    // Função para renderizar as inscrições
    function renderizarInscricoes(inscricoes) {
        inscricoesContainer.innerHTML = inscricoes.map(inscricao => `
            <div class="card bg-white rounded-lg border border-gray-100 p-6 mb-4" data-inscricao-id="${inscricao.inscricao_id}">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <div class="mb-3 md:mb-0">
                        <h3 class="text-lg font-semibold text-gray-800">${inscricao.nome}</h3>
                        <p class="text-gray-500 text-sm">
                            <span class="font-medium">Modalidade:</span> ${inscricao.modalidade.charAt(0).toUpperCase() + inscricao.modalidade.slice(1)}
                            <span class="mx-2">•</span>
                            <span class="font-medium">Categoria:</span> ${inscricao.categoria}
                            <span class="mx-2">•</span>
                            <span class="font-medium">Tipo:</span> ${inscricao.tipo_inscricao.charAt(0).toUpperCase() + inscricao.tipo_inscricao.slice(1)}
                            ${inscricao.nome_equipe ? `<span class="mx-2">•</span><span class="font-medium">Equipe:</span> ${inscricao.nome_equipe}` : ''}
                        </p>
                        <p class="text-gray-500 text-sm">
                            <span class="font-medium">Turma:</span> ${inscricao.ano}º ${inscricao.turma}
                            <span class="mx-2">•</span>
                            <span class="font-medium">Email:</span> ${inscricao.email}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="status-badge ${getStatusClass(inscricao.status)}">
                            ${inscricao.status.charAt(0).toUpperCase() + inscricao.status.slice(1)}
                        </span>
                        <div class="flex space-x-2">
                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'aprovado')" 
                                    class="btn-action bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded-md" 
                                    title="Aprovar Inscrição">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'reprovado')" 
                                    class="btn-action bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-md" 
                                    title="Reprovar Inscrição">
                                <i class="fas fa-times"></i>
                            </button>
                            <button type="button" onclick="atualizarStatusInscricao(${inscricao.inscricao_id}, 'pendente')" 
                                    class="btn-action bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-2 rounded-md" 
                                    title="Marcar como Pendente">
                                <i class="fas fa-clock"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('') || '<p class="text-center text-gray-500 py-8">Nenhuma inscrição encontrada</p>';
    }

    // Função para atualizar contadores
    function atualizarContadores(inscricoes) {
        const total = inscricoes.length;
        const pendentes = inscricoes.filter(i => i.status === 'pendente').length;
        const aprovadas = inscricoes.filter(i => i.status === 'aprovado').length;
        const reprovadas = inscricoes.filter(i => i.status === 'reprovado').length;

        document.getElementById('total-inscricoes').textContent = total;
        document.getElementById('inscricoes-pendentes').textContent = pendentes;
        document.getElementById('inscricoes-aprovadas').textContent = aprovadas;
        document.getElementById('inscricoes-reprovadas').textContent = reprovadas;
    }

    // Função para filtrar inscrições
    function filtrarInscricoes(termo, status = 'todos') {
        const termoLower = termo.toLowerCase();
        const inscricoesFiltradas = inscricoes.filter(inscricao => {
            const matchTermo = inscricao.nome.toLowerCase().includes(termoLower) ||
                inscricao.modalidade.toLowerCase().includes(termoLower) ||
                inscricao.categoria.toLowerCase().includes(termoLower) ||
                (inscricao.nome_equipe && inscricao.nome_equipe.toLowerCase().includes(termoLower)) ||
                inscricao.email.toLowerCase().includes(termoLower);
            
            const matchStatus = status === 'todos' || inscricao.status === status;
            
            return matchTermo && matchStatus;
        });
        renderizarInscricoes(inscricoesFiltradas);
    }

    // Função para atualizar status de uma inscrição
    window.atualizarStatusInscricao = async function(inscricaoId, status) {
        try {
            const formData = new FormData();
            formData.append('action', 'atualizar-status');
            formData.append('inscricao_id', inscricaoId);
            formData.append('status', status);

            const response = await fetch('../controllers/AdminController.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                await carregarInscricoes();
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                throw new Error(data.message || 'Erro ao atualizar status');
            }
        } catch (error) {
            console.error('Erro:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: error.message || 'Erro ao atualizar status da inscrição'
            });
        }
    };

    // Função para obter classe CSS do status
    function getStatusClass(status) {
        return {
            'pendente': 'bg-yellow-100 text-yellow-800',
            'aprovado': 'bg-green-100 text-green-800',
            'reprovado': 'bg-red-100 text-red-800'
        }[status] || 'bg-gray-100 text-gray-800';
    }

    // Event Listeners
    searchInput.addEventListener('input', (e) => filtrarInscricoes(e.target.value, statusFilter.value));
    statusFilter.addEventListener('change', (e) => filtrarInscricoes(searchInput.value, e.target.value));
    refreshBtn.addEventListener('click', () => {
        searchInput.value = '';
        statusFilter.value = 'todos';
        carregarInscricoes();
    });

    // Carregar inscrições inicialmente
    carregarInscricoes();
}); 