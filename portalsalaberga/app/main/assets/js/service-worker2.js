self.addEventListener('install', (event) => {
    console.log('Service Worker instalado');
});

self.addEventListener('activate', (event) => {
    console.log('Service Worker ativado');
});

self.addEventListener('fetch', (event) => {
    console.log('Fetch interceptado para:', event.request.url);
});
// Verifica se o Service Worker e o PushManager são suportados
if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('service-worker.js')
            .then(function(registration) {
                console.log('Service Worker registrado com sucesso:', registration);
            })
            .catch(function(error) {
                console.log('Falha ao registrar o Service Worker:', error);
            });
    });

    let deferredPrompt;

    // Evento antes de instalar o prompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        showInstallPromotion();
    });

    // Função para mostrar o banner de instalação
function showInstallPromotion() {
    const installButton = document.createElement('button');
    installButton.className = 'install-button'; // Adiciona a classe específica
    installButton.textContent = 'Instalar Portal do Professor';
    installButton.addEventListener('click', () => {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Usuário aceitou a instalação do A2HS');
            } else {
                console.log('Usuário recusou a instalação do A2HS');
            }
            deferredPrompt = null;
        });
    });
    document.body.appendChild(installButton);
}
} else {
    console.log('Service Workers não são suportados neste navegador.');
}
