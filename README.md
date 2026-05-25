# 🏫 Portal Salaberga - Plataforma Educacional Completa

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

**Sistema integrado de gestão educacional para a EEEP Salaberga Torquato Gomes de Matos**

[📋 Visão Geral](#-visão-geral) • [🚀 Funcionalidades](#-funcionalidades) • [🏗️ Arquitetura](#️-arquitetura) • [📦 Subsistemas](#-subsistemas) • [🔐 Autenticação](#-autenticação) • [📖 Instalação](#-instalação)

</div>

---

## 📖 Visão Geral

O **Portal Salaberga** é uma plataforma educacional completa e integrada desenvolvida especificamente para a **EEEP Salaberga Torquato Gomes de Matos**, localizada em Maranguape, Ceará. 

Este projeto representa um ecossistema robusto de sistemas interconectados que atendem às diversas necessidades administrativas, pedagógicas e operacionais da instituição, proporcionando uma experiência unificada para alunos, professores, funcionários e gestores.

### 🎯 Objetivo Principal

Centralizar e otimizar todos os processos administrativos e educacionais da escola através de uma plataforma única, moderna e intuitiva, eliminando a necessidade de múltiplos sistemas desconectados e melhorando significativamente a eficiência operacional.

---

## 🚀 Funcionalidades Principais

### 🏠 Página Inicial Institucional

A página inicial do Portal Salaberga foi cuidadosamente desenvolvida para servir como o **hub central** da escola, oferecendo:

- ✨ **Design moderno e responsivo** inspirado em estética Studio Ghibli
- 📰 **Seção de notícias e comunicados** atualizados
- 🎓 **Informações sobre cursos e programas** oferecidos
- 📅 **Calendário de eventos** e atividades escolares
- 🔗 **Acesso rápido aos subsistemas** baseado em permissões
- ♿ **Recursos de acessibilidade** integrados
- 📱 **Totalmente responsivo** para dispositivos móveis

### 🔐 Sistema de Autenticação Centralizado

- ✅ **Login seguro** com validação de credenciais
- 🔒 **Gerenciamento de sessões** robusto
- 👥 **Múltiplos tipos de usuário** (Administrador, Secretaria, Professor, Aluno, etc.)
- 🔑 **Sistema de permissões granular** por módulo
- 🔄 **Recuperação de senha** integrada
- 📧 **Primeiro acesso** com configuração de perfil

### 📊 Dashboard Personalizado

Cada tipo de usuário possui um **dashboard personalizado** que exibe:

- 🎯 **Acesso rápido** aos módulos permitidos
- 📈 **Estatísticas e métricas** relevantes ao perfil
- 🔔 **Notificações e alertas** importantes
- 📋 **Tarefas pendentes** e ações rápidas
- 🎨 **Interface adaptativa** conforme permissões

---

## 🏗️ Arquitetura

O Portal Salaberga segue uma arquitetura **modular e escalável**:

```
portalsalaberga/
├── app/
│   ├── index.php                    # Página inicial institucional
│   ├── main/                        # Sistema principal
│   │   ├── config/                  # Configurações (banco de dados)
│   │   ├── controllers/             # Controladores principais
│   │   ├── models/                  # Modelos e lógica de negócio
│   │   ├── views/                   # Visualizações
│   │   │   ├── autenticacao/        # Login, recuperação de senha
│   │   │   ├── perfil.php           # Perfil do usuário
│   │   │   └── subsystems.php       # Dashboard de subsistemas
│   │   └── assets/                  # Recursos estáticos
│   └── subsystems/                  # Módulos especializados
│       ├── entradaSaida/            # Controle de entrada/saída
│       ├── estagio/                 # Gestão de estágios
│       ├── financeiro/              # Sistema financeiro
│       ├── biblioteca/              # Gestão de biblioteca
│       └── ...                      # Outros subsistemas
└── default.php                      # Roteamento principal
```

### 🔌 Integração entre Módulos

Todos os subsistemas compartilham:
- 🔐 **Sistema de autenticação** centralizado
- 💾 **Banco de dados** unificado
- 🎨 **Design system** consistente
- 🔑 **Sistema de permissões** integrado
- 📱 **Responsividade** padronizada

---

## 📦 Subsistemas

O Portal Salaberga é composto por **múltiplos subsistemas especializados**, cada um atendendo a uma necessidade específica da escola:

### 🚪 Entrada e Saída ⭐

**Sistema completo de controle de entrada e saída de alunos**

- ✅ Registro de entrada e saída de alunos
- 💼 Registro específico para saídas de estágio
- 📊 Relatórios detalhados (individual, por turma, geral)
- 📄 Exportação em PDF
- 🔍 Sistema de QR Code para registro rápido
- 📱 Interface responsiva e moderna

📖 **[Documentação Completa](./portalsalaberga/app/subsystems/entradaSaida/README.md)**

---

### 🎓 Gestão de Estágio

**Sistema completo para gerenciamento de estágios**

- 📋 Cadastro e gestão de vagas de estágio
- 👥 Gerenciamento de alunos e empresas
- 📊 Relatórios de vagas e selecionados
- 🔍 Busca avançada de oportunidades
- 📄 Geração de documentos e relatórios

---

### 💰 Sistema Financeiro

**Controle financeiro completo da instituição**

- 💵 Gestão de receitas e despesas
- 📊 Relatórios financeiros detalhados
- 📄 Geração de documentos fiscais
- 📈 Análises e gráficos financeiros
- 💳 Controle de pagamentos

---

### 📚 Biblioteca

**Sistema de gestão de acervo bibliográfico**

- 📖 Cadastro de livros e materiais
- 🔄 Controle de empréstimos e devoluções
- 👥 Gestão de usuários da biblioteca
- 📊 Relatórios de movimentação
- 🔍 Busca avançada no acervo

---

### 📦 Controle de Estoque

**Gestão completa de materiais e equipamentos**

- 📦 Cadastro de produtos e materiais
- 📊 Controle de entrada e saída
- 🏢 Gestão de ambientes e setores
- 📋 Solicitações e liberações
- 📈 Relatórios e estatísticas
- 📄 Controle de perdas

---

### 🍽️ Alimentação

**Sistema de gestão de refeições escolares**

- 🍽️ Controle de cardápios
- 👥 Gestão de alunos e permissões
- 📊 Relatórios de consumo
- 🎯 Sistema para administradores e alunos

---

### 📋 Banco de Questões

**Plataforma para criação e gestão de questões**

- ❓ Cadastro de questões por disciplina
- 📝 Criação de provas e avaliações
- 🔍 Busca e filtros avançados
- 📊 Banco de questões organizado

---

### 👥 Gerenciador de Usuários

**Sistema centralizado de gestão de usuários**

- 👤 Cadastro e edição de usuários
- 🔑 Gerenciamento de permissões
- 🏢 Gestão de setores
- 📊 Controle de acessos

---

### 🎭 SESMATED

**Sistema de gestão de eventos e competições**

- 🎪 Gestão de múltiplas modalidades (Cordel, Empreendedorismo, Esquete, etc.)
- 📋 Inscrições e cadastros
- 📊 Painel administrativo
- 📄 Geração de relatórios e documentos

---

### 📝 Registro PCD

**Sistema especializado para alunos com deficiência**

- 👤 Cadastro de alunos PCD
- 🏥 Registro médico e observações
- 📊 Acompanhamento diário
- 📄 Relatórios e exportação

---

### 🏛️ Tombamento

**Sistema de gestão de patrimônio**

- 🏢 Cadastro de bens patrimoniais
- 📊 Controle de tombamento
- 📄 Documentação e relatórios

---

### 📊 Sistema PDT

**Plano de Desenvolvimento Técnico**

- 📋 Gestão de planos de desenvolvimento
- 📊 Acompanhamento de progresso
- 📄 Documentação técnica

---

### 🗳️ Formulário Grêmio

**Sistema de gestão de eleições do grêmio estudantil**

- 🗳️ Inscrições de chapas
- 📊 Acompanhamento de eleições
- ✅ Inscrições aprovadas

---

### 🎯 Seleção Grêmio

**Sistema de votação para grêmio**

- 🗳️ Sistema de votação
- 📊 Resultados e estatísticas
- 🔐 Controle de acesso

---

### 📋 Demandas

**Sistema de gestão de demandas**

- 📝 Criação e acompanhamento de demandas
- 👥 Gestão para usuários e administradores
- 📊 Relatórios de demandas

---

### 🏢 Espaço e Equipamentos

**Gestão de espaços físicos e equipamentos**

- 🏢 Cadastro de espaços
- 🔧 Gestão de equipamentos
- 📊 Controle de uso

---

### 📊 SS (Sistema de Suporte)

**Sistema de suporte e atendimento**

- 🎫 Gestão de tickets
- 👥 Atendimento ao usuário
- 📊 Relatórios de suporte

---

## 🔐 Sistema de Autenticação e Permissões

### 🔑 Autenticação Centralizada

Todos os subsistemas utilizam o **mesmo sistema de autenticação**, garantindo:

- ✅ **Login único** para toda a plataforma
- 🔒 **Sessões seguras** com validação em todas as páginas
- 🔄 **Redirecionamento automático** para login quando necessário
- 🔐 **Criptografia** de senhas
- 📧 **Recuperação de senha** integrada

### 👥 Tipos de Usuário

O sistema suporta múltiplos perfis com permissões específicas:

| Perfil | Descrição | Acessos |
|--------|-----------|---------|
| **Administrador** | Acesso total ao sistema | Todos os módulos e configurações |
| **Secretaria** | Gestão administrativa | Registros, relatórios, cadastros |
| **Professor** | Acesso pedagógico | Consultas, relatórios, avaliações |
| **Aluno** | Acesso estudantil | Consultas pessoais, formulários |
| **Portaria** | Controle de acesso | Entrada/saída, consultas básicas |
| **Coordenador** | Gestão de área | Módulos específicos da área |

### 🔐 Controle de Permissões

Cada subsistema verifica as permissões do usuário através de variáveis de sessão:

```php
// Exemplo de verificação de permissão
if (isset($_SESSION['Entrada e Saida'])) {
    // Acesso permitido ao módulo
}
```

O dashboard principal (`subsystems.php`) exibe apenas os módulos aos quais o usuário tem acesso, criando uma experiência personalizada.

---

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 7.4+** - Linguagem principal
- **MySQL** - Banco de dados relacional
- **PDO** - Abstração de banco de dados

### Frontend
- **HTML5** - Estrutura
- **CSS3** - Estilização
- **JavaScript** - Interatividade
- **TailwindCSS** - Framework CSS utilitário
- **Alpine.js** - Framework JavaScript leve
- **Swiper.js** - Carrosséis e sliders

### Bibliotecas e Ferramentas
- **FPDF** - Geração de PDFs
- **PHP QR Code** - Geração de QR Codes
- **Font Awesome** - Ícones
- **Google Fonts** - Tipografia (Nunito, Comfortaa, Raleway, Inter)

### Design
- **Paleta de cores institucional** (Verde Ceará: #008C45)
- **Design responsivo** (Mobile First)
- **Acessibilidade** (WCAG guidelines)

---

## 📖 Instalação

### 📋 Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior (ou MariaDB 10.3+)
- Servidor web (Apache/Nginx)
- Extensões PHP necessárias:
  - PDO
  - PDO_MySQL
  - GD (para manipulação de imagens)
  - mbstring
  - json

### 🚀 Passos de Instalação

1. **Clone o repositório**:
```bash
git clone [seu-repositorio]
cd Salaberga
```

2. **Configure o servidor web**:
   - Configure o DocumentRoot para apontar para `portalsalaberga/`
   - Ative o módulo `mod_rewrite` (Apache)
   - Configure as permissões adequadas

3. **Configure o banco de dados**:
   - Crie um banco de dados MySQL
   - Importe os scripts SQL necessários
   - Configure as credenciais em `app/main/config/connect.php`

4. **Configure as variáveis de ambiente**:
   - Ajuste as configurações de conexão
   - Configure URLs base se necessário
   - Ajuste timezone: `date_default_timezone_set('America/Sao_Paulo')`

5. **Configure permissões**:
```bash
chmod -R 755 portalsalaberga/
chmod -R 777 portalsalaberga/app/main/assets/fotos_perfil/
```

6. **Acesse o sistema**:
   - Navegue até `http://seu-dominio/portalsalaberga/app/index.php`
   - Faça login com credenciais de administrador
   - Configure os primeiros usuários

### 🔧 Configuração do Banco de Dados

Edite o arquivo `app/main/config/connect.php`:

```php
private $host = 'localhost';
private $dbname = 'portal_salaberga';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

---

## 📁 Estrutura de Diretórios

```
Salaberga/
├── portalsalaberga/
│   ├── app/
│   │   ├── index.php              # Página inicial
│   │   ├── main/                  # Sistema principal
│   │   │   ├── config/           # Configurações
│   │   │   ├── controllers/      # Controladores
│   │   │   ├── models/           # Modelos
│   │   │   ├── views/            # Visualizações
│   │   │   └── assets/           # Recursos estáticos
│   │   └── subsystems/           # Subsistemas
│   │       ├── entradaSaida/     # ⭐ Sistema de entrada/saída
│   │       ├── estagio/          # Gestão de estágios
│   │       ├── financeiro/      # Sistema financeiro
│   │       ├── biblioteca/       # Gestão de biblioteca
│   │       ├── controle_de_estoque/  # Controle de estoque
│   │       ├── alimentacao/      # Sistema de alimentação
│   │       ├── banco_questoes/   # Banco de questões
│   │       ├── gerenciador_usuario/  # Gestão de usuários
│   │       ├── sesmated/         # Sistema SESMATED
│   │       ├── registro_pcd/     # Registro PCD
│   │       ├── tombamento/       # Tombamento
│   │       ├── sist_PDT/         # Sistema PDT
│   │       ├── form_gremio/      # Formulário grêmio
│   │       ├── selecao_gremio/   # Seleção grêmio
│   │       ├── demandas/         # Sistema de demandas
│   │       ├── espaco_equipamentos/  # Espaços e equipamentos
│   │       └── SS/               # Sistema de suporte
│   └── default.php               # Roteamento
└── README.md                     # Este arquivo
```

---

## 🎨 Design System

### Paleta de Cores

O Portal Salaberga utiliza uma **paleta de cores institucional** baseada nas cores do Ceará:

- **Verde Principal**: `#008C45` (Verde Ceará)
- **Verde Claro**: `#00b357`
- **Verde Oliva**: `#8CA03E`
- **Laranja**: `#FFA500`
- **Branco**: `#FFFFFF`

### Tipografia

- **Títulos**: Comfortaa, Nunito (Google Fonts)
- **Corpo**: Nunito, Inter, Raleway
- **Ícones**: Font Awesome 6.0

### Características de Design

- ✨ **Interface moderna e limpa**
- 📱 **Totalmente responsiva** (Mobile First)
- 🎭 **Animações suaves** e transições
- ♿ **Acessibilidade** (WCAG 2.1)
- 🌈 **Feedback visual** imediato
- 🎨 **Design consistente** em todos os módulos

---

## 🔄 Fluxo de Uso

1. **Acesso Inicial**: Usuário acessa a página inicial institucional
2. **Login**: Realiza login com credenciais
3. **Dashboard**: Visualiza dashboard personalizado com módulos permitidos
4. **Navegação**: Acessa subsistemas conforme permissões
5. **Operações**: Realiza operações específicas em cada módulo
6. **Logout**: Encerra sessão de forma segura

---

## 📊 Estatísticas do Projeto

- 📦 **20+ subsistemas** integrados
- 👥 **Múltiplos perfis** de usuário
- 🔐 **Sistema de permissões** granular
- 📱 **100% responsivo**
- 🎨 **Design system** unificado
- 🔄 **Integração completa** entre módulos

---

## 🚀 Melhorias Futuras

- [ ] API REST para integrações externas
- [ ] App mobile nativo
- [ ] Dashboard com gráficos interativos
- [ ] Notificações em tempo real
- [ ] Sistema de backup automático
- [ ] Integração com sistemas externos (SEI, etc.)
- [ ] Melhorias de performance
- [ ] Testes automatizados
- [ ] Documentação de API
- [ ] Sistema de logs avançado

---

## 👥 Equipe de Desenvolvimento

Desenvolvido pela equipe de desenvolvimento da **EEEP Salaberga Torquato Gomes de Matos**.

**Área DEV 001** - A primeira área de desenvolvimento que fez história! 🚀

---

## 📝 Licença

Este projeto é propriedade da **EEEP Salaberga Torquato Gomes de Matos** e está destinado ao uso interno da instituição.

---

## 📞 Suporte

Para suporte técnico ou dúvidas:
- Entre em contato através do portal principal
- Acesse a secretaria da escola
- Utilize o sistema de suporte (SS) integrado

---

## 📚 Documentação Adicional

- **[Sistema de Entrada e Saída - Documentação Completa](./portalsalaberga/app/subsystems/entradaSaida/README.md)** ⭐

---

<div align="center">

**Desenvolvido com ❤️ para a EEEP Salaberga Torquato Gomes de Matos**

*Transformando educação através da tecnologia*

[⬆ Voltar ao topo](#-portal-salaberga---plataforma-educacional-completa)

</div>

