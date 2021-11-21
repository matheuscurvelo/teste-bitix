<!doctype html>
<html lang="en">

<head>
    <title><?php echo ucfirst($url[0]); ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Bitix</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item ">
                    <a class="nav-link" href="/beneficiario">Beneficiario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/plano">Plano</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron-fluid mb-2">
                    <h1 class="display-5">Planos</h1>
                </div>

                <div class="form-group">
                    <select class="form-control" id="codigo">
                        <option selected disabled>Selecione um plano</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <b>Código:</b> <span id="codigoPlano"></span><br>
                    </div>
                    <div class="col-md-3">
                        <b>Registro:</b> <span id="registroPlano"></span><br>
                    </div>
                    <div class="col-md-4">
                        <b>Nome:</b> <span id="nomePlano"></span>
                    </div>
                    <div class="col-md-3">
                        <b>Preco Total:</b> <span id="totalPlano"></span>
                    </div>
                </div>

                <div class="card border-primary my-3">
                    <div class="card-header text-white border-primary bg-primary">
                        <h6>Preços deste plano</h6>
                    </div>
                    <div class="card-body">
                        <table id="tablePreco" class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Mínimo vidas</th>
                                    <th>faixa 1</th>
                                    <th>faixa 2</th>
                                    <th>faixa 3</th>

                                </tr>
                            </thead>
                            <tbody>
                                <template id="linhaPreco">
                                    <tr>
                                        <td class="minimo_vidas">1</td>
                                        <td class="faixa_1">2</td>
                                        <td class="faixa_2">3</td>
                                        <td class="faixa_3">4</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card border-success my-3">
                    <div class="card-header text-white border-success bg-success">
                        <h6>Beneficiários deste plano</h6>

                    </div>
                    <div class="card-body">
                        <table id="tableBeneficiario" class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Idade</th>
                                    <th>Registro</th>
                                    <th>Quantidade</th>
                                    <th>Preco</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template id="linhaBeneficiario">
                                    <tr>
                                        <td class="nomeBeneficiario">1</td>
                                        <td class="idade">2</td>
                                        <td class="registro">3</td>
                                        <td class="quantidade">4</td>
                                        <td class="preco">4</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            atualizarPlanos();
        });

        $('#codigo').on('change', function() {
            atualizarTabelas();
        });

        function atualizarTabelas() {
            $.ajax({
                type: "GET",
                url: "/api/plano/" + $('#codigo').val(),
                dataType: "json",
                success: function(response) {
                    response = response.dados;

                    $('#codigoPlano').html(response.codigo);
                    $('#registroPlano').html(response.registro);
                    $('#nomePlano').html(response.nome);
                    $('#totalPlano').html(response.preco_total);

                    $('#tablePreco tbody tr').remove();
                    $('#tableBeneficiario tbody tr').remove();

                    $.map(response.precos, function(element) {
                        $('#tablePreco tbody').append($('#linhaPreco').html());
                        $('#tablePreco tbody .minimo_vidas:last()').html(element.minimo_vidas);
                        $('#tablePreco tbody .faixa_1:last()').html(element.faixa1);
                        $('#tablePreco tbody .faixa_2:last()').html(element.faixa2);
                        $('#tablePreco tbody .faixa_3:last()').html(element.faixa3);
                    });

                    $.map(response.beneficiarios, function(element) {
                        console.log(element);
                        $('#tableBeneficiario tbody').append($('#linhaBeneficiario').html());
                        $('#tableBeneficiario tbody .nomeBeneficiario:last()').html(element.nome);
                        $('#tableBeneficiario tbody .idade:last()').html(element.idade);
                        $('#tableBeneficiario tbody .registro:last()').html(element.registro);
                        $('#tableBeneficiario tbody .quantidade:last()').html(element.quantidade);
                        $('#tableBeneficiario tbody .preco:last()').html(element.preco);
                    });
                }
            });
        }

        function atualizarPlanos() {
            $.ajax({
                type: "GET",
                url: "/api/plano",
                dataType: "json",
                success: function(response) {
                    $('#codigo option:not(:disabled)').remove();
                    $.map(response.dados, function(element) {
                        let option = $("<option></option>").val(element.codigo).text(element.nome);
                        $('#codigo').append(option);
                    });
                },
            });
        }
    </script>

</body>

</html>