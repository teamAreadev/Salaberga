
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerador de QR Code para Biblioteca</title>
    <!-- Carrega Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Carrega jsPDF via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<style>.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.toast {
    background: white;
    border-radius: 8px;
    padding: 16px 24px;
    margin-bottom: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 300px;
    max-width: 400px;
    animation: slideIn 0.3s ease-out forwards;
    transition: all 0.3s ease;
}

.toast.removing {
    animation: slideOut 0.3s ease-out forwards;
}

.toast-icon {
    font-size: 20px;
}

.toast-message {
    color: #333;
    font-size: 14px;
    flex-grow: 1;
}

.toast-close {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
    font-size: 18px;
}

.toast-close:hover {
    opacity: 1;
}

/* Toast types */
.toast.success {
    border-left: 4px solid #4caf50;
}

.toast.error {
    border-left: 4px solid #f44336;
}

.toast.info {
    border-left: 4px solid #2196f3;
}

.toast.warning {
    border-left: 4px solid #ff9800;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
.history-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 8px;
}

.history-header h3 {
    margin: 0;
    padding-right: 16px;
}

.delete-item-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 4px 8px;
    font-size: 20px;
    line-height: 1;
    border-radius: 4px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-item-btn:hover {
    background-color: #dc3545;
    color: white;
}

.delete-icon {
    display: block;
    transform: scale(1.2);
}

.history-item {
    transition: all 0.3s ease;
}

.history-content {
    flex: 1;
    padding-right: 16px;
}
</style>
<body class="bg-green-700">
    <div class="container mx-auto p-4 sm:p-6 md:p-8 max-w-4xl min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl p-4 sm:p-6 md:p-8 border border-gray-100 w-full">
            <!-- Cabeçalho -->
            <div class="text-center mb-6 md:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Gerador de QR Code</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-2">Sistema de Biblioteca</p>
                <div class="w-16 sm:w-20 h-1 bg-green-500 mx-auto mt-3 sm:mt-4 rounded-full"></div>
            </div>

            <div class="space-y-4 sm:space-y-6">
                <!-- Título da seção -->
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-3 sm:mb-4 flex items-center gap-2">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Informações do Livro
                </h2>

                <!-- Campos de entrada -->
                <div class="space-y-3 sm:space-y-4">
                    <!-- Título do Livro -->
                    <div class="group">
                        <label for="book-title" class="block text-sm font-medium text-gray-700 mb-1">Título do Livro</label>
                        <div class="relative">
                            <input type="text" id="book-title" placeholder="Ex: Dom Casmurro" 
                                   class="w-full px-4 py-2 pl-10 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"/>
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Autor -->
                    <div class="group">
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Autor</label>
                        <div class="relative">
                            <input type="text" id="author" placeholder="Ex: Machado de Assis" 
                                   class="w-full px-4 py-2 pl-10 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"/>
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Gênero -->
                    <div class="group">
                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                        <div class="relative">
                            <input type="text" id="genre" placeholder="Ex: Romance" 
                                   class="w-full px-4 py-2 pl-10 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"/>
                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <div class="group">
                        <label for="book-quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                        <div class="flex items-center gap-2">
                            <button class="p-1.5 sm:p-2 bg-gray-100 rounded-lg border border-gray-300 hover:bg-gray-200 transition-colors" onclick="decrementQuantity()">
                                <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" id="book-quantity" min="1" value="1" 
                                   class="w-16 sm:w-20 px-2 sm:px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-green-500 focus:border-green-500"/>
                            <button class="p-1.5 sm:p-2 bg-gray-100 rounded-lg border border-gray-300 hover:bg-gray-200 transition-colors" onclick="incrementQuantity()">
                                <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botão Gerar QR Code -->
                <button onclick="generateSingleQrCode()" 
                        class="w-full bg-green-600 text-white py-2.5 sm:py-3 px-4 sm:px-6 text-sm sm:text-base rounded-lg hover:bg-green-700 transition-all duration-300 flex items-center justify-center gap-2 group">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Gerar QR Code
                </button>
            </div>

            <!-- Histórico -->
            <div class="mt-6 sm:mt-8">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-700 mb-3 sm:mb-4 flex items-center gap-2">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Histórico de Geração
                </h2>
                <div id="history-container" class="space-y-3 sm:space-y-4 max-h-48 sm:max-h-60 overflow-y-auto rounded-lg bg-gray-50 p-3 sm:p-4"></div>
            </div>

            <!-- Botão Relatório Final -->
            <div class="mt-6 sm:mt-8">
                <button id="generate-report-btn" onclick="generateFinalReport()" 
                        class="w-full bg-green-600 text-white py-2.5 sm:py-3 px-4 sm:px-6 text-sm sm:text-base rounded-lg hover:bg-green-700 transition-all duration-300 flex items-center justify-center gap-2 group hidden">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Gerar Relatório Final em PDF
                </button>
            </div>
        </div>
    </div>

    <script>
