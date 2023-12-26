API desenvolvida para um sistema de IOT a fim de estudos.
O uso do código é livre, eu o forneço completamente de forma gratuita para qualquer fim.

#-=x=-Usuários:-=x=-

##Formato das Requisições:

**GET =>** Requisições desse tipo são as mais simples, basta somente acrescentar ao fim da
url "/?user&", depois é necessário declarar usuário e senha, dessa forma:
        _"http://localhost/tstapicom/?user&user=email@email.com&password=123456789"_
Dessa forma é informado a API o usuário e senha e a API retorna a resposta com algumas 
informações do usuário ou uma mensagem de erro.


**POST =>** Requisições desse tipo necessitam de um corpo e um cabeçalho. Nessa API o corpo
das requisições são feitas através do json:

*{*
    *"email" : "email@email.com",*
    *"password" : "123456789",*
    *"user" : "User_name",*
    *"f_name" : "First_name",*
    *"l_name" : "Last_name"*
*}*

Com este corpo é possivél cadastrar um novo usuário no banco de dados (o email não estiver já cadastrado).


**DELETE =>** Requisições do tipo **DELETE** são usadas para deletar um usuário, seu corpo é da forma a seguir:

*{*
   *"email" : "email@email.com",*
    *"password" : "123456789",*
    *"user" : "person",*
    *"id" : "73",*
    *"token" : "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxNzAzNjkyMzA0IiwiaWQiOiIxMyIsInVzZXIiOiJhbFx1MDBlOXgiLCJmaXJzdF9uYW1lIjoiQWxleCIsImxhc3RfbmFtZSI6IlVtIE5vbWUgUXVhbHF1ZXIifQ==.rCo\/Gb1Eu6sqaMeYo1D7sV72vmt87sM80RhEh3vPh4Y="*
*}*

O token que vai no corpo da requisição, necessita ser um Token válido que foi gerado pelo próprio controlador da API.