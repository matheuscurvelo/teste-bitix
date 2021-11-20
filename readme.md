# Consumindo a API

## plano

`GET | /api/plano`

`GET | /api/plano/[codigo]`



## beneficiario

- `GET | /api/beneficiario`

- `GET | /api/beneficiario/[nome]`


- `POST | /api/beneficiario`

    - Campos que precisam ser enviados no POST

        Campo      | tipo
        -----------| -------
        nome       | string
        idade      | int
        quantidade | int
        registro   | string

    - para que seja possivel ser efetuado o cadastro do beneficiario:
        - O registro escolhido deve existir no plano
        - A quantidade informada deve ser compatível com o campo "mínimo_vidas" do registro do plano escolhido