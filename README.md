# Sistema de Locação de Máquinas Pesadas

Sistema web para gestão do processo de locação de máquinas (empilhadeiras e afins), desenvolvido como projeto de TCC (Trabalho de Conclusão de Curso) em Engenharia de Computação e aplicado como solução real para uma empresa do ramo de locação de equipamentos.

O sistema cobre todo o fluxo comercial: cadastro de clientes, funcionários e máquinas, geração de propostas comerciais, conversão de proposta em contrato, e emissão automática de PDFs dos documentos.

> **Status:** projeto em produção, atualmente em uso por uma empresa real do ramo de locação de máquinas, com contratos ativos gerados pelo sistema. Segue em desenvolvimento contínuo junto com a empresa, com novas funcionalidades e ajustes sendo implementados conforme a necessidade do negócio.

> **Nota:** por se tratar de um projeto usado em produção por uma empresa real, dados sensíveis (credenciais, CNPJ, CPF, contratos gerados) foram removidos ou substituídos por informações fictícias neste repositório público.

## Funcionalidades

- **Autenticação** de funcionários com sessão e senha criptografada
- **Cadastro e gestão** de clientes, funcionários e máquinas
- **Propostas comerciais**: criação, listagem e geração de PDF
- **Contratos**: conversão automática de proposta aceita em contrato, com atualização de status da máquina (disponível → em uso)
- **Geração de PDF automatizada** via Puppeteer (Node.js), a partir de templates HTML renderizados dinamicamente
- **Controle de status** de máquinas (disponível, pendente, em uso, em manutenção, inativa)
- **Vagas de emprego**: módulo para cadastro e gestão de vagas

## Tecnologias

**Back-end**
- PHP (orientado a objetos, PDO para acesso ao banco)
- MySQL

**Geração de documentos**
- Node.js + [Puppeteer](https://pptr.dev/) (renderiza o HTML da proposta/contrato e converte em PDF)

**Front-end**
- HTML, CSS, JavaScript
- Bootstrap
- DataTables (jQuery)

## Arquitetura

O projeto segue uma separação simples em camadas:

```
├── controller/     # Regras de negócio e endpoints (um por entidade: cliente, contrato, maquina, proposta...)
├── model/          # Conexão com banco (PDO) e classes de entidade
├── view/           # Telas (PHP + HTML), organizadas por módulo
├── assets/         # CSS, JS, imagens e uploads
└── SysContrato.sql # Schema do banco de dados
```

A geração de PDF funciona assim: o controller recebe os dados do formulário, salva um JSON temporário, e chama um script Node.js (`gerar_pdf_puppeteer.js`) que abre a página do contrato/proposta em um Chrome headless e exporta como PDF.

## Como rodar localmente

### Pré-requisitos
- PHP 7.4+ com extensão PDO MySQL
- MySQL
- Node.js
- Google Chrome instalado (usado pelo Puppeteer)

### Passos

1. Clone o repositório e instale as dependências do Node:
   ```bash
   npm install
   ```

2. Crie o banco de dados executando o `SysContrato.sql` no seu MySQL.

3. Copie o arquivo de exemplo de variáveis de ambiente e preencha com os dados do seu banco local:
   ```bash
   cp .env.example .env
   ```
   ```
   DB_HOST=localhost
   DB_NAME=nome_do_banco
   DB_USER=usuario_do_banco
   DB_PASS=senha_do_banco
   ```

4. Suba o projeto com um servidor PHP (ex: Apache/XAMPP, ou `php -S localhost:8000` na raiz do projeto).

5. Acesse pelo navegador e faça login com um funcionário cadastrado no banco.

## Autor

Desenvolvido por Bruno S. Belli como projeto de TCC em Engenharia de Computação.
