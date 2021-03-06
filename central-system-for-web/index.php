<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Organizaciones existentes</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Organizaciones <span class="sr-only">(current)</span></a>
            </li>
        </ul>

    </div>
</nav>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Organizaciones</h1>
            <p class="lead">Organizaciones existentes</p>
            <table id="organization_list" class="table">


            </table>

        </div>
        <div class="col-lg-12 ">
            <div class="card-body">
                <div class="row">crear una nueva organizacion</div>
                <form id="form">
                    <div class="form-group">
                        <input type="text" name="id" class="form-control mb-2" placeholder="id">
                        <input type="text" name="name" placeholder="nombre" class="form-control mb-3">
                        <input type="text" name="legalEntity" placeholder="legal entity" class="form-control">
                        <input type="submit" id="submit" class="btn btn-outline-info" value="Crear">
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.js"  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>



<script type="text/javascript">

    //fdelete one organization
    var $delete=function()
    {
        $('.delete').click(function () {
            $.ajax({
                url: '../central-system-api/Organizations.php?id=' + $(this).val(),
                type: 'delete',
                timeout: 500,
                success: function (result) {
                    location.reload();
                }
            })
        });
    };

    //get all the values and set them in the table
    $(document).ready(function(){
            $.ajax(
                {
                    url: '../central-system-api/Organizations.php',
                    dataType: 'json',
                    timeot: 500,
                    success: function (data, status) {

                        data.forEach(function (elem) {
                            $("#organization_list").append("<tr><td>" + elem.id + "</td><td>"+elem.name+"</td><td>"+elem.legalEntity+
                                "</td><td><button class='delete btn btn-danger' value='" + elem.id+ "' > </button>"+
                                "<a href='OrganizationEditView.php?id="+ elem.id +"' class='btn'>ver</a></td></tr>");
                        });

                        $delete();

                    }
                }
            )

    });


    //send the form to create new organization.
    $(document).ready(function(){

        $("#submit").on('click', function(){

            $.ajax({
                url: '../central-system-api/Organizations.php',
                type : "POST",
                dataType : 'json',
                data : $("#form").serialize(),
                success : function(result) {

                }
            })
        });
    });

</script>


</body>
</html><?php
