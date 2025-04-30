<?php
require_once('../models/select_model.php');
$select_model = new select_model;
/*require_once('../models/sessions.php');
$session = new sessions;
$session->tempo_session(600);
$session->autenticar_session();

if (isset($_POST['logout'])) {
    $session->quebra_session();
}*/
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Gerenciamento de Empresas - Sistema de Estágio">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <title>Gerenciar Empresas - Sistema de Estágio</title>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#007A33',
                            '50': '#00FF6B',
                            '100': '#00EB61',
                            '200': '#00C250',
                            '300': '#00993F',
                            '400': '#00802F',
                            '500': '#007A33',
                            '600': '#00661F',
                            '700': '#00521A',
                            '800': '#003D15',
                            '900': '#002910'
                        },
                        secondary: {
                            DEFAULT: '#FFA500',
                            '50': '#FFE9C0',
                            '100': '#FFE1AB',
                            '200': '#FFD183',
                            '300': '#FFC15A',
                            '400': '#FFB232',
                            '500': '#FFA500',
                            '600': '#C78000',
                            '700': '#8F5C00',
                            '800': '#573800',
                            '900': '#1F1400'
                        },
                        dark: {
                            DEFAULT: '#1a1a1a',
                            '50': '#2d2d2d',
                            '100': '#272727',
                            '200': '#232323',
                            '300': '#1f1f1f',
                            '400': '#1a1a1a',
                            '500': '#171717',
                            '600': '#141414',
                            '700': '#111111',
                            '800': '#0e0e0e',
                            '900': '#0a0a0a'
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.36)',
                        'card': '0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.2)'
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #1a1a1a;
            color: #ffffff;
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(0, 122, 51, 0.05) 0%, rgba(0, 122, 51, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(255, 165, 0, 0.05) 0%, rgba(255, 165, 0, 0) 20%),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='%23007A33' fill-opacity='0.03' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
            transition: all 0.3s ease;
        }

        /* Sidebar styling */
        .sidebar {
            background-color: rgba(45, 45, 45, 0.95);
            background-image: linear-gradient(to bottom, #2d2d2d, #222222);
            border-right: 1px solid rgba(0, 122, 51, 0.2);
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            color: #ffffff;
        }

        .sidebar-link:hover {
            background-color: rgba(0, 122, 51, 0.2);
            color: #00C250;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background-color: rgba(0, 122, 51, 0.3);
            color: #00FF6B;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 122, 51, 0.15);
        }

        /* Company card styling */
        .empresa-card {
            background: linear-gradient(135deg, rgba(49, 49, 49, 0.95) 0%, rgba(37, 37, 37, 0.95) 100%);
            border-radius: 16px;
            padding: 1.75rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .empresa-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, #00FF6B, #007A33);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .empresa-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(0, 122, 51, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        .empresa-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4), 0 0 20px rgba(0, 122, 51, 0.1);
            border: 1px solid rgba(0, 122, 51, 0.3);
        }

        .empresa-card:hover::before {
            opacity: 1;
            box-shadow: 0 0 15px rgba(0, 255, 107, 0.4);
        }

        .empresa-card:hover::after {
            opacity: 1;
        }

        .empresa-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .empresa-card-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            background: linear-gradient(90deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            transition: all 0.3s ease;
        }

        .empresa-card:hover .empresa-card-title {
            background: linear-gradient(90deg, #ffffff, #00FF6B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .empresa-card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .empresa-card-action {
            padding: 0.625rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

    
        .empresa-card-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .empresa-card-info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #d1d5db;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}



        .empresa-card-info-item i {
            color: #007A33;
            transition: all 0.3s ease;
        }

        .empresa-card:hover .empresa-card-info-item i {
            color: #00FF6B;
        }

        .area-chip {
            padding: 0.35rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.3s ease;
        }

    
        .area-desenvolvimento {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.2) 100%);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

    

        .area-tutoria {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
            color: #c4b5fd;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .area-tutoria:hover {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.3) 0%, rgba(139, 92, 246, 0.3) 100%);
        }

        .area-mídia\/design {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .area-mídia\/design:hover {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3) 0%, rgba(5, 150, 105, 0.3) 100%);
        }

        .area-suporte {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .area-suporte:hover {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.3) 0%, rgba(217, 119, 6, 0.3) 100%);
        }

        .ver-vagas-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: linear-gradient(to right, rgba(0, 122, 51, 0.1), rgba(0, 122, 51, 0.2));
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 122, 51, 0.2);
        }

        .ver-vagas-link:hover {
            background: linear-gradient(to right, rgba(0, 122, 51, 0.2), rgba(0, 122, 51, 0.3));
            transform: translateX(5px);
        }

        .ver-vagas-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .ver-vagas-link:hover::before {
            transform: translateX(100%);
        }

        .ver-vagas-link i {
            transition: transform 0.3s ease;
        }

        .ver-vagas-link:hover i {
            transform: translateX(5px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #3d3d3d;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #007A33;
        }

        /* Custom Form Styling */
        .custom-input {
            background-color: rgba(35, 35, 35, 0.8) !important;
            border: 2px solid rgba(61, 61, 61, 0.8) !important;
            border-radius: 10px !important;
            color: #ffffff !important;
            padding: 0.75rem 1rem !important;
            width: 100% !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        .custom-input:focus {
            border-color: #007A33 !important;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2), inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            outline: none !important;
            background-color: rgba(40, 40, 40, 0.9) !important;
        }

        .custom-input::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .input-group:focus-within .form-label {
            color: #00C250;
        }

        .custom-radio {
            appearance: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            background-color: transparent;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-radio:checked {
            border-color: #007A33;
            background-color: #007A33;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2);
        }

        .custom-radio:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.4rem;
            height: 0.4rem;
            background-color: white;
            border-radius: 50%;
            animation: scaleIn 0.15s ease-in-out;
        }

        .custom-radio-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .custom-radio-label:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .custom-radio:checked + .custom-radio-label {
            background-color: rgba(0, 122, 51, 0.1);
            color: #00C250;
        }

        .radio-icon {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .custom-radio:checked ~ .custom-radio-label .radio-icon {
            color: #00C250;
        }

        .form-group {
            background: rgba(30, 30, 30, 0.5);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group:hover {
            border-color: rgba(0, 122, 51, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        /* Custom Modal */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .modal-content {
            background: linear-gradient(135deg, rgba(49, 49, 49, 0.95) 0%, rgba(37, 37, 37, 0.95) 100%);
            border-radius: 16px;
            padding: 2rem;
            max-width: 550px;
            width: 90%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3), 0 10px 10px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            position: relative;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #007A33, #00C250);
        }

        .modal-content::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(0, 122, 51, 0.1), transparent 60%);
            pointer-events: none;
        }

        .modal-header {
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(90deg, #ffffff, #00C250);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .modal-show .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .custom-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .custom-btn-primary {
            background: linear-gradient(135deg, #007A33 0%, #009940 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 122, 51, 0.3);
        }

        .custom-btn-primary:hover {
            background: linear-gradient(135deg, #00993F 0%, #00B64B 100%);
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(0, 122, 51, 0.4);
        }

        .custom-btn-primary:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 122, 51, 0.3);
        }

        .custom-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .custom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .custom-btn:hover::before {
            transform: translateX(100%);
        }

        .btn-icon {
            transition: all 0.3s ease;
            opacity: 0.8;
        }

        .custom-btn:hover .btn-icon {
        
            opacity: 1;
        }

        /* Animations */
        @keyframes scaleIn {
            0% {
                transform: translate(-50%, -50%) scale(0);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .slide-up {
            animation: slideUp 0.4s ease-out forwards;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .custom-input {
                min-width: 100% !important;
            }
            
            .modal-content {
                padding: 1.5rem;
                width: 95%;
            }
            
            .form-group {
                padding: 1rem;
            }
        }

        /* Action bar enhancements */
        .action-bar {
            background-color: rgba(45, 45, 45, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Card animations and effects */
        .card-enter {
            opacity: 0;
            transform: translateY(20px);
        }

        .card-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms, transform 300ms;
        }

        /* Search input styling */
        .search-input-container {
            position: relative;
            transition: all 0.3s ease;
        }

        .search-input-container:focus-within {
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .search-input-container:focus-within .search-icon {
            color: #00C250;
        }
    </style>
</head>

<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 hidden md:block">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center gap-2 mb-6">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                        <div class="h-0.5 bg-primary-500/20 rounded-full mt-1"></div>
                    </div>
                </div>
                <nav class="flex-1">
                    <a href="./dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="./gerenciar_empresas.php" class="sidebar-link active">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="./vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        Configurações
                    </a>
                    <a href="#" class="sidebar-link text-red-400 hover:text-red-300">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Sair
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden fixed top-4 left-4 z-50">
            <button id="sidebarToggle" class="bg-dark-50 p-2 rounded-lg shadow-md hover:bg-dark-100 transition-all">
                <i class="fas fa-bars text-primary-400"></i>
            </button>
        </div>
        
        <!-- Mobile Sidebar -->
        <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden sidebar">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2">
                        <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="h-10 w-auto">
                        <h1 class="text-lg font-bold text-primary-400">Sistema <span class="text-secondary">STGM</span></h1>
                    </div>
                    <button id="closeSidebar" class="p-2 text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1">
                    <a href="./dashboard.php" class="sidebar-link">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./gerenciar_alunos.php" class="sidebar-link">
                        <i class="fas fa-user-graduate w-5 mr-3"></i>
                        Gerenciar Alunos
                    </a>
                    <a href="./gerenciar_empresas.php" class="sidebar-link active">
                        <i class="fas fa-building w-5 mr-3"></i>
                        Gerenciar Empresas
                    </a>
                    <a href="./vagas.php" class="sidebar-link">
                        <i class="fas fa-briefcase w-5 mr-3"></i>
                        Vagas
                    </a>
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        Relatórios
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Conteúdo principal -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-dark-400">
            <!-- Header -->
            <header class="bg-dark-50 shadow-md sticky top-0 z-30 border-b border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <h1 class="text-xl font-bold text-white text-center sm:text-left w-full">Gerenciamento de Empresas</h1>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400">
                            <i class="fas fa-user-circle mr-1"></i> Admin
                        </span>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 sm:py-8 w-full">
                <!-- Breadcrumbs -->
                <div class="text-sm text-gray-400 mb-6 flex items-center">
                    <a href="./dashboard.php" class="hover:text-primary-400 transition-colors">Dashboard</a>
                    <span class="mx-2 text-gray-600">/</span>
                    <span class="text-white">Gerenciar Empresas</span>
                </div>

                <!-- Actions Bar -->
                <div class="mb-8 action-bar p-4 sm:p-5 fade-in">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full">
                            <button id="addEmpresaBtn" class="custom-btn custom-btn-primary">
                                <i class="fas fa-plus btn-icon"></i>
                                <span>Nova Empresa</span>
                            </button>
                            <div class="search-input-container relative w-full sm:w-64 group">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchEmpresa" placeholder="Buscar empresa..." class="custom-input pl-10 pr-4 py-2.5 w-full">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 w-full sm:w-auto">
                            <div class="relative">
                                <select id="filterArea" class="custom-input pl-4 pr-10 py-2.5 appearance-none w-full">
                                    <option value="">Todas as áreas</option>
                                    <option value="desenvolvimento">Desenvolvimento</option>
                                    <option value="tutoria">Tutoria</option>
                                    <option value="mídia/design">Design/Mídia</option>
                                    <option value="suporte">Redes/Suporte</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Grid de Empresas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="empresasGrid">
                    <?php 
                    $dados = $select_model->concedentes();
                    if (empty($dados)): ?>
                        <div class="col-span-3 text-center py-16 text-gray-400 animate__animated animate__fadeIn">
                            <i class="fas fa-building text-5xl mb-4 text-gray-600 opacity-30"></i>
                            <p class="text-xl">Nenhuma empresa cadastrada no momento.</p>
                            <button id="firstEmpresaBtn" class="mt-6 custom-btn custom-btn-primary">
                                <i class="fas fa-plus btn-icon"></i>
                                <span>Cadastrar Primeira Empresa</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <?php 
                        $delay = 0;
                        foreach ($dados as $dado): 
                            $delay += 100;
                        ?>
                            <div class="empresa-card slide-up" style="animation-delay: <?= $delay ?>ms;" data-empresa-id="<?= htmlspecialchars($dado['id']) ?>" data-area="<?= htmlspecialchars($dado['perfil']) ?>">
                                <div class="empresa-card-header">
                                    <h3 class="empresa-card-title"><?= htmlspecialchars($dado['nome']) ?></h3>
                                    <div class="empresa-card-actions">
                                        <button class="empresa-card-action text-red-500 hover:text-red-400" onclick="excluirEmpresa(<?= $dado['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="area-chip area-<?= htmlspecialchars($dado['perfil']) ?>">
                                        <?php if ($dado['perfil'] === 'desenvolvimento'): ?>
                                            <i class="fas fa-code text-xs"></i>
                                        <?php elseif ($dado['perfil'] === 'tutoria'): ?>
                                            <i class="fas fa-chalkboard-teacher text-xs"></i>
                                        <?php elseif ($dado['perfil'] === 'mídia/design'): ?>
                                            <i class="fas fa-paint-brush text-xs"></i>
                                        <?php elseif ($dado['perfil'] === 'suporte'): ?>
                                            <i class="fas fa-network-wired text-xs"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($dado['perfil']) ?>
                                    </span>
                                </div>
                                <div class="empresa-card-info">
                                    <div class="empresa-card-info-item">
                                        <i class="fas fa-map-marker-alt w-5 text-center"></i>
                                        <span><?= htmlspecialchars($dado['endereco']) ?: 'Não informado' ?></span>
                                    </div>
                                    <div class="empresa-card-info-item">
                                        <i class="fas fa-phone w-5 text-center"></i>
                                        <span><?= htmlspecialchars($dado['contato']) ?: 'Não informado' ?></span>
                                    </div>
                                </div>
                                <div class="mt-5 pt-4 border-t border-gray-700/50">
                                    <a href="./vagas.php?empresa_id=<?= htmlspecialchars($dado['id']) ?>" class="ver-vagas-link text-primary-400 font-medium">
                                        <span>Ver vagas</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
        
        <!-- Modal de Cadastro -->
        <div id="empresaModal" class="modal-overlay fixed inset-0 bg-black/75 hidden z-50 backdrop-blur-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="modalTitle" class="text-2xl font-bold">Nova Empresa</h2>
                </div>
                <form action="../controllers/controller.php" id="empresaForm" method="post" class="space-y-6">
                    <input type="hidden" id="empresaId" name="empresa_id" value="">
                    
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <label for="empresaNome" class="form-label">
                                <i class="fas fa-building mr-2 text-primary-400"></i>
                                Nome da Empresa
                            </label>
                            <input type="text" id="empresaNome" name="nome" class="custom-input" required>
                        </div>
                        
                        <div class="input-group">
                            <label class="form-label mb-3">
                                <i class="fas fa-tag mr-2 text-primary-400"></i>
                                Área de Atuação
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input type="radio" id="area-dev" class="custom-radio" name="areas" value="desenvolvimento">
                                    <label for="area-dev" class="custom-radio-label">
                                        <i class="fas fa-code radio-icon"></i>
                                        <span>Desenvolvimento</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="area-tutoria" class="custom-radio" name="areas" value="tutoria">
                                    <label for="area-tutoria" class="custom-radio-label">
                                        <i class="fas fa-chalkboard-teacher radio-icon"></i>
                                        <span>Tutoria</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="area-design" class="custom-radio" name="areas" value="mídia/design">
                                    <label for="area-design" class="custom-radio-label">
                                        <i class="fas fa-paint-brush radio-icon"></i>
                                        <span>Design/Mídia</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="area-suporte" class="custom-radio" name="areas" value="suporte">
                                    <label for="area-suporte" class="custom-radio-label">
                                        <i class="fas fa-network-wired radio-icon"></i>
                                        <span>Redes/Suporte</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group mb-4">
                            <label for="empresaEndereco" class="form-label">
                                <i class="fas fa-map-marker-alt mr-2 text-primary-400"></i>
                                Endereço Completo
                            </label>
                            <input type="text" id="empresaEndereco" name="endereco" class="custom-input" placeholder="Rua, número, cidade - UF">
                        </div>
                        
                        <div class="input-group">
                            <label for="empresaTelefone" class="form-label">
                                <i class="fas fa-phone mr-2 text-primary-400"></i>
                                Telefone de Contato
                            </label>
                            <input type="tel" id="empresaTelefone" name="telefone" placeholder="(XX) XXXXX-XXXX" class="custom-input">
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button" id="cancelarBtn" class="custom-btn custom-btn-secondary">
                            <i class="fas fa-times btn-icon"></i>
                            <span>Cancelar</span>
                        </button>
                        <button type="submit" class="custom-btn custom-btn-primary">
                            <i class="fas fa-save btn-icon"></i>
                            <span>Salvar Empresa</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('empresaModal');
            const modalContent = modal.querySelector('.modal-content');
            const addEmpresaBtn = document.getElementById('addEmpresaBtn');
            const firstEmpresaBtn = document.getElementById('firstEmpresaBtn');
            const cancelarBtn = document.getElementById('cancelarBtn');
            const empresaForm = document.getElementById('empresaForm');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const searchInput = document.getElementById('searchEmpresa');
            const filterArea = document.getElementById('filterArea');
            const telefoneInput = document.getElementById('empresaTelefone');
            
            // Animation for empresa cards
            const empresaCards = document.querySelectorAll('.empresa-card');
            if (empresaCards.length > 0) {
                gsap.from(empresaCards, {
                    duration: 0.6,
                    y: 30,
                    opacity: 0,
                    stagger: 0.1,
                    ease: "power3.out"
                });
            }

            // First empresa button listener
            if (firstEmpresaBtn) {
                firstEmpresaBtn.addEventListener('click', () => {
                    document.getElementById('modalTitle').textContent = 'Nova Empresa';
                    document.getElementById('empresaId').value = '';
                    empresaForm.reset();
                    openModal();
                });
            }

            // Máscara de telefone
            telefoneInput.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }

                if (value.length <= 10) {
                    // Formato: (XX) XXXX-XXXX
                    value = value.replace(/(\d{2})(\d{0,4})(\d{0,4})/, '($1) $2-$3');
                } else {
                    // Formato: (XX) XXXXX-XXXX
                    value = value.replace(/(\d{2})(\d{0,5})(\d{0,4})/, '($1) $2-$3');
                }

                e.target.value = value.trim();
            });

            // Limpar caracteres não numéricos antes de enviar o formulário
            empresaForm.addEventListener('submit', (e) => {
                telefoneInput.value = telefoneInput.value.replace(/\D/g, '');
                
                // Animate the submit button
                const submitBtn = e.submitter;
                if (submitBtn) {
                    submitBtn.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        submitBtn.classList.remove('animate__animated', 'animate__pulse');
                    }, 500);
                }
            });

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.classList.add('modal-show');
                
                // Animate modal opening
                gsap.fromTo(modalContent, 
                    { scale: 0.9, opacity: 0 }, 
                    { scale: 1, opacity: 1, duration: 0.3, ease: "back.out(1.7)" }
                );
                
                // Add escape key listener
                document.addEventListener('keydown', closeModalOnEscape);
            }
            
            function closeModal() {
                // Animate modal closing
                gsap.to(modalContent, {
                    scale: 0.9,
                    opacity: 0,
                    duration: 0.2,
                    onComplete: () => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex', 'modal-show');
                    }
                });
                
                // Remove escape key listener
                document.removeEventListener('keydown', closeModalOnEscape);
            }
            
            function closeModalOnEscape(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            }

            addEmpresaBtn.addEventListener('click', () => {
                document.getElementById('modalTitle').textContent = 'Nova Empresa';
                document.getElementById('empresaId').value = '';
                empresaForm.reset();
                openModal();
            });

            cancelarBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            sidebarToggle.addEventListener('click', () => {
                mobileSidebar.classList.remove('-translate-x-full');
                // Animate sidebar opening
                gsap.from('#mobileSidebar .sidebar-link', {
                    x: -20,
                    opacity: 0,
                    stagger: 0.05,
                    duration: 0.3
                });
            });

            closeSidebar.addEventListener('click', () => {
                mobileSidebar.classList.add('-translate-x-full');
            });

            function aplicarFiltros() {
                const searchTerm = searchInput.value.toLowerCase();
                const areaFiltro = filterArea.value;
                const empresaCards = document.querySelectorAll('.empresa-card');
                let visibleCount = 0;

                empresaCards.forEach(card => {
                    const nome = card.querySelector('.empresa-card-title').textContent.toLowerCase();
                    const area = card.dataset.area;
                    const matchSearch = nome.includes(searchTerm);
                    const matchArea = !areaFiltro || area === areaFiltro;

                    if (matchSearch && matchArea) {
                        gsap.to(card, {
                            opacity: 1,
                            scale: 1,
                            height: 'auto',
                            duration: 0.3,
                            display: 'block',
                            ease: "power2.out"
                        });
                        visibleCount++;
                    } else {
                        gsap.to(card, {
                            opacity: 0,
                            scale: 0.95,
                            height: 0,
                            padding: 0,
                            margin: 0,
                            duration: 0.3,
                            display: 'none',
                            ease: "power2.in"
                        });
                    }
                });

                // Show message if no results
                const noResultsMessage = document.getElementById('noResultsMessage');
                if (visibleCount === 0) {
                    if (!noResultsMessage) {
                        const message = document.createElement('div');
                        message.id = 'noResultsMessage';
                        message.className = 'col-span-3 text-center py-8 text-gray-400 mt-8 animate__animated animate__fadeIn';
                        message.innerHTML = `
                            <i class="fas fa-search text-4xl mb-4 text-gray-600 opacity-30"></i>
                            <p class="text-lg">Nenhuma empresa encontrada com os filtros atuais.</p>
                            <button id="clearFiltersBtn" class="mt-4 custom-btn custom-btn-secondary">
                                <i class="fas fa-times-circle btn-icon"></i>
                                <span>Limpar Filtros</span>
                            </button>
                        `;
                        document.getElementById('empresasGrid').appendChild(message);
                        
                        document.getElementById('clearFiltersBtn').addEventListener('click', () => {
                            searchInput.value = '';
                            filterArea.value = '';
                            aplicarFiltros();
                        });
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                }
            }

            searchInput.addEventListener('input', aplicarFiltros);
            filterArea.addEventListener('change', aplicarFiltros);

            // Animate search input focus
            searchInput.addEventListener('focus', () => {
                gsap.to(searchInput, {
                    boxShadow: '0 0 0 3px rgba(0, 122, 51, 0.2), 0 0 15px rgba(0, 122, 51, 0.15)',
                    duration: 0.3
                });
            });
            
            searchInput.addEventListener('blur', () => {
                gsap.to(searchInput, {
                    boxShadow: '0 0 0 0px rgba(0, 122, 51, 0), 0 0 0px rgba(0, 122, 51, 0)',
                    duration: 0.3
                });
            });

            function excluirEmpresa(id) {
                // Create custom confirm dialog
                const confirmDialog = document.createElement('div');
                confirmDialog.className = 'fixed inset-0 bg-black/75 flex items-center justify-center z-50 backdrop-blur-sm';
                confirmDialog.innerHTML = `
                    <div class="bg-dark-50 rounded-lg p-6 max-w-md w-full mx-4 shadow-2xl border border-gray-800 transform scale-95 opacity-0 transition-all duration-300">
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/10 text-red-500 mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Confirmar Exclusão</h3>
                            <p class="text-gray-400 mt-2">Tem certeza que deseja excluir esta empresa? Esta ação não pode ser desfeita.</p>
                        </div>
                        <div class="flex justify-center space-x-4">
                            <button id="cancelExcluir" class="custom-btn custom-btn-secondary">
                                <i class="fas fa-times btn-icon"></i>
                                <span>Cancelar</span>
                            </button>
                            <button id="confirmarExcluir" class="custom-btn bg-red-500 hover:bg-red-600 text-white">
                                <i class="fas fa-trash-alt btn-icon"></i>
                                <span>Excluir Empresa</span>
                            </button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(confirmDialog);
                
                // Animate the dialog
                setTimeout(() => {
                    const dialogContent = confirmDialog.querySelector('div');
                    dialogContent.classList.remove('scale-95', 'opacity-0');
                    dialogContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                
                // Setup event listeners
                confirmDialog.querySelector('#cancelExcluir').addEventListener('click', () => {
                    // Animate out
                    const dialogContent = confirmDialog.querySelector('div');
                    dialogContent.classList.remove('scale-100', 'opacity-100');
                    dialogContent.classList.add('scale-95', 'opacity-0');
                    
                    setTimeout(() => {
                        document.body.removeChild(confirmDialog);
                    }, 300);
                });
                
                confirmDialog.querySelector('#confirmarExcluir').addEventListener('click', () => {
                    // Proceed with deletion
                    fetch('excluir_empresa.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find the card and animate its removal
                            const card = document.querySelector(`[data-empresa-id="${id}"]`);
                            if (card) {
                                gsap.to(card, {
                                    scale: 0.9,
                                    opacity: 0,
                                    y: -20,
                                    duration: 0.3,
                                    onComplete: () => {
                                        card.remove();
                                        
                                        // Show success message
                                        const toast = document.createElement('div');
                                        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate__animated animate__fadeInUp';
                                        toast.innerHTML = `
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle mr-3"></i>
                                                <span>Empresa excluída com sucesso!</span>
                                            </div>
                                        `;
                                        document.body.appendChild(toast);
                                        
                                        setTimeout(() => {
                                            toast.classList.remove('animate__fadeInUp');
                                            toast.classList.add('animate__fadeOutDown');
                                            setTimeout(() => {
                                                document.body.removeChild(toast);
                                            }, 500);
                                        }, 3000);
                                        
                                        // Check if no more companies
                                        const remainingCards = document.querySelectorAll('.empresa-card');
                                        if (remainingCards.length === 0) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            }
                        } else {
                            // Show error message
                            const toast = document.createElement('div');
                            toast.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate__animated animate__fadeInUp';
                            toast.innerHTML = `
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle mr-3"></i>
                                    <span>Erro ao excluir empresa: ${data.message}</span>
                                </div>
                            `;
                            document.body.appendChild(toast);
                            
                            setTimeout(() => {
                                toast.classList.remove('animate__fadeInUp');
                                toast.classList.add('animate__fadeOutDown');
                                setTimeout(() => {
                                    document.body.removeChild(toast);
                                }, 500);
                            }, 4000);
                        }
                        
                        // Remove the dialog
                        document.body.removeChild(confirmDialog);
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        
                        // Show error toast
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate__animated animate__fadeInUp';
                        toast.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                <span>Erro ao excluir empresa. Tente novamente.</span>
                            </div>
                        `;
                        document.body.appendChild(toast);
                        
                        setTimeout(() => {
                            toast.classList.remove('animate__fadeInUp');
                            toast.classList.add('animate__fadeOutDown');
                            setTimeout(() => {
                                document.body.removeChild(toast);
                            }, 500);
                        }, 4000);
                        
                        // Remove the dialog
                        document.body.removeChild(confirmDialog);
                    });
                });
            }
            
            // Expor função ao escopo global para o botão
            window.excluirEmpresa = excluirEmpresa;
        });
    </script>
</body>
</html>