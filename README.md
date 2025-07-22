# Como não fazer um teste técnico

Recentemente me candidatei para um processo seletivo e tive uma surpresa bem desagradável logo na segunda etapa do processo.

Vamos por um segundo ignorar o fato que não tive contato com ninguém até o momento e vamos focar apenas no aspecto do que está sendo pedido do candidato:

Julgando pela vaga vs. cobrança, o teste técnico da vaga claramente não foi bem pensado. A vaga é para uma posição **fullstack**, mas o teste técnico envolve um teste de lógica (que foi relativamente trivial, mas não sem suas considerações), um teste de **frontend** e um teste de **backend**, _**SEPARADOS**_.

A expectativa do contratante aqui parece ser que o candidato realize, quase literalmente, _**o dobro de trabalho na metade do tempo**_. Vale lembrar: **O teste não é absurdo em termos de dificuldade**, Mas a expectativa de que você pode juntar o teste de back e de front (que foram pensados cada um para uma pessoa) em um processo só, com o mesmo prazo, é absurdo.

Também preciso trazer à tona que você claramente precisa pensar em como armazenar os dados, como você é levado a acreditar na descrição dos testes. Isso traz consigo: Modelagem de entidades e relacionamentos, estruturação e provisionamento de banco de dados. Eu acabei circulando essa necessidade usando arquivos JSON locais, mas a solução correta seria um banco SQL. Essa é uma expectativa realista para o processo seletivo de um Dev. Backend? Não sei, deixo no ar.

No geral me frustrei bastante com o processo e acabei largando mão, mas fica aqui em baixo minha análise.

# Backend

Começamos pelo back:

> O objetivo deste desafio é desenvolver uma API em PHP, que responda em formato JSON e permita o gerenciamento de cursos, turmas e usuários. O sistema simula um ambiente simples de cadastro de cursos e matrícula de alunos em turmas ofertadas.

OK, até aí tudo certo.

> Você tem até 7 dias para resolver e responder aqui &lt;link para envio&gt;
> Qualquer dúvida ou necessidade de negociar o prazo, ficamos à disposição, ok?

O prazo foi informado no email, sendo 7 dias para entregar tudo, tentei entrar em contato pra tirar algumas dúvidas, mas eles não pareciam estar à disposição. Vamos dar uma olhada nos requisitos.

## Requisitos

> 1. Deve ser possível criar, atualizar e excluir um curso. O curso deve possuir título, descrição, temas (inovação, tecnologia, marketing, empreendedorismo, agro) e URL de imagem
> 2. Deve ser possível criar, atualizar e excluir uma turma para um curso. Um curso pode ter múltiplas turmas. A turma deve possuir título, descrição, quantidade de vagas, status (disponível, encerrado), data de início e data de fim
> 3. Deve ser possível criar e excluir um usuário. O usuário deve possuir nome e email

Beleza! Estamos no caminho certo. Temos uma descrição das entidades envolvidas, seus relacionamentos, propriedades e métodos.

## Casos de uso

> 1. Deve ser possível criar um curso e criar turmas para esse curso

Ok... Mas isso não foi dito antes?

> 2. Cursos com turmas disponíveis devem ser listadas em um endpoint para visualização e deve possuir os seguintes filtros: filtro por título e filtro por temas

Eita, nos requisitos não tinha nada sobre listagem, mas tudo bem, incluimos o verbo GET

> 3. Deve ser possível matricular um usuário em uma turma disponível
> 4. Não deve permitir matricular um usuário em turmas encerradas ou fora da data de início e fim

Normal.

> 5. Deve ser possível listar todos os cursos que um usuário está matriculado
> 6. Um usuário não deve conseguir se matricular em mais de uma turma para o mesmo curso
>
> Fora de escopo:
>
> 1. Não é necessário implementar login e autenticação para o usuário

Também normal.

Pela parte do back, parece que está tudo certo! Tivemos uma pequena redundância no primeiro caso de uso e uma pequena surpresa no segundo, mas nada fora do comum.

## Diferenciais

Se fosse só isso, maravilha! Bota um Laravel e em umas horinhas tá pronto. Mas, como todo bom processo seletivo, temos os diferenciais. O que precisamos fazer para sair na frente desse processo?

> - Não usar frameworks como: Laravel, Symfony, etc
> - Documentar os endpoints da API
> - Utilizar Docker para configurar o ambiente
> - Testes automatizados

Beleza. Até essa altura do campeonato, eu não sabia quanto que ia ganhar nessa vaga. Deveria realmente me dar ao trabalho? Escrever um backend em PHP puro não é tão simples quanto parece, especialmente se você quer fazer algo manutenível, organizado, e que oferece uma experiência adequada ao usuário (tratamento de erros e validação de inputs, por exemplo)

