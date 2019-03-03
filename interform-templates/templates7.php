<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            margin: 5px 0 5px 0;
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


        #theImageId{
            width: 100%;
            height: 100%;
            border: solid gainsboro;
            margin-top: -15px;
        }



        img:after {
            content: "\f1c5" " " attr(alt);
            font-size: 0px;
            color: rgb(100, 100, 100);
            display: block;
            position: absolute;
            z-index: 2;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
        }

    </style>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col">
            <a href="https://www.interform400.com/en/">
                <img src="logotype.png" width="300" style="margin: 10px 0 10px 0;" alt="interform logo"></a>
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
require_once 'databaseIF.php';


function start_fieldset() {

    echo '<br>    
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div data-spy="scroll" data-offset="0" style="height: 600px; overflow: auto; padding: 0 15px 0 0;">';


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

function add_label($id, $name, $extraName, $version) {
        $sChild = '
                    <tr id="'.$id.'" class="getImage"
                        data-target="#multiCollapseExample-1"
                        aria-expanded="false"
                        aria-controls="multiCollapseExample-1">
                            <td class="selection"></td>
                            <td>' . $name . '</td>
                            <td>' . $extraName . '</td>
                            <td>' . $version . '</td>
                    </tr>
    ';

    echo $sChild;
}


try {
    $sQuery1 = $db->prepare
    ("select l.id, l.name, l.extra_name, l.version, l.category_id_fk, l.description, c.category from label as l 
  join category as c on c.category_id = l.category_id_fk order by l.category_id_fk, l.name");
    $sQuery1->execute();
    $aTemplates = $sQuery1->fetchAll();

    $currentTemplateId = -1;

    start_fieldset();

    foreach ($aTemplates as $aTemplate) {

        if ($aTemplate['category_id_fk'] == -1) {
            start_category($aTemplate['category']);
            add_label($aTemplate['id'], $aTemplate['name'], $aTemplate['extra_name'], $aTemplate['version']);
        }
        elseif ($currentTemplateId == $aTemplate['category_id_fk']) {
            add_label($aTemplate['id'], $aTemplate['name'], $aTemplate['extra_name'], $aTemplate['version']);
        }
        else {
            end_category();
            start_category($aTemplate['category']);
            add_label($aTemplate['id'], $aTemplate['name'], $aTemplate['extra_name'], $aTemplate['version']);
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

    <div id="multiCollapseExample-1">

<!--        <div class="collapse multi-collapse" id="multiCollapseExample-1">-->


        <div class="container">
            <h2 id="theTitleId">Templates for your individual packages</h2><br>
            <div class="row">

                <div class="col-12 col-md-4">
                    <p id="descriptionId">
                        Unique to InterForm Automotive Solution is that all our templates comes with support.
                        It means that you no longer have to convert guidelines into templates.
                        As part of our solution we not only give you access to hundreds of templates.
                        We also take care of the maintenance for you.
                    </p>
                </div>

                <div class="col-12 col-md-8">
                    <div class="card card-body text-center" style="border: 0;">
                        <img id="theImageId" src="templates.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</div><br><br>

<div class="container-fluid" style="background-color: #f0f0f0; padding: 30px;">
    <div class="row justify-content-center">
        <div class="col-10">
        <p>
            InterForm Automotive Solution is a very powerful output management specifically designed for the automotive industry.
            Our 30+ years in the industry have told us that you may change ERP but you hardly ever change industry.
            Therefore the solution is packaged with all the tools you need to operate the industry and even better
            it is designed to work with any ERP or even with multiple ERPs at the same time.
        </p></div>
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
<script src="jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>


<script>

    $('tr').click(function() {

        var theId = this.id;
        console.log('calling the backend with ' + theId);

        // blank out content before loading
        // to not have any old content in case nothing is found

        $('#theImageId').attr("src", "");
        $('#descriptionId').text("");
        $('#theTitleId').text("");

        $.get( "api-get-image.php", {"id":theId}, function() {
            console.log( "success" );
        })
            .done(function(data) {
                console.log( "second success" + data );

                let obj = JSON.parse(data);
                $('#descriptionId').text(obj.description);

                $('#theTitleId').text(obj.title);

                if (obj.image) {
                    let source = "data:image/png;base64, " + obj.image;
                    $('#theImageId').attr("src", source);
                }

            })
            .fail(function() {
                console.log( "error" );
            })
            .always(function() {
                console.log( "finished" );
            });

    });


</script>

</html>
