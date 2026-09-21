# Revisão da interface

Referência comparada: cópia do projeto inicial em `C:\Users\davi_\Downloads\xhopii\xhopii`.

Os 43 arquivos dessa cópia existem no projeto atual e foram comparados byte a byte: nenhum foi alterado. Isso inclui o CSS, as imagens, a fonte, os HTML, o EJS de clientes e o README original.

## Correção da página de produto

O material inicial tem `ver-produto.html`, que é uma listagem, mas não contém o HTML da página individual. Seu CSS já define `.produto-imagem`, `.produto-principal` e `.produto-detalhes`.

A página individual acrescentada estava dentro de `.conteudo-visualizar-box`, um contêiner flex destinado às listagens. Esse encaixe incorreto centralizava a imagem posicionada absolutamente e causava sobreposição. O HTML foi corrigido para separar imagem e detalhes nas colunas previstas pelo CSS. Os campos reutilizam `.botao`, já existente. Uma quebra que limpa os floats mantém o rodapé abaixo das colunas, sem novas regras CSS, estilos inline ou alterações por JavaScript.

## Resultado da comparação das páginas ativas

| Tela | Preservação e diferenças necessárias |
| --- | --- |
| Login | Mesmos campos, classes, IDs, áreas sociais e rodapé. Action corrigida, token oculto, validação e mensagens do servidor. |
| Cadastros de cliente, funcionário e produto | Mesmos campos visíveis, classes, IDs e rodapé. Actions, preenchimento para edição e campos ocultos de integração. |
| Recuperar senha | Mesmo formulário e rodapé. Informa que o envio de e-mail não está configurado. |
| Home | Mesmo menu, contêineres, banners e rodapé. Cartões demonstrativos repetidos substituídos por produtos reais do banco e mensagem de boas-vindas. |
| Ver produtos | Mesma estrutura de cartão, grade, menu e rodapé. Dados e links passam a vir do banco. |
| Clientes | Mesmos contêineres e bloco original de resultados. Mensagens e ações de edição/exclusão acrescentadas aos registros. |
| Funcionários | Mesmo espaço original reservado à consulta. Resultados inseridos nele usando o bloco já existente na tela de clientes. |
| Detalhes, pedidos, ajuda e avisos | Páginas acrescentadas à aplicação; não havia HTML equivalente no material inicial. Reutilizam o CSS fornecido, mas não devem ser apresentadas como cópias de telas originais. |

Nenhum banner, menu ou rodapé foi redesenhado. A quantidade e o texto dos cartões dependem dos dados cadastrados; portanto, páginas dinâmicas não são cópias estáticas pixel a pixel dos exemplos. Os testes verificam CSS, classes, campos, menus e rodapés. A página de detalhes foi inspecionada no navegador para conferir a separação entre imagem e formulário.

Limitações que já existiam no material, como medidas fixas, a grade de cinco colunas e links de rodapé com `#`, permanecem. Não foi criada responsividade adicional, pois isso exigiria alterar o CSS solicitado como imutável.
