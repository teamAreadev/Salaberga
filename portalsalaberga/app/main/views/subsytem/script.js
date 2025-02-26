document.addEventListener('DOMContentLoaded', function () {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
    const sunIcon = darkModeToggle.querySelector('.sun-icon');
    const moonIcon = darkModeToggle.querySelector('.moon-icon');
    const sunIconMobile = darkModeToggleMobile.querySelector('.sun-icon');
    const moonIconMobile = darkModeToggleMobile.querySelector('.moon-icon');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

    function updateIcons(isDark) {
        if (isDark) {
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
            sunIconMobile.classList.add('hidden');
            moonIconMobile.classList.remove('hidden');
        } else {
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            sunIconMobile.classList.remove('hidden');
            moonIconMobile.classList.add('hidden');
        }
    }

    function updateDarkMode(isDark) {
        if (isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark'); // Salva 'dark' no localStorage
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light'); // Salva 'light' no localStorage
        }
        updateIcons(isDark);
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        updateDarkMode(savedTheme === 'dark');
    } else {
        updateDarkMode(prefersDarkScheme.matches);
    }

    prefersDarkScheme.addListener((e) => {
        if (!localStorage.getItem('theme')) {
            updateDarkMode(e.matches);
        }
    });

    [darkModeToggle, darkModeToggleMobile].forEach(toggle => {
        toggle.addEventListener('click', function () {
            const isDark = !document.documentElement.classList.contains('dark');
            updateDarkMode(isDark);
        });
    });

    const accessibilityBtnMobile = document.getElementById('accessibilityBtnMobile');
    const accessibilityMenuMobile = document.getElementById('accessibilityMenuMobile');
    const themeBtnMobile = document.getElementById('themeBtnMobile');
    const themeMenuMobile = document.getElementById('themeMenuMobile');
    const backToMainMenu = document.getElementById('backToMainMenu');
    const menuOverlay = document.getElementById('menuOverlay');

    const accessibilityBtnDesktop = document.getElementById('accessibilityBtnDesktop');
    const accessibilityMenuDesktop = document.getElementById('accessibilityMenuDesktop');
    const themeBtnDesktop = document.getElementById('themeBtnDesktop');
    const themeMenuDesktop = document.getElementById('themeMenuDesktop');
    const backToMainMenuDesktop = document.getElementById('backToMainMenuDesktop');

    function showOverlay() {
        menuOverlay.classList.add('active');
    }

    function hideOverlay() {
        menuOverlay.classList.remove('active');
    }

    function closeAllMenus() {
        accessibilityMenuMobile.classList.add('hidden');
        themeMenuMobile.classList.add('hidden');
        hideOverlay();

        accessibilityMenuDesktop.classList.add('hidden');
        themeMenuDesktop.classList.add('hidden');
    }

    accessibilityBtnMobile.addEventListener('click', function (e) {
        e.stopPropagation();
        const isHidden = accessibilityMenuMobile.classList.contains('hidden');
        if (isHidden) {
            closeAllMenus();
            accessibilityMenuMobile.classList.remove('hidden');
            showOverlay();
        } else {
            closeAllMenus();
        }
    });

    themeBtnMobile.addEventListener('click', function (e) {
        e.stopPropagation();
        accessibilityMenuMobile.classList.add('hidden');
        themeMenuMobile.classList.remove('hidden');
    });

    backToMainMenu.addEventListener('click', function (e) {
        e.stopPropagation();
        themeMenuMobile.classList.add('hidden');
        accessibilityMenuMobile.classList.remove('hidden');
    });

    accessibilityBtnDesktop.addEventListener('click', function (e) {
        e.stopPropagation();
        const isHidden = accessibilityMenuDesktop.classList.contains('hidden');
        if (isHidden) {
            closeAllMenus();
            accessibilityMenuDesktop.classList.remove('hidden');
        } else {
            closeAllMenus();
        }
    });

    themeBtnDesktop.addEventListener('click', function (e) {
        e.stopPropagation();
        accessibilityMenuDesktop.classList.add('hidden');
        themeMenuDesktop.classList.remove('hidden');
    });

    backToMainMenuDesktop.addEventListener('click', function (e) {
        e.stopPropagation();
        themeMenuDesktop.classList.add('hidden');
        accessibilityMenuDesktop.classList.remove('hidden');
    });

    menuOverlay.addEventListener('click', closeAllMenus);

    document.addEventListener('click', function (e) {
        const isClickInsideAccessibilityMobile = accessibilityMenuMobile.contains(e.target) || themeMenuMobile.contains(e.target) || accessibilityBtnMobile.contains(e.target);
        const isClickInsideAccessibilityDesktop = accessibilityMenuDesktop.contains(e.target) || themeMenuDesktop.contains(e.target) || accessibilityBtnDesktop.contains(e.target);

        if (!isClickInsideAccessibilityMobile && !isClickInsideAccessibilityDesktop) {
            closeAllMenus();
        }
    });

    [accessibilityMenuMobile, themeMenuMobile, accessibilityMenuDesktop, themeMenuDesktop].forEach(menu => {
        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    const themeButtons = document.querySelectorAll('[data-theme]');
    themeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const theme = this.dataset.theme;
            closeAllMenus();
        });
    });

    const header = document.querySelector('.main-header');
    const mobileNav = document.querySelector('.mobile-nav');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > lastScroll && currentScroll > 100) {
            header.classList.add('scrolled');
            mobileNav.style.transform = 'translate(-50%, 100%)';
        } else {
            header.classList.remove('scrolled');
            mobileNav.style.transform = 'translate(-50%, 0)';
        }

        lastScroll = currentScroll;
    });

    const searchInput = document.getElementById('search-input');
    const appCards = document.querySelectorAll('.app-card');
    const gridContainer = document.querySelector('.grid-container');

    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        let visibleCards = [];
        let hiddenCards = [];

        if (searchTerm === '') {
            showAllCards();
            return;
        }

        appCards.forEach(card => {
            const appName = card.querySelector('.app-name').textContent.toLowerCase();
            const category = card.querySelector('.category-tag').textContent.toLowerCase();
            const parentLink = card.parentElement;

            if (appName.includes(searchTerm) || category.includes(searchTerm)) {
                visibleCards.push(parentLink);
                parentLink.style.display = 'block';
                setTimeout(() => {
                    parentLink.style.opacity = '1';
                    parentLink.style.transform = 'scale(1)';
                }, 50);
            } else {
                hiddenCards.push(parentLink);
                parentLink.style.opacity = '0';
                parentLink.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    parentLink.style.display = 'none';
                }, 300);
            }
        });
    });

    function showAllCards() {
        gridContainer.classList.add('transitioning');

        appCards.forEach((card, index) => {
            const parentLink = card.parentElement;

            parentLink.style.display = 'block';
            parentLink.style.opacity = '0';
            parentLink.style.transform = 'scale(0.8)';

            setTimeout(() => {
                parentLink.style.opacity = '1';
                parentLink.style.transform = 'scale(1)';
            }, index * 50);
        });

        setTimeout(() => {
            gridContainer.classList.remove('transitioning');
        }, appCards.length * 50 + 300);
    }

    searchInput.addEventListener('search', function () {
        if (this.value === '') {
            showAllCards();
        }
    });

    const clearButton = document.createElement('button');
    clearButton.textContent = '';
    clearButton.classList.add('clear-search');
    clearButton.style.display = 'none';

    searchInput.parentElement.appendChild(clearButton);

    clearButton.addEventListener('click', () => {
        searchInput.value = '';
        showAllCards();
        clearButton.style.display = 'none';
    });

    searchInput.addEventListener('input', function () {
        clearButton.style.display = this.value ? 'block' : 'none';
    });

    const mobileNavLinks = document.querySelectorAll('.mobile-nav a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            mobileNavLinks.forEach(l => l.classList.remove('text-primary'));
            this.classList.add('text-primary');

            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    const animateCards = () => {
        appCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.3s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    };

    animateCards();

    appCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            const icon = this.querySelector('.icon-wrapper');
            icon.style.transform = 'scale(1.1) rotate(5deg)';
        });

        card.addEventListener('mouseleave', function () {
            const icon = this.querySelector('.icon-wrapper');
            icon.style.transform = 'scale(1) rotate(0)';
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    const showLoading = () => {
        const loading = document.createElement('div');
        loading.className = 'loading-indicator';
        document.body.appendChild(loading);

        setTimeout(() => {
            loading.remove();
        }, 1000);
    };

    appCards.forEach(card => {
        card.addEventListener('click', showLoading);
    });
});