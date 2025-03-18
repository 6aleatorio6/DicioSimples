<p align="center">
  <a href="#" target="blank"><img src="https://raw.githubusercontent.com/6aleatorio6/DicioSimples/refs/heads/main/server/public/img/logo-icon.png" width="200" alt="DicioSimples Logo" /></a>
</p>

# Backend / Frontend Web

Construído com Laravel, Inertia.js, Vue.js e utilizando Redis e PostgreSQL como bancos de dados.

## Desenvolvimento

Para o setup de desenvolvimento, utilizei o [Sail](https://laravel.com/docs/11.x/sail#introduction), que serve como um wrapper em volta do Docker. Com isso, não é necessário ter o Node.js ou o PHP instalados na máquina.

### Instalação

1.  Clone o repositório:

    ```bash
    git clone https://github.com/6aleatorio6/DicioSimples.git
    ```

2.  Acesse o diretório do backend:

    ```bash
    cd DicioSimples/server
    ```

3.  Crie um arquivo `.env` com base no `.env.example`:

    > Não se esqueça de preencher a env `GEMINI_KEY` com a api key do Gemini

    ```bash
    cp .env.example .env
    ```

4.  Compile a imagem do Docker e instale as dependências e gere a chave:

    ```bash
    docker compose run --rm laravel.test bash -c "composer install && \
                                                     npm install && npm run build && php artisan key:generate"
    ```

5.  Adicione um Alias no terminal para o Sail:

    > Recomendo adicionar esse comando no seu arquivo `~/.zshrc` ou `~/.bashrc`

    ```bash
    alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
    ```

### Iniciar o Projeto

1.  Inicie o Sail:

    ```bash
    sail up
    ```

2.  Rode as migrações(Se não tiver feito):

    ```bash
    sail artisan migrate
    ```

3.  Inicie o Vite em outro terminal:

    ```bash
    sail npm run dev
    ```

## Produção

Certifique-se de que o servidor tenha os pacotes `hunspell` e `hunspell-pt-br` instalados para o funcionamento correto.

**Exemplo para sistemas baseados em Debian/Ubuntu:**

```bash
sudo apt-get install hunspell hunspell-pt-br
```