const CONFIG = {
    qrCodeSize: 80,
    pdfConfig: {
        qrSize: 20,          
        margin: 15,          
        spacing: 5,          
        cols: 5,             
        rows: 10,            
        titleHeight: 10,     
        fontSize: 8          
    },
    maxHistory: 50,
    toastDuration: 5000
};

let history = {};

function saveToLocalStorage() {
    try {
        const historyEntries = Object.entries(history);
        if (historyEntries.length > CONFIG.maxHistory) {
            const sortedEntries = historyEntries.sort(([, a], [, b]) => 
                new Date(b.timestamp) - new Date(a.timestamp)
            );
            history = Object.fromEntries(sortedEntries.slice(0, CONFIG.maxHistory));
        }
        
        localStorage.setItem('qrCodeHistory', JSON.stringify(history));
    } catch (error) {
        showToast('Erro ao salvar no histórico local', 'error');
        console.error('Erro ao salvar no localStorage:', error);
    }
}

function loadFromLocalStorage() {
    try {
        const savedHistory = localStorage.getItem('qrCodeHistory');
        if (savedHistory) {
            history = JSON.parse(savedHistory);
            return true;
        }
    } catch (error) {
        showToast('Erro ao carregar histórico local', 'error');
        console.error('Erro ao carregar do localStorage:', error);
    }
    return false;
}

function showToast(message, type = 'info') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    const icons = {
        success: '✓',
        error: '✕',
        info: 'ℹ',
        warning: '⚠'
    };

    toast.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <span class="toast-message">${message}</span>
        <span class="toast-close">×</span>
    `;

    container.appendChild(toast);

    const closeButton = toast.querySelector('.toast-close');
    closeButton.addEventListener('click', () => removeToast(toast));

    setTimeout(() => removeToast(toast), CONFIG.toastDuration);
}

function removeToast(toast) {
    if (!toast.classList.contains('removing')) {
        toast.classList.add('removing');
        setTimeout(() => {
            toast.remove();
            const container = document.querySelector('.toast-container');
            if (container && !container.hasChildNodes()) {
                container.remove();
            }
        }, 300);
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

async function generateQRCodeUrl(data) {
    const url = `https://api.qrserver.com/v1/create-qr-code/?size=${CONFIG.qrCodeSize}x${CONFIG.qrCodeSize}&data=${encodeURIComponent(data)}`;
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro ao gerar QR Code');
        return url;
    } catch (error) {
        console.error('Erro ao gerar QR Code:', error);
        return 'caminho/para/qrcode/fallback.png';
    }
}

window.incrementQuantity = function() {
    const quantityInput = document.getElementById("book-quantity");
    let value = parseInt(quantityInput.value) || 1;
    quantityInput.value = value + 1;
};

window.decrementQuantity = function() {
    const quantityInput = document.getElementById("book-quantity");
    let value = parseInt(quantityInput.value) || 1;
    if (value > 1) {
        quantityInput.value = value - 1;
    }
};

