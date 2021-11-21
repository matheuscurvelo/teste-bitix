# Consumindo a API

## plano

`GET | /api/plano`
    
- Preenche o arquivo proposta.json ao retornar a resposta.


`GET | /api/plano/[codigo]`



## beneficiario

- `GET | /api/beneficiario`

- `GET | /api/beneficiario/[nome]`

- `DEL | /api/beneficiario/[nome]`

- `POST | /api/beneficiario`

    - Campos que precisam ser enviados no POST:

        Campo      | tipo
        -----------| -------
        nome       | string
        idade      | int
        quantidade | int
        registro   | string

    - para que seja possivel ser efetuado o cadastro do beneficiario:
        - O registro escolhido deve existir no plano;
        - A quantidade informada deve ser compatível com o campo "mínimo_vidas" do registro do plano escolhido;
        - O nome deve ser único.

- `PUT | /api/beneficiario/[nome]`

    - Campos que precisam ser enviados no PUT:

        Campo      | tipo
        -----------| -------
        nome       | string
        idade      | int
        quantidade | int
        registro   | string

    - para que seja possivel ser efetuado a alteração do beneficiario:
        - segue a mesma regra do método POST.


# front-end

`/plano`

`/beneficiario`