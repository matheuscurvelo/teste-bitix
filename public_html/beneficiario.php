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
                    <h1 class="display-5">Beneficiários</h1>
                </div>

                <table id="table" class="table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th><a type="button" id="cadastrar" class="text-white bg-success rounded mr-2 px-1"><i class="fa fa-plus"></i></a>Nome</th>
                            <th>Idade</th>
                            <th>Registro</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template id="linha">
                            <tr>
                                <td><a type="button" class="text-white bg-danger rounded mr-2 px-1 remover"><i class="fa fa-times"></i></a><a type="button" class="nome editar text-primary">1</a></td>
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

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modo"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Idade</label>
                            <input type="number" name="idade" id="idade" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Registro</label>
                            <select name="registro" id="registro" class="form-control" required>
                                <option selected disabled>Selecione um registro</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Quantidade</label>
                            <input type="number" name="quantidade" id="quantidade" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            atualizarTabela();            
        });

        //cadastrar
        $('#cadastrar').on('click',function () { 
            $('#modo').html('Cadastrar');
            $('#modal').modal('show');
            atualizarPlanos();

            document.getElementsByTagName('form')[0].reset();
            $('#nome').data('search','');
        });

        //editar
        $(document).on('click', '.editar', function(){
            $('#modo').html('Editar');
            atualizarPlanos();
            
            $.ajax({
                type: "GET",
                url: "/api/beneficiario/" + $(this).data('search'),
                dataType: "json",
                success: function(response) {
                    response = response.dados;
                    $('#modal').modal('show');

                    $('#nome').val(response.nome).data('search',response.nome);
                    $('#idade').val(response.idade);
                    $('#registro').val(response.registro);
                    $('#quantidade').val(response.quantidade);

                },
                error: function (response) {
                    response = response.responseJSON;
                    alert(response.message);
                    $('#modal').modal('hide');

                },
            });
        });

        //remover
        $(document).on('click', '.remover', function(){
            if (confirm('Deseja Remover este beneficiário')) {

                $.ajax({
                    type: "DELETE",
                    url: "/api/beneficiario/" + $(this).data('search'),
                    dataType: "json",
                    success: function(response) {
                        atualizarTabela();
                        alert(response.message);
                    },
                    error: function (response) {
                        response = response.responseJSON;
                        alert(response.message);

                    },
                });
            }
        });

        $('form:eq(0)').submit(function (e) { 
            e.preventDefault();

            if ($('#nome').data('search') == '') {

                $.ajax({
                    type: "POST",
                    url: "/api/beneficiario",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        alert(response.message);
                        atualizarTabela();
                        document.getElementsByTagName('form')[0].reset();

                    },
                    error: function (response) {
                        alert(response.responseJSON.message);
                    },
                });       

            } else {

                $.ajax({
                    type: "PUT",
                    url: "/api/beneficiario/" + $('#nome').data('search'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        alert(response.message);
                        atualizarTabela();
                    },
                    error: function (response) {
                        alert(response.responseJSON.message);
                    },
                });       

            }
                 
        });

        function atualizarTabela() {
            $.ajax({
                type: "GET",
                url: "/api/beneficiario",
                dataType: "json",
                success: function(response) {
                    $('#table tbody tr').remove();

                    $.map(response.dados, function(element) {
                        $('#table tbody').append($('#linha').html());
                        $('#table tbody .remover:last()').data('search',element.nome);
                        $('#table tbody .nome:last()').html(element.nome).data('search',element.nome);
                        $('#table tbody .idade:last()').html(element.idade);
                        $('#table tbody .registro:last()').html(element.registro);
                        $('#table tbody .quantidade:last()').html(element.quantidade);
                        $('#table tbody .preco:last()').html(element.preco);
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
                    $('#registro option:not(:disabled)').remove();
                    $.map(response.dados, function (element) {
                        let option = $("<option></option>").val(element.registro).text(element.registro);
                        $('#registro').append(option);
                    });
                },
            });
        }


    </script>

</body>

</html>