Isso fora a consideração de documentar os endpoints (Entendo que isso pode ser um Swagger, que leva um certo tempo de fazer), Testes automatizados (Que leva um tempo considerável para estruturar, considerando que não temos frameworks, fora o tempo de escrever os testes mesmo).

O que vocês veem nesse repositório foi o máximo que consegui fazer dentro do prazo estimado, antes de começar a passar mal de estresse.

# Frontend

Achava que era só isso? Bora pro segundo desafio (dos três)

> O objetivo deste desafio é desenvolver uma interface web responsiva utilizando HTML, CSS e JavaScript, que consuma a API REST existente (em PHP) e permita visualizar e interagir com cursos, turmas e matrículas de usuários. A API será em conjunto com o desafio.

Como vocês podem imaginar, a API não foi enviada (porque eu precisava desenvolver ela). Esses são os requisitos:

> 1. Listagem de Cursos e Turmas:
>
> - Listar cursos com suas turmas disponíveis (status = "disponível")
> - Filtros:
>   - Por título (campo de busca)
>   - Por temas (checkbox: inovação, tecnologia, marketing, empreendedorismo, agro)

Depois do back, sem surpresas aqui

> 2. Cadastro de Usuário:
>
> - Formulário com:
>   - Nome
>   - E-mail
>   - Botão "Cadastrar"
> - Exibir mensagem de sucesso ou erro

Novamente, bem padrão

> 3. Matrícula:
>
> - Exibir botão "Matricular" nas turmas disponíveis
> - Ao clicar, solicitar o e-mail ou seleção de um usuário existente

Como não temos autenticação, associamos usuários e turmas usando esse processo

> 4. Validar regras de negócio:
>
> - Não permitir matrícula em turma encerrada
> - Não permitir matrícula duplicada (mesmo usuário em duas turmas do mesmo curso)
> - Não permitir matrícula fora da data de início e fim

Também, bem padrão

> 5. Visualizar Matrículas:
>
> - Campo para selecionar ou digitar um usuário
> - Listar cursos e turmas em que ele está matriculado

Temos aqui outro requisito de back surpresa: Para escolhermos um usuário, precisamos de um endpoint de busca de usuários. A listagem de cursos e turmas matriculadas já estava previsto, então não é tão ruim.

Novamente, estamos falando aqui de um desafio, então vamos aos diferenciais:

> - Não utilizar nenhum framework para SPA como Vue, React ou Angular
> - Não utilizar bibliotecas/frameworks de CSS como Bootstrap, Material UI ou Tailwind CSS
> - Interface responsiva e com boa usabilidade

Rapaz...

# Análise dos fatos

Dois projetos inteiros sem frameworks? Em uma semana? Integrando com banco de dados, fazendo tratamento de entradas, documentando endpoints, e escrevendo CSS responsivo E COM BOA USABILIDADE? Um pouco demais para uma semana, não acha?

Adicione a isso o fato que eu ainda tenho um emprego de tempo integral, e uma casa para cuidar. Onde sobra tempo pra resolver tudo isso? Eu acho que mesmo que diferenciais sejam "pontos adicionais", deveria ser algo POSSÍVEL de ser realizado dentro do prazo oferecido, mas não sei se isso seria possível nesse caso.

# Bônus - Desafio de lógica

Esse foi divertido, dá uma olhada:

> Faça um programa (em qualquer linguagem, mas em modo Shell) que o usuário informa quantas linhas (altura) uma pirâmide deve conter e também informar qual caractere será utilizado para desenhar essa pirâmide.
> O usuário também deve escolher se serão desenhadas 1, 2 ou 3 pirâmides na mesma linha
> O usuário também deve escolher se a pirâmide será exibida normal ou de ponta cabeça

Bem tranquilo, padrão

> Após apresentar a(s) pirâmide(s), o programa deve apresentar o total de linhas de todas as pirâmides

...Mas essa não é a altura que o usuário fornece?

> Caso o usuário tenha escolhido mais de 1 pirâmide a ser exibida, o programa deve deixar a pirâmide da esquerda invisível. Lembre-se que dois corpos não ocupam o mesmo lugar no espaço

Hã?

Vamos lá. O usuário pediu 1 pirâmide, mostramos 1 pirâmide. O usuário pediu 2 pirâmides, mostramos 1 pirâmide (já que a da esquerda está invisível). O usuário pediu 3 pirâmides, mostramos 2 pirâmides (já que a da esquerda está invisível). Faz sentido pra você? Pra mim não faz.

De qualquer forma, inclui o código da solução desse cara na pasta [logica](/logica), ficou bem bonitinho, mas não inclui esses últimos dois requisitos (por que eles não fazem sentido). Só rodar com `deno run main.ts`
