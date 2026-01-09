# estudaAI 🚀

O **estudaAI** é uma plataforma de organização de estudos desenvolvida em Laravel/PHP, inspirada no sistema Estudei. O objetivo é oferecer uma alternativa robusta para estudantes que buscam organizar seus cronogramas, acompanhar o progresso em editais e gerenciar revisões de forma eficiente.

## ✨ Funcionalidades

- **Dashboard Inteligente**: Visualize seu tempo total de estudo, progresso geral e atividades recentes.
- **Planos de Estudo**: Crie múltiplos planos focados em diferentes concursos ou exames (ex: ENEM, PRF).
- **Edital Verticalizado**: Gerencie disciplinas e tópicos, marcando o que já foi estudado e revisado.
- **Registro de Estudos**: Cronometre suas sessões e registre detalhes como tipo de estudo (teoria, questões, etc.), acertos e comentários.
- **Sistema de Revisões**: Acompanhe revisões programadas para garantir a retenção do conteúdo.
- **Cronômetro Integrado**: Timer flutuante disponível em todas as páginas para facilitar o controle do tempo.

## 🛠️ Tecnologias Utilizadas

- **Framework**: Laravel 10
- **Autenticação**: Laravel Breeze (Blade)
- **Frontend**: Tailwind CSS & Alpine.js
- **Banco de Dados**: MySQL (compatível com SQLite para desenvolvimento local)
- **Padrão de Projeto**: MVC (Model-View-Controller)

## 🚀 Como Executar

1. Clone o repositório:
   ```bash
   git clone https://github.com/vitusiuva/estudaAI.git
   ```
2. Instale as dependências:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Configure o arquivo `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Execute as migrations:
   ```bash
   php artisan migrate
   ```
5. Inicie o servidor:
   ```bash
   php artisan serve
   ```

## 📈 Futuras Implementações

- Integrações com Inteligência Artificial para sugestão de cronogramas.
- Gráficos avançados de desempenho por disciplina.
- Exportação de relatórios em PDF.

---
Desenvolvido com foco em produtividade e organização.

---
*Última atualização de estabilidade: 09/01/2026 - Correção de ordem de migrations.*
