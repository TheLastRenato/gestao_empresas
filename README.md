# Gestão de Empresas

## Visão Geral

Este repositório contém um sistema de **gestão de empresas** desenvolvido com **PHP** e **CSS**. O projeto oferece funcionalidades completas para gerenciar alunos, instrutores, veículos, agendamentos e relatórios em uma plataforma web.

## Funcionalidades Principais

- **Autenticação e Login**: Sistema seguro de login e logout
- **Gestão de Alunos**: Cadastro, consulta, edição e exclusão de alunos
- **Gestão de Instrutores**: Gerenciamento completo de instrutores
- **Gestão de Veículos**: Controle de frota de veículos
- **Agendamentos**: Sistema de agendamento de aulas e serviços
- **Relatórios**: Geração de relatórios diversos
- **Sidebar Navegável**: Interface intuitiva com menu lateral

## Tecnologias Utilizadas

- **PHP**: Linguagem de programação backend
- **CSS**: Estilização e design responsivo
- **MySQL/Banco de Dados**: Armazenamento de dados (conexão.php)
- **HTML**: Estrutura das páginas

## Estrutura do Projeto

O projeto está organizado da seguinte forma:

### Autenticação
- `login.php`: Página de login
- `autenticar.php`: Processamento de autenticação
- `logout.php`: Logout do sistema
- `verificar_login.php`: Verificação de sessão

### Gestão de Alunos
- `alunos.php`: Listagem de alunos
- `cadastro-alunos.php`: Cadastro de novos alunos
- `editar-alunos.php`: Edição de dados de alunos
- `excluir-alunos.php`: Exclusão de alunos
- `consulta-alunos.php`: Consulta avançada de alunos

### Gestão de Instrutores
- `instrutores.php`: Listagem de instrutores
- `cadastro-instrutores.php`: Cadastro de instrutores
- `editar-instrutores.php`: Edição de instrutores
- `excluir-instrutores.php`: Exclusão de instrutores
- `consulta-instrutores.php`: Consulta de instrutores

### Gestão de Veículos
- `veiculos.php`: Listagem de veículos
- `cadastro-veiculos.php`: Cadastro de veículos
- `editar-veiculos.php`: Edição de veículos
- `excluir-veiculos.php`: Exclusão de veículos
- `consulta-veiculos.php`: Consulta de veículos

### Agendamentos
- `agendamento.php`: Gerenciamento de agendamentos
- `agendar.php`: Criar novo agendamento
- `editar-agendamento.php`: Editar agendamento
- `excluir-agendamento.php`: Cancelar agendamento
- `atualizar-agendamento.php`: Atualizar status

### Relatórios
- `relatorios.php`: Página principal de relatórios
- `relatorio.css`: Estilos para relatórios

### Configuração
- `conexao.php`: Arquivo de conexão com banco de dados
- `sidebar.php`: Componente de navegação lateral

## Como Instalar e Rodar

### Pré-requisitos

- PHP 7.0 ou superior
- Servidor web (Apache, Nginx, etc.)
- MySQL ou similar
- Navegador web moderno

### Instalação

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/TheLastRenato/gestao_empresas.git
   cd gestao_empresas
   ```

2. **Configure o banco de dados:**
   - Edite o arquivo `conexao.php` com suas credenciais de banco de dados
   - Importe o arquivo SQL (se disponível) para criar as tabelas

3. **Inicie o servidor:**
   ```bash
   php -S localhost:8000
   ```

4. **Acesse a aplicação:**
   - Abra seu navegador e vá para `http://localhost:8000`
   - Faça login com suas credenciais

## Segurança

- Sempre use variáveis de ambiente para credenciais sensíveis
- Implemente validação de entrada em todos os formulários
- Use prepared statements para prevenir SQL injection
- Mantenha o PHP e dependências atualizadas

## Contribuindo

Se você deseja contribuir para este projeto:

1. Faça um fork do repositório
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT.

## Suporte

Para dúvidas ou problemas, abra uma issue no repositório GitHub.