window.deleteHistoryItem = function(title) {
    if (confirm(`Deseja remover "${title}" do histórico?`)) {
        delete history[title];
        saveToLocalStorage();
        
        const historyContainer = document.getElementById("history-container");
        const items = historyContainer.getElementsByClassName('history-item');
        for (let item of items) {
            if (item.querySelector('h3').textContent === title) {
                item.style.opacity = '0';
                item.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    item.remove();
                    toggleReportButton(Object.keys(history).length > 0);
                }, 300);
                break;
            }
        }
        
        showToast('Item removido com sucesso!', 'success');
    }
};

window.generateSingleQrCode = async function() {
    const bookData = {
        title: document.getElementById("book-title").value.trim(),
        author: document.getElementById("author").value.trim(),
        genre: document.getElementById("genre").value.trim(),
        quantity: parseInt(document.getElementById("book-quantity").value) || 1,
        timestamp: new Date().toISOString()
    };

    if (!bookData.title || !bookData.author || !bookData.genre) {
        showToast('Por favor, preencha todos os campos corretamente!', 'error');
        return;
    }

    try {
        if (history[bookData.title]) {
            history[bookData.title].quantidade += bookData.quantity;
        } else {
            history[bookData.title] = {
                ...bookData,
                quantidade: bookData.quantity
            };
        }

        const qrCodeUrl = await generateQRCodeUrl(bookData.title);
        history[bookData.title].qrCodeUrl = qrCodeUrl;
        
        await displayInHistory(bookData.title, qrCodeUrl, history[bookData.title]);
        saveToLocalStorage();
        resetForm();
        toggleReportButton(true);
        showToast('QR Code gerado com sucesso!', 'success');
    } catch (error) {
        showToast('Erro ao gerar QR Code. Tente novamente.', 'error');
        console.error('Erro:', error);
    }
};

function resetForm() {
    const fields = ["book-title", "author", "genre"];
    fields.forEach(field => document.getElementById(field).value = "");
    document.getElementById("book-quantity").value = "1";
}

function toggleReportButton(show) {
    const button = document.getElementById("generate-report-btn");
    button.classList.toggle("hidden", !show);
}

async function displayInHistory(title, qrCodeUrl, details) {
    const historyContainer = document.getElementById("history-container");
    const historyItem = await createHistoryItem(title, qrCodeUrl, details);

    historyItem.style.opacity = '0';
    historyItem.style.transform = 'translateY(20px)';
    historyContainer.insertBefore(historyItem, historyContainer.firstChild);

    historyItem.offsetHeight;
    historyItem.style.transition = 'all 0.3s ease-out';
    historyItem.style.opacity = '1';
    historyItem.style.transform = 'translateY(0)';
}

