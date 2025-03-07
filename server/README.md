<p align="center">
  <a href="#" target="blank"><img src="https://raw.githubusercontent.com/6aleatorio6/DicioSimples/refs/heads/main/server/public/img/logo-icon.png" width="200" alt="DicioSimples Logo" /></a>
</p>

# Backend / Frontend Web

Construído com Laravel, Inertia.js, Vue.js e utilizando Redis e PostgreSQL como bancos de dados.

## Instalação para Desenvolvimento

1. Clone o repositório:

    ```bash
    git clone https://github.com/6aleatorio6/DicioSimples.git
    ```

2. Acesse o diretório do backend:

    ```bash
     cd DicioSimples/server
    ```

3. Crie um arquivo `.env` usando o `.env.example` como base:

    ```bash
    cp .env.example .env
    ```

4. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
5. Inicie o Sail (ele é um wrapper sobre Docker):

    ```bash
     sail up
    ```

6. Inicie o Vite em outro terminal (opcional, mas necessário para atualizar a página com as alterações nos arquivos):

    > Certifique-se de que o terminal esteja dentro da pasta 'server'

    ```bash
     sail npm run dev
    ```

7. Rode as migrações do banco de dados:
    ```bash
     sail artisan migrate
    ```

## Instalação para Produção

Certifique-se de que o servidor tenha os pacotes `hunspell` e `hunspell-pt-br` instalados para o funcionamento correto.

**Exemplo para sistemas baseados em Debian/Ubuntu:**

```bash
sudo apt-get install hunspell hunspell-pt-br
```
