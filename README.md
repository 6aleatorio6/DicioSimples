# 📖 DicioSimples - Explicações Simples para Palavras

DicioSimples é um  dicionário com explicações mais fáceis de compreender, ajudando pessoas com dificuldades em leitura a aprender palavras novas. Será construido em PHP com Laravel, com um aplicativo em Flutter, utilizando MongoDB para armazenamento e Redis para cache das informações. Ele contará com testes e será hospedado na AWS

Inicialmente será apenas palavras do PT-BR, mas se o projeto se provar relevante terá também inglês.

## Funcionamento - Idealizando

1. Ao iniciar, é necessário carregar uma lista de palavras permitidas para as buscas.

2. Quando o usuário pesquisar uma palavra, a aplicação seguirá este fluxo:
   - **Redis**: Verifica se a palavra está em cache.
   - Se não encontrar, consulta o **MongoDB**.
   - Se não encontrar no MongoDB, o backend pede a explicação a um serviço LLM (GPT ou Gemini), salva no banco e em cache.
     
3. A tela da palavra exibe:
   - **Resumo**: Explicação simples gerada por uma LLM.
   - **Sinonimos**: Palavras parecidas.
   - **Áudio**: Botão para reproduzir o áudio, que será gerado na primeira vez e salvo para uso futuro.

### Futuro
- Possibilidade de login para histórico de palavras.

## links:

Figma: [DicioSimples_design](https://www.figma.com/design/0mgMmrnNyHO5ZqdFRU50Yw/DicioSimples_design?t=dUstjOjv33S30mqp-0)
