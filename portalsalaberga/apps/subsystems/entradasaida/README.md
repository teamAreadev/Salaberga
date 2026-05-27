# 🚪 Sistema de Controle de Entrada e Saída - Salaberga

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**Sistema completo de gerenciamento de entrada e saída de alunos para a EEEP Salaberga Torquato Gomes de Matos**

[📋 Funcionalidades](#-funcionalidades) • [🏗️ Arquitetura](#️-arquitetura) • [🚀 Instalação](#-instalação) • [📖 Uso](#-uso) • [🔐 Autenticação](#-autenticação)

</div>

---

> 📚 **Este é um módulo do Portal Salaberga**. Para informações sobre o sistema completo, consulte o [README Principal](../../../../README.md).

---

## 📖 Sobre o Projeto

O **Sistema de Controle de Entrada e Saída** é um módulo integrado ao **Portal Salaberga**, uma plataforma educacional completa desenvolvida para a **EEEP Salaberga Torquato Gomes de Matos** em Maranguape, Ceará.

Este sistema faz parte de um ecossistema maior que inclui:
- 🔐 **Sistema de autenticação centralizado** com login seguro
- 📊 **Dashboard personalizado** com permissões específicas por tipo de usuário
- 🏠 **Página inicial institucional** da escola com informações, notícias e recursos educacionais
- 🔧 **Múltiplos subsistemas integrados** (estágio, financeiro, biblioteca, controle de estoque, entre outros)

> 💡 **Nota**: Este módulo está totalmente integrado ao Portal Salaberga e utiliza o sistema de autenticação e permissões centralizado.

### 🎯 Objetivo

Facilitar o controle e registro de entrada e saída de alunos, permitindo um acompanhamento preciso da frequência escolar, com suporte especial para registros de estágio e geração de relatórios detalhados.

---

## ✨ Funcionalidades

### 🔑 Registro de Entrada
- Registro completo de entrada de alunos
- Captura de informações do responsável e condutor
- Classificação por tipo de responsável e motivo da entrada
- Validação de duplicidade de registros
- Interface intuitiva e responsiva

### 🚪 Registro de Saída
- Registro de saída com todas as informações necessárias
- Validação de entrada prévia
- Controle de permissões e autorizações
- Feedback visual imediato

### 💼 Registro de Saída para Estágio
- Sistema específico para registro de saídas de estágio
- Validação rápida via QR Code ou ID do aluno
- Páginas de confirmação e erro estilizadas
- Redirecionamento automático após registro

### 📊 Relatórios e Consultas
- **Relatórios individuais** por aluno
- **Relatórios por turma** com filtros de data
- **Relatórios gerais** diários, mensais e anuais
- **Relatórios de estágio** específicos
- Exportação em PDF
- Visualização do último registro

### 🎨 Interface Moderna
- Design responsivo e acessível
- Paleta de cores institucional (verde Ceará)
- Animações suaves e feedback visual
- Compatível com dispositivos móveis

---

## 🏗️ Arquitetura

O sistema segue uma arquitetura **MVC (Model-View-Controller)** organizada:

```
entradaSaida/
├── index.php                 # Ponto de entrada principal
├── success.php               # Página de sucesso estilizada
├── erro.php                  # Página de erro estilizada
└── app/
    └── main/
        ├── config/           # Configurações do banco de dados
        ├── control/          # Controladores (lógica de negócio)
        ├── model/            # Modelos (acesso a dados)
        └── views/            # Visualizações (interface)
            ├── inicio.php                    # Dashboard principal
            ├── entradas/                      # Módulo de entradas
            │   └── registro_entrada.php
            ├── saidas/                        # Módulo de saídas
            │   └── registro_saida.php
            ├── estagio/                       # Módulo de estágio
            │   └── saida_Estagio.php
            ├── QRCode/                        # Sistema de QR Code
            └── relatorios/                    # Módulo de relatórios
                ├── relatorioEntrada.php
                ├── relatorioSaida.php
                ├── aluno_individual/
                ├── por_turma/
                └── ano_geral/
```

### 🔌 Integração com o Sistema Principal

O sistema está totalmente integrado ao **Portal Salaberga**:

- **Autenticação**: Utiliza o sistema de sessões centralizado (`../../main/models/sessions.php`)
- **Navegação**: Acesso através do dashboard principal com permissões específicas
- **Banco de Dados**: Compartilha a mesma base de dados do portal
- **Design System**: Segue o padrão visual e de cores da escola

---

## 🚀 Instalação

### 📋 Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- Extensões PHP: PDO, PDO_MySQL, GD (para QR Code)

### 📥 Passos de Instalação

1. **Clone o repositório** (ou copie os arquivos para o servidor):
```bash
git clone [seu-repositorio]
cd Salaberga/portalsalaberga/app/subsystems/entradaSaida
```

2. **Configure o banco de dados**:
   - Edite o arquivo `app/main/config/Database.php`
   - Configure as credenciais de conexão:
```php
private $host = 'localhost';
private $dbname = 'seu_banco';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

3. **Importe a estrutura do banco de dados**:
   - Execute os scripts SQL necessários para criar as tabelas:
     - `aluno`
     - `registro_entrada`
     - `registro_saida`
     - `registro_saida_estagio`
     - E demais tabelas relacionadas

4. **Configure as permissões**:
   - Certifique-se de que o sistema principal de autenticação está configurado
   - Verifique as permissões de acesso no dashboard principal

5. **Ajuste as rotas** (se necessário):
   - Verifique os caminhos relativos no arquivo `index.php`
   - Ajuste conforme a estrutura do seu servidor

---

## 📖 Uso

### 🔐 Acesso ao Sistema

1. Acesse o **Portal Salaberga** através da página inicial
2. Faça login com suas credenciais
3. No dashboard, selecione o módulo **"Entrada e Saída"**
4. Você será redirecionado para o sistema

### 📝 Registrar Entrada

1. No menu principal, clique em **"Registrar Entrada"**
2. Preencha os dados do aluno (ID ou busque pelo nome)
3. Informe os dados do responsável e condutor
4. Selecione o tipo de responsável, condutor e motivo
5. Confirme o registro

### 🚪 Registrar Saída

1. No menu principal, clique em **"Registrar Saída"**
2. Informe o ID do aluno
3. Preencha os dados necessários
4. O sistema validará se existe uma entrada registrada
5. Confirme a saída

### 💼 Registrar Saída de Estágio

1. Acesse **"Registrar Saída-Estágio"**
2. Informe o ID do aluno ou escaneie o QR Code
3. O sistema registrará automaticamente com a data/hora atual
4. Você será redirecionado para a página de confirmação

### 📊 Gerar Relatórios

1. Acesse o menu **"Relatórios"**
2. Escolha o tipo de relatório desejado:
   - **Individual**: Por aluno específico
   - **Por Turma**: Filtrado por turma e data
   - **Geral**: Diário, mensal ou anual
   - **Estágio**: Relatórios específicos de estágio
3. Configure os filtros necessários
4. Visualize ou exporte em PDF

---

## 🔐 Autenticação e Permissões

O sistema utiliza o **sistema de autenticação centralizado** do Portal Salaberga:

- ✅ Verificação de sessão em todas as páginas
- ✅ Redirecionamento automático para login se não autenticado
- ✅ Controle de permissões baseado no tipo de usuário
- ✅ Dashboard personalizado conforme permissões

### 👥 Tipos de Usuário

- **Administrador**: Acesso completo a todos os módulos
- **Secretaria**: Acesso a registros e relatórios
- **Portaria**: Acesso a registro de entrada/saída
- **Professor**: Acesso limitado a consultas

---

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Bibliotecas**:
  - FPDF (geração de PDFs)
  - PHP QR Code (geração de QR Codes)
  - Font Awesome (ícones)
  - Google Fonts (tipografia)

---

## 📁 Estrutura de Arquivos Principais

### Controllers
- `app/main/control/control_index.php` - Controlador principal que gerencia as requisições de entrada e saída

### Models
- `app/main/model/model_indexClass.php` - Modelo principal com métodos de acesso ao banco
- `app/main/model/select_model.php` - Modelo para consultas e seleções
- `app/main/model/sessions.php` - Gerenciamento de sessões

### Views
- `app/main/views/inicio.php` - Dashboard principal do sistema
- `app/main/views/entradas/registro_entrada.php` - Formulário de entrada
- `app/main/views/saidas/registro_saida.php` - Formulário de saída
- `app/main/views/estagio/saida_Estagio.php` - Formulário de saída de estágio
- `app/main/views/relatorios/` - Módulo completo de relatórios

---

## 🎨 Design e Estilo

O sistema utiliza uma **paleta de cores institucional** baseada nas cores do Ceará:

- **Verde Principal**: `#008C45`
- **Verde Claro**: `#00b357`
- **Laranja**: `#FFA500`
- **Branco**: `#FFFFFF`

### Características de Design

- ✨ Interface moderna e limpa
- 📱 Totalmente responsiva
- 🎭 Animações suaves
- ♿ Acessibilidade considerada
- 🌈 Feedback visual imediato

---

## 🔄 Integração com Outros Sistemas

O Portal Salaberga conta com **20+ subsistemas integrados**. Para conhecer todos os módulos disponíveis, consulte o [README Principal do Portal Salaberga](../../../../README.md#-subsistemas).

Alguns dos principais subsistemas incluem:
- 📚 **Biblioteca**: Gestão de acervo e empréstimos
- 💰 **Financeiro**: Controle financeiro escolar
- 📦 **Controle de Estoque**: Gestão de materiais
- 🎓 **Estágio**: Gerenciamento de estágios
- 📋 **Banco de Questões**: Banco de questões para avaliações
- 🍽️ **Alimentação**: Controle de refeições
- 👥 **Gerenciador de Usuários**: Administração de usuários
- E muitos outros...

---

## 📝 Licença

Este projeto faz parte do **Portal Salaberga** e está sob a licença do projeto principal.

---

## 👥 Desenvolvedores

Desenvolvido pela equipe de desenvolvimento da **EEEP Salaberga Torquato Gomes de Matos**.

**Área DEV 001** - A primeira área de desenvolvimento que fez história! 🚀

---

## 📞 Suporte

Para suporte, entre em contato através do portal principal ou da secretaria da escola.

---

## 🔗 Links Relacionados

- [📚 README Principal do Portal Salaberga](../../../../README.md) - Documentação completa do ecossistema
- [🏠 Página Inicial do Portal](../../../main/index.php) - Acesse o portal

---

## 🚀 Melhorias Futuras

- [ ] App mobile para registro rápido
- [ ] Notificações em tempo real
- [ ] Dashboard com gráficos interativos
- [ ] Integração com sistema de biometria
- [ ] API REST para integrações externas
- [ ] Exportação para Excel
- [ ] Histórico completo de movimentações

---

<div align="center">

**Desenvolvido com ❤️ para a EEEP Salaberga Torquato Gomes de Matos**

[⬆ Voltar ao topo](#-sistema-de-controle-de-entrada-e-saída---salaberga)

</div>

