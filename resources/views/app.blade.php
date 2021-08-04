<!doctype html>
<html lang="en">

<head>

    <?php
    $its_hot = !is_dir( base_path('public/vue-assets'));
    $manifest_contents = $its_hot ? [] : json_decode(file_get_contents(base_path('public/vue-assets/manifest.json')), true);

    $time = date('h-i-s');
    ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@3.x/css/materialdesignicons.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"/>

    @if($its_hot)
        <link href="http://127.0.0.1:8081/js/app.js" rel="preload" as="script"/>
        <link href="http://127.0.0.1:8081/js/chunk-vendors.js" rel="preload" as="script"/>
    @else
        <?php
        foreach ($manifest_contents as $key => $value) {
        $extension = explode(".", $key);
        if (is_array($extension) && end($extension) === "css") {
        ?>
        <link rel="stylesheet" href="{{url('vue-assets/'.$value.'?t='.$time)}}"/>
        <?php
        }
        }
        ?>
    @endif
</head>


<body style="height: 100vh">
<div id="soradius_app"></div>
@if($its_hot)
    <script type="text/javascript" src="http://127.0.0.1:8081/js/app.js"></script>
    <script type="text/javascript" src="http://127.0.0.1:8081/js/chunk-vendors.js"></script>
@else
    <?php
    foreach ($manifest_contents as $key => $value) {
    $extension = explode(".", $key);
    if (is_array($extension) && end($extension) === "js") {
    ?>
    <script defer type="text/javascript" src="{{url('vue-assets/'.$value.'?t='.$time)}}"></script>
    <?php
    }

    }
    ?>

@endif

</body>
</html>