function createHistoryItem(title, qrCodeUrl, details) {
    return new Promise(resolve => {
        const item = document.createElement('div');
        item.className = 'history-item';

        item.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div class="history-content">
                    <div class="history-header">
                        <h3>${title}</h3>
                        <button class="delete-item-btn" onclick="deleteHistoryItem('${title}')">
                            <span class="delete-icon">×</span>
                        </button>
                    </div>
                    <span>${formatDate(details.timestamp)}</span>
                    <p><strong>Autor:</strong> ${details.author}</p>
                    <p><strong>Gênero:</strong> ${details.genre}</p>
                    <p><strong>Quantidade:</strong> ${details.quantidade}</p>
                </div>
                <div style="width: ${CONFIG.qrCodeSize}px; height: ${CONFIG.qrCodeSize}px;">
                    <img src="${qrCodeUrl}" alt="QR Code" style="width: 100%; height: 100%;" />
                </div>
            </div>
        `;

        resolve(item);
    });
}

window.generateFinalReport = async function() {
    const { jsPDF } = window.jsPDF || { jsPDF: window.jspdf.jsPDF };
    const doc = new jsPDF();
    const config = CONFIG.pdfConfig;

    try {
        showToast('Gerando PDF...', 'info');

        for (const [title, item] of Object.entries(history)) {
            const totalQRCodes = item.quantidade;
            const qrCodeUrl = item.qrCodeUrl || await generateQRCodeUrl(title);

            for (let i = 0; i < totalQRCodes; i++) {
                const position = calculatePosition(i, config, doc);
                
                if (position.newPage) {
                    doc.addPage();
                }

                await addQRCodeWithTitle(
                    doc,
                    qrCodeUrl,
                    title,
                    position.x,
                    position.y,
                    config
                );
            }
        }

        doc.save("etiquetas_biblioteca.pdf");
        showToast('PDF gerado com sucesso!', 'success');
    } catch (error) {
        showToast('Erro ao gerar PDF. Tente novamente.', 'error');
        console.error('Erro:', error);
    }
};

window.clearHistory = function() {
    if (confirm('Tem certeza que deseja limpar todo o histórico?')) {
        history = {};
        localStorage.removeItem('qrCodeHistory');
        const historyContainer = document.getElementById("history-container");
        if (historyContainer) {
            historyContainer.innerHTML = '';
        }
        toggleReportButton(false);
        showToast('Histórico limpo com sucesso!', 'success');
    }
};

function calculatePosition(index, config, doc) {
    const itemsPerPage = config.cols * config.rows;
    const page = Math.floor(index / itemsPerPage);
    const indexOnPage = index % itemsPerPage;
    
    const col = indexOnPage % config.cols;
    const row = Math.floor(indexOnPage / config.cols);

    const totalWidth = config.qrSize + config.titleHeight;
    const xPos = config.margin + (col * (config.qrSize + config.spacing));
    const yPos = config.margin + (row * (totalWidth + config.spacing));

    return {
        x: xPos,
        y: yPos,
        newPage: indexOnPage === 0 && index > 0
    };
}

async function addQRCodeWithTitle(doc, qrCodeUrl, title, x, y, config) {
    await addQRCodeToPDF(doc, qrCodeUrl, x, y, config.qrSize);

    doc.setFontSize(config.fontSize);
    doc.setTextColor('#000000');
    
    let displayTitle = title;
    if (title.length > 20) {
        displayTitle = title.substring(0, 17) + '...';
    }

    const titleX = x + (config.qrSize / 2);
    const titleY = y + config.qrSize + 5;
    doc.text(displayTitle, titleX, titleY, { align: 'center' });
}

async function addQRCodeToPDF(doc, url, x, y, size) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.src = url;
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = size * 2;
            canvas.height = size * 2;
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            const imgData = canvas.toDataURL('image/png');
            doc.addImage(imgData, 'PNG', x, y, size, size);
            resolve();
        };
        img.onerror = () => resolve();
    });
}

document.addEventListener('DOMContentLoaded', async () => {
    const quantityInput = document.getElementById("book-quantity");
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            if (this.value < 1) this.value = 1;
        });
    }

    if (loadFromLocalStorage()) {
        const historyContainer = document.getElementById("history-container");
        if (historyContainer) {
            historyContainer.innerHTML = '';
            
            const sortedHistory = Object.entries(history)
                .sort(([, a], [, b]) => new Date(b.timestamp) - new Date(a.timestamp));

            for (const [title, details] of sortedHistory) {
                if (details.qrCodeUrl) {
                    await displayInHistory(title, details.qrCodeUrl, details);
                } else {
                    const qrCodeUrl = await generateQRCodeUrl(title);
                    details.qrCodeUrl = qrCodeUrl;
                    await displayInHistory(title, qrCodeUrl, details);
                }
            }

            toggleReportButton(Object.keys(history).length > 0);
        }
        showToast('Histórico carregado com sucesso!', 'info');
    }
});
    </script>
</body>
</html>