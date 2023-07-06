# school_back
Aplicação back-end para uma escola, utilizando **CodeIgniter**. Nesta aplicação, são gerenciadas as informações dos alunos da escola, permitindo a criação, leitura, atualização e exclusão dos registros. Além disso, há um sistema de autenticação que utiliza **JWT** (JSON Web Tokens) para efetuar a autorização dos usuários para a utilização dos serviços.

## Projeto

Para esse projeto, foi decidido implementar dois modelos: **Users** e **Students**. Os "users" guardam as informações dos usuários do sistema, ou seja, as credenciais de quem pode acessar o sistema. Já os "students" guardam as informações dos objetos do sistema em si, que são os alunos de uma escola. 

O controle dos estudantes é relativamente simples, com funções que leem, inserem, deletam e atualizam os registros no banco de dados. A maior complexidade é no filtro das rotas que efetuam essas ações, que controlam a autorização do usuário em utilizar essa rota.

O controle dos usuários é similar, porém envolve também a parte de criptografar as senhas dos usuários ao inserir e atualizar um novo usuário. Essa parte é importante, pois salvar a senha em plain-text é uma prática não recomendada pela possibilidade de vazamento dessas informações.

### 

### Autenticação e Autorização

Para proteger algumas rotas, e para que o usuário não precise enviar suas credenciais toda vez que precise fazer uma requisição, foi implementado um sistema de autenticação e autorização. A autenticação é feita com login do usuário e sua senha. Para fazer a autorização do usuário que já foi autenticado, foi escolhida a utilização de tokens, especificamente **JWT**. Assim, em toda requisição feita após o usuário se autenticar, é enviado um token que sinaliza o servidor que essa requisição foi feita por um usuário que já está devidamente autenticado.

### Foto do aluno

Foi decidido que a foto seria enviada juntamente com os outros dados do aluno, para enviar todas as informações em uma requisição apenas. Separar em mais requisições poderia gerar problemas de alguma das requisições não ser atendida com sucesso, gerando um estado inconsistente do bando de dados. Como a foto deve ser inserida como um campo no JSON da requisição, a foto deve ser codificada como texto. Para isso, utilizamos a codificação **base64**. A foto é então codificada no front-end e é enviada juntamente com as outras informações do aluno. Como a foto chega no back-end como uma string, consideramos que seria mais prático não decodificá-la e simplesmente armazená-la assim, já que teríamos que codificá-la novamente quando tivesse uma requisição para retornar um aluno. Essa solução tem principalmente o ponto negativo de ocupar mais espaço no banco de dados. Porém, como não se trata de uma aplicação com uma quantidade grande de imagens (um aluno pode possuir apenas uma foto), consideramos que o overhead de espaço supera o overhead de complexidade de decodificar e codificar a imagem, pelo menos num primeiro momento.

## Dados

Cada aluno possui os seguintes campos, com os respectivos tipos:

Campo                   | Tipo      
----------------------- | --------  
nome                    | VARCHAR 128      
sobrenome               | VARCHAR 128      
email                   | VARCHAR 128       
telefone                | VARCHAR 15       
endereço                | VARCHAR 128      
data de nascimento      | DATE      
foto                    | VARCHAR 1000000    

Cada usuário do sistema possui os seguintes campos e tipos:

Campo                   | Tipo      
----------------------- | --------  
name                    | VARCHAR 256      
email                   | VARCHAR 128      
password                | VARCHAR 255

A senha é criptografada com o algoritmo **CRYPT_BLOWFISH**.

## Endpoints

Essa aplicação expões uma API RESTful, com os seguintes end-points:

Endpoint                | Método    | Descrição
----------------------- | --------  |-------------------
auth/signup             | POST      | Cria um novo usuário
auth/signin             | POST      | Autentica um usuário
students                | GET       | Retorna um array com todos os alunos
students/(:num)         | GET       | Retorna um aluno cujo id é (:num)
students/add            | POST      | Cria um novo aluno
students/update/(:num)  | POST      | Atualiza aluno cujo id é (:num)
students/delete/(:num)  | DELETE    | Deleta aluno cujo id é (:num)

Para utilizar os endpoints `students` e `students/*`, é necessário enviar juntamente com a requisição um header do tipo:

```
Authorization: "Bearer " + <token>
```

onde `<token>` é o JWT token retornado ao realizar com sucesso o signin do usuário, pela rota `auth/signin`.

## Banco de Dados

Para rodar esta aplicação, você precisará de um servidor de banco de dados instalado e rodando em sua máquina, preferencialmente utilizando o **MySQL**. Com a ferramenta de sua preferência, crie um banco de dados novo para esta aplicação. As configurações do banco de dados para esta aplicação são encontradas no arquivo **.env**, na pasta raíz do repositório. Neste arquivo você poderá modificar o nome, usuário e senha para as informações do banco de dados que você criou, nas seguintes linhas:

```
database.default.database = <database_name>
database.default.username = <database_username>
database.default.password = <database_password>
```

## Instalação

1. Instale o servidor de banco de dados **MySQL** em sua máquina, inicie ele e crie um novo banco de dados. Garanta que exista um usuário para esse servidor em que o usuário da sua máquina consiga fazer login (o padrão é somente o root).

2. Instale o **php-cli**, **php-mysql**, **php-curl**, **php-intl** e o **phpunit** em sua máquina.

3. Instale o **composer**.

4. Clone este repositório e, na pasta raiz, execute o seguinte comando para instalar as dependências necessárias do projeto:

    ```
    > composer update
    ```

5. Faça uma cópia do arquivo **env** para **.env** e modifique o **.env** com as configurações do banco de dados que você criou, como mostrado em [Banco de Dados](#banco-de-dados).


6. Para criar as tabelas necessárias no seu banco de dados já configurado, basta executar o comando:

    ```
    > php spark migrate
    ```

7. (*Opcional*) Se você quiser popular sua tabela com alguns dados iniciais de alunos presentes neste repositório, execute o comando:

    ```
    > php spark db:seed StudentSeeder
    ```

8. Após instalado e configurado, basta você dar o seguinte comando para subir o servidor:

    ```
    > php spark serve
    ```

## Melhorias

O sistema está realizando todas as operações propostas, porém existem algumas melhorias a serem implementadas.

* Salvar foto como arquivo
    * A foto atualmente é salva como uma string base64 no banco de dados. Apesar de funcionar, essa maneira de armazenar o arquivo acaba gerando um overhead de espaço. Uma maneira de contornar isso seria salvar no banco de dados apenas um link para a imagem, que pode estar num servidor externo ou no próprio servidor onde o banco de dados se encontra.
* Fazer a atualização do token JWT
    * Atualmente o token não está sendo atualizado. Portanto, o cliente perde a conexão e tem que re-logar quando o token perde a validade. Uma maneira de contornar isso é atualizar o token de tempos em tempos para o usuário não perder a conexão. 
* Troca de senha
    * Ainda não há a funcionalidade de um usuário poder mudar a sua senha.