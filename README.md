<p align="center">
  <a href="#" target="blank">
    <img src="https://raw.githubusercontent.com/6aleatorio6/DicioSimples/refs/heads/main/server/public/img/logo-icon.png" width="200" alt="DicioSimples Logo" />
  </a>
</p>

# 📖 DicioSimples - Explicações Simples para Palavras

DicioSimples é um dicionário que apresenta definições de forma simplificada, facilitando a compreensão de palavras e auxiliando pessoas com dificuldades de leitura.

O projeto foi desenvolvido como uma iniciativa pessoal para praticar e aprender tecnologias como Laravel, Inertia, Vue e Tailwind CSS.

- **Hospedagem:** Acesse a aplicação no Heroku: [DicioSimples](https://dicio-simples-ca91bbd4773b.herokuapp.com/)
- **Design:** Confira o layout no Figma: [DicioSimples_design](https://www.figma.com/design/0mgMmrnNyHO5ZqdFRU50Yw/DicioSimples_design?t=dUstjOjv33S30mqp-0)
  
## Funcionalidades

> **Obs:** Todas as páginas são responsivas, garantindo uma ótima experiência de uso em dispositivos móveis e desktops.

### Página de Pesquisa

A página inicial conta com um campo de busca que exibe sugestões conforme o usuário digita. Essas sugestões são geradas com o Hunspell, que, apesar de não ter sido criado para esse propósito, tem funcionado bem.

  <img src="https://github.com/user-attachments/assets/a15a74cf-5372-4a2b-b764-546118a9614d" width="555" alt="Sugestões" />

### Página da Palavra

Nesta página, o conteúdo de uma palavra (ex.: `/words/pamonha`) é exibido seguindo o fluxo:

1. **Verificação de Cache:** Confere se a palavra já está armazenada.
2. **Validação:** Caso não esteja, valida a palavra utilizando o mesmo serviço da busca.
3. **Consulta:** Se válida, realiza uma busca no banco de dados; caso contrário, exibe um erro.
4. **Geração de Conteúdo:** Se a palavra não existir no banco, o backend aciona o Gemini para gerar a explicação.
5. **Armazenamento:** O conteúdo gerado é salvo em cache e a página é exibida.

  <img src="https://github.com/user-attachments/assets/775cb692-906d-4e11-998b-9fe5e94a7098" width="555" alt="Página da palavra" />

### Página de Erro

Caso alguém tente acessar o conteúdo de uma palavra inexistente, a página de erro é exibida.

  <img src="https://github.com/user-attachments/assets/a12704ba-ca79-42cf-9de0-c8a5dff9e249" width="555" alt="Erro" />



## Instalação

A documentação do backend está disponível aqui: [/server/README.md](/server/README.md)






