#Sistema que cadastre empresas e o seu quadro societário:

1. Navegue para o diretório do backend:
   ```bash
   cd backend-empresas-socios
2. Construa e inicie os containers (os serviços que usam imagens serão apenas puxados):

   ```bash
   docker-compose up -d
Isso iniciará os containers do PostgreSQL, pgAdmin, Mailpit, etc.

Importante:
No arquivo .env ou .env.local, certifique-se de que a variável DATABASE_URL aponte para o serviço do Docker.
Em vez de usar 127.0.0.1 e a porta mapeada, use o nome do serviço e a porta interna. Exemplo:

env
Copiar
DATABASE_URL=pgsql://app:!ChangeMe!@database:5432/app
Migrations
Para gerar uma migration com base nas alterações das entidades:

```bash
php bin/console doctrine:migrations:diff
Para executar as migrations e atualizar o schema do banco:

```bash
php bin/console doctrine:migrations:migrate
Confirme quando solicitado.


   ```bash
   synfony serve
para inicar o servidor da api REST junto com a documentação Backend: http://localhost:8000/api/doc

Configuração do Frontend
Navegue para o diretório do frontend:

```bash
cd ../frontend-empresas
Instale as dependências:

```bash
npm install
Execute a aplicação Angular:

```bash
ng serve
A aplicação estará disponível em http://localhost:4200.

Uso e Testes
Backend:
Utilize ferramentas como Postman ou Insomnia para testar os endpoints da API (por exemplo, POST /api/empresas, PUT /api/empresas/{id}, DELETE /api/empresas/{id}, etc).

Frontend:
A aplicação Angular permite o gerenciamento de empresas e sócios por meio de modais para criação, edição e deleção.

Na listagem, clique no ícone de edição ou deleção de sócio para atualizar ou remover os registros.
O botão "Cadastrar Empresa" abre o modal para criação de uma nova empresa.
Os dados são enviados via ApiService e atualizados no banco de dados pelo backend.
Contato
Para dúvidas ou suporte, entre em contato:
