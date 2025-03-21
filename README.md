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
  

### Funcionalidades 


![Demonstração do site](https://github.com/user-attachments/assets/5d0b2e5f-77a8-4308-94c8-3ee9c97f04c7)


#### 1. Busca Inteligente  
   Campo de pesquisa que sugere palavras enquanto o usuário digita, utilizando o [Hunspell](https://hunspell.github.io/) e cacheando as sugestões para futuras buscas.  A navegação pode ser feita pelas teclas down, up e enter, ou pelo mouse.

#### 2. Detalhes da Palavra  
   Ao selecionar uma palavra, o usuário é redirecionado para uma página com sinônimos, antônimos e explicações. Caso os dados não estejam no banco, uma requisição é feita para um serviço de LLM (Gemini), que gera os dados, e o backend os serializa no banco de dados e cache.

#### 3. Página de Erro Personalizada  
   Caso a palavra seja inválida, uma página de erro personalizada será exibida.


## Instalação

A documentação do backend está disponível aqui: [/server/README.md](/server/README.md)

## Desenvolvido por

**Leonardo L. Felix**  
Desenvolvedor Full Stack | [LinkedIn](https://www.linkedin.com/in/leonardo-l-felix/) | [GitHub](https://github.com/6aleatorio6)

  








