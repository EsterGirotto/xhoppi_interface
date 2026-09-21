# Xhopii

Loja acadêmica construída a partir das telas e imagens existentes e dos conceitos dos três PDFs e do exemplo Express fornecidos.

## Executar

Requer Node.js 22 ou mais recente. No terminal, dentro desta pasta:

```powershell
npm install
npm start
```

Abra http://127.0.0.1:3000. Não abra os HTML antigos diretamente: a aplicação precisa do servidor Node.js, e não do Apache/PHP do XAMPP.

### Configuração realizada com npm

Os comandos executados nesta pasta foram `npm init -y` (inicialização com respostas padrão) e `npm install express`. O primeiro preservou as configurações e os scripts existentes; o segundo instalou o Express e resolveu as dependências declaradas, gerando `package-lock.json`. Para reinstalar exatamente as versões desse arquivo, use `npm ci`.

No terminal usado para preparar o projeto, npm não estava no PATH. Por isso, o executável oficial foi disponibilizado por `pnpm --package=npm dlx npm`; os comandos completos executados foram `pnpm --package=npm dlx npm init -y` e `pnpm --package=npm dlx npm install express`. A inicialização e a instalação foram feitas pelo npm. Em uma instalação convencional do Node.js com npm, basta usar os comandos sem esse prefixo.

**Acesso inicial de demonstração:** usuário `admin`, senha `Xhopii123!`. Clientes criam uma conta em **Cadastrar** na tela de login e entram pelo e-mail cadastrado. Os dados são criados na primeira inicialização em `data/banco.json`; reiniciar o servidor preserva cadastros, produtos e pedidos.

## Funcionalidades

- Login com sessão, logout, senhas com salt e scrypt, credenciais lidas do JSON a cada login.
- Helmet, Morgan, compression e limite de cinco tentativas de login por IP a cada dez minutos (inclui tentativas bem-sucedidas).
- Validação no servidor, proteção CSRF e saída escapada nas páginas EJS.
- Administração: cadastro, consulta, busca, edição e exclusão de clientes, funcionários e produtos.
- Clientes: catálogo com busca e ordenação, detalhes, compra simulada e histórico dos próprios pedidos.
- Classes Produto, Mercado, Funcionario, Gerente e Diretor; herança e bônus por cargo.
- Valor total do estoque (preço × quantidade) e produto de maior preço.
- Cupom `XHOPII10`: 10% aplicado ao preço unitário, arredondado em centavos antes de multiplicar pela quantidade.
- Promises encadeadas e `setTimeout` para estoque, pagamento e envio simulados. Pagamento recusado não altera estoque; dupla submissão do mesmo formulário não gera outro pedido.
- JSON com `readFile`/`writeFile` de `node:fs/promises`, fila de operações e substituição do arquivo por rename para evitar gravação parcial.
- Visual e estrutura das telas fornecidas, usando exclusivamente o CSS original, as imagens e a fonte Roboto do projeto.

## Relação com o material

| Material | Aplicação no site |
| --- | --- |
| JS / Node / POO | `models/Produto.js`, `models/Mercado.js` e `models/Funcionario.js`: getters, setters, cupom, estoque, herança e cálculo de bônus. O percentual de gerente, deixado como x% no enunciado, é configurável na classe e usa 2% por padrão no formulário original. |
| JS / ES6 | Módulos `import`/`export`, template literals, `find`, `filter`, `map`, `sort`, `reduce`, arquivos JSON, Promises e async/await. Fluxo de compra em `services/compra.js`. |
| Express / Forms / Middleware | Servidor em `server.js`; formulários, rotas, login e middlewares em `app.js`; páginas EJS com HTML e CSS. |
| exemplo-api-mongodb.zip | Estrutura Express, arquivos estáticos, configuração `.env` e middlewares. O ZIP fornecido não continha driver, modelo ou conexão MongoDB; o adaptador opcional deste projeto implementa essa persistência. |

O pedido foi construir o Xhopii usando o material. Os exercícios independentes de alunos e hospital, leitura síncrona para alunos e a entrega pelo Teams descrita nos PDFs não são funcionalidades de uma loja e não foram tratados como tarefas adicionais. Nenhuma entrega externa foi realizada.

### Preservação da interface original

Os HTML originais em `views`, o EJS original de clientes e `assets/css/style.css` permanecem intactos. As páginas ativas em `views/app` são adaptações dessas mesmas telas para EJS: mantêm cabeçalho, menu, banners, rodapé, classes, IDs e campos originais. As mudanças se limitam à ligação com o servidor: URLs, valores dinâmicos, ações dos formulários, campos ocultos de segurança e resultados das consultas. Não há CSS novo ou sobrescrita de estilos. As páginas adicionais de detalhes, pedidos e avisos reutilizam os estilos existentes.

O servidor aceita os nomes originais, como `inputEmailLog`, `inputSenhaLog` e `inputNomeProd`. O código do produto é gerado automaticamente porque não havia esse campo no formulário original. Para funcionários, os campos de POO ausentes na tela usam valores padrão: zero anos de trabalho, setor Geral, bônus de gerente de 2% e um setor para diretor; registros anteriores preservam seus valores durante edição. O cargo aceita Funcionário, Gerente ou Diretor. Os controles novos de busca e ordenação foram retirados das telas originais; as consultas por parâmetros na URL permanecem disponíveis.

## MongoDB opcional

Copie `.env.example` para `.env`, mantenha um MongoDB acessível e preencha:

```dotenv
MONGODB_URI=mongodb://127.0.0.1:27017
MONGODB_DATABASE=xhopii
```

Reinicie o servidor. O MongoDB usa a coleção `estado` com um documento acadêmico de estado da loja. A atualização de estoque e pedido é atômica no mesmo documento; um contador de revisão impede sobrescrever alterações concorrentes entre processos. Dados JSON não são migrados automaticamente. Se a conexão falhar, o servidor informa o erro e não inicia silenciosamente em outro modo.

Esse formato é voltado a uma demonstração pequena e está sujeito ao limite de tamanho de documento do MongoDB. Não é um modelo de banco para uma loja de grande porte. O modo MongoDB requer uma instância fornecida pelo usuário; a validação local foi realizada com JSON.

## Testes

```powershell
npm test
```

Testes automatizados usam arquivos temporários e uma porta aleatória. Verificam cupom, bônus, valor do estoque, persistência, compras simultâneas, pagamento recusado, idempotência, autenticação, validação, CRUD, autorização, CSRF, escape de HTML e limite de login. Não alteram os dados da loja.

## Limites da demonstração

- Pagamento e envio são simulados; nenhum cartão ou serviço externo é utilizado.
- Os campos originais de seleção de foto foram preservados, mas upload ainda não é processado; novos produtos usam a primeira imagem da coleção. Login social, SMS e recuperação por e-mail não estão configurados.
- O cadastro de funcionários é administrativo e não cria credenciais de acesso.
- CPF recebe validação de formato de 11 dígitos, sem consulta externa ou validação dos dígitos verificadores.
- As sessões ficam em memória e expiram em duas horas; reiniciar exige novo login. O JSON suporta uma única instância do servidor. O host padrão é local (`127.0.0.1`).
- Antes de publicação real, substituir a credencial de demonstração, configurar HTTPS, cookie seguro, armazenamento durável de sessão e revisão de acesso/dados pessoais.

Os campos de integrantes do `README.md.txt` original continuam disponíveis para preencher com os nomes e RAs reais.
