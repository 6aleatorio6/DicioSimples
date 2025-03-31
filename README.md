<p align="center">
  <a href="#" target="blank">
    <img src="https://raw.githubusercontent.com/6aleatorio6/DicioSimples/refs/heads/main/server/public/img/logo-icon.png" width="200" alt="Logo do DicioSimples" />
  </a>
</p>

# 📖 DicioSimples - Explicações Simples para Palavras

> Esse projeto está sendo desenvolvido com foco no aprendizado das tecnologias Laravel, Inertia, Vue e Tailwind CSS.

DicioSimples é um dicionário que apresenta definições simplificadas das palavras, utilizando a API do Gemini para gerar essas definições e as serializando no banco de dados.

- **Hospedagem:** O projeto está disponível online através do plano estudante da Heroku: [DicioSimples](https://dicio-simples-ca91bbd4773b.herokuapp.com/)
- **Design:** Confira o layout no Figma: [DicioSimples_design](https://www.figma.com/design/0mgMmrnNyHO5ZqdFRU50Yw/DicioSimples_design?t=dUstjOjv33S30mqp-0)
  


## Funcionalidades

### Público

Busque e explore palavras de forma rápida e simples.

![Demonstração do site](https://github.com/user-attachments/assets/5d0b2e5f-77a8-4308-94c8-3ee9c97f04c7)

1. **Busca Inteligente**  
   Sugestões enquanto digita, com cache para buscas futuras. Navegação por teclas ou mouse.

2. **Detalhes da Palavra**  
   Exibe sinônimos, antônimos e explicações. Se não houver dados, o sistema solicita ao Gemini.

3. **Página de Erro Personalizada**  
   Exibe uma página personalizada caso a palavra não seja encontrada.


### Administração

A interface administrativa permite gerenciar as palavras do dicionário.

![dicio-simpes_adm](https://github.com/user-attachments/assets/58764095-3afd-4961-a484-49b086bf6ead)

1. **Login e Autenticação**  
   Acesso ao painel com conta criada no terminal:

   > ```sh  
   > php artisan create:user {name} {email} {password}  
   > ```

2. **Gerenciamento de Palavras**  
   - Tabela paginada para otimização e carregamento eficiente dos registros.  
   - Pesquisa rápida de palavras.  
   - Detalhamento em modal com mais informações.  
   - Exclusão de palavras (não impede regeneração).

3. **Gerenciamento de Usuários**  
   - Edição e exclusão da conta administrativa.


## Instalação

A documentação do backend está disponível aqui: [/server/README.md](/server/README.md)

## Desenvolvido por

**Leonardo L. Felix**  
Desenvolvedor Full Stack | [LinkedIn](https://www.linkedin.com/in/leonardo-l-felix/) | [GitHub](https://github.com/6aleatorio6)

