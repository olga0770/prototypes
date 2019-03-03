<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>InterForm</title>

    <style>
        tr {
            background-color: #f0f0f0;
            cursor: pointer;
            margin-bottom: 5px;
            border: #ffffff 3px;
            border-style: solid none solid none;
        }

        tr:hover {
            background-color: #4c9bcc;
            color: #ffffff;
        }

        tr:active {
            background-color: #4c9bcc;
            color: #ffffff;


        }

        td {
            width: 300px;
            padding: 5px;
        }

        .selection {
            width: 80px;
        }



        summary {
            width: 100%;
            color: #ffffff;
            background-color: #1a6294;
            padding: 5px;
            margin-bottom: 5px;
            font-size: 24px;
        }

        tbody {
            border: 0;
        }

        .overview{
            background-color: #2F373F;
            padding: 10px 5px 7px 5px;
            text-align: center;
            color: white;
            font-size: 24px;
        }

        .wall{
            background: url("InterForm400_Header.png");
            background-color: #ffffff; /* Used if the image is unavailable */
            height: 500px; /* You must set a specified height */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-size: 400px; /* Resize the background image to cover the entire container */
        }
    </style>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col">
            <a href="https://www.interform400.com/en/">
                <img src="logotype.png" width="300" style="margin: 10px 0 10px 0;"></a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col overview">
            <p>Overview of available Templates for your individual packages</p>
            <h6>Tick the check-boxes to mark all Templates you need to demand an individual offer</h6>

        </div>
    </div>
</div>




<?php
require_once 'database.php';


function start_fieldset() {

    echo '<br>    
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div data-spy="scroll" data-offset="0" style="height: 500px; overflow: auto; padding: 15px;">';


    echo '<fieldset>';
}

function end_fieldset() {
    echo '</fieldset></div></div>';
}

function start_category($category) {
    echo "<details><summary>$category</summary><table>";
}

function end_category() {
    echo '</table></details>';
}

function add_label($id, $name) {
//        $sChild = '
//                    <tr data-toggle="collapse"
//                        data-target="#multiCollapseExample-' . $id . '"
//                        aria-expanded="false"
//                        aria-controls="multiCollapseExample-' . $id . '">
//                            <td class="selection"></td>
//                            <td>' . $name . '</td>
//                    </tr>
//    ';
    $sChild = '
                    <tr id="'.$id.'" class="getImage" data-toggle="collapse"
                        data-target="#multiCollapseExample-1"
                        aria-expanded="false"
                        aria-controls="multiCollapseExample-1">
                            <td class="selection"></td>
                            <td>' . $name . '</td>
                            <td></td>
                    </tr>
    ';

    echo $sChild;
}


try {
    $sQuery1 = $db->prepare
    ("select l.id, l.name, c.category, l.category_id_fk, l.description from label as l join category as c on c.category_id = l.category_id_fk order by l.category_id_fk, l.name");
    $sQuery1->execute();
    $aTemplates = $sQuery1->fetchAll();

    $currentTemplateId = -1;

    start_fieldset();

    foreach ($aTemplates as $aTemplate) {

        if ($aTemplate['category_id_fk'] == -1) {
            start_category($aTemplate['category']);
            add_label($aTemplate['id'], $aTemplate['name']);
        }
        elseif ($currentTemplateId == $aTemplate['category_id_fk']) {
            add_label($aTemplate['id'], $aTemplate['name']);
        }
        else {
            end_category();
            start_category($aTemplate['category']);
            add_label($aTemplate['id'], $aTemplate['name']);
        }
        $currentTemplateId = $aTemplate['category_id_fk'];
    }

    end_category();

    end_fieldset();


} catch (PDOException $exc) {
    echo "Sorry, system is updating ...";
}


?>

<div class="col-12 col-md-7">

    <div class="collapse multi-collapse" id="multiCollapseExample-1">

        <div class="container">
            <h2>VDA4902	A5 Version 4 (1996)</h2><br>
            <div class="row">

                <div class="col-12 col-md-4">
                    <p>
                        VDA 4902 and VDA-KLT-Label: Barcode Transport and Shipping Labels (VDA Labels) for
                        Automotive Manufacturers and Suppliers
                    </p>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-success">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Show
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" id="option2" autocomplete="off"> Download
                        </label>
                    </div>
                </div>


                <div class="col-12 col-md-8">
                    <br><div class="card card-body text-center">

                        <a href="VDA4902_A5_vda_Master.png" alt="template">
                            <img src="VDA4902_A5_vda_Master.png" alt="template" height="350px"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div>


<footer>

    <div class="container-fluid">
        <div class="row">
            <div class="col overview">
                <h6>If you are missing a trading partner in this list, please contact us. Maybe id will be added shortly.</h6>

            </div>
        </div>
    </div>
</footer>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>


<script>

    $(document).on('click', '.getImage', function(){
        console.log('test getImage')

        var getImage = $(this).attr('id')
        console.log('getImage:', getImage)

        $.ajax({
            url: "api-get-image.php",
            method: "GET",
            data: {"id": getImage},
            dataType: "JSON"
        }).done(function(jData){
            console.log(jData)
            if(jData.status){
                $(getImage).remove()
            }
        }).fail(function(uData){
            console.log('something went wrong with getting image')
        })

    })
</script>

</html>

