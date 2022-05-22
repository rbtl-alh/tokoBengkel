<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="panel panel-default">
        <div class="panel-heading"><h1>Products</h1></div>
        <div class="panel-body">
            <div class="row">
                @foreach ($response as $product)
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                               
                                <div class="caption">
                                    <h3>{{ $product->name }}</h3>
                                    
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>

        </div>
    </div>
</body>
</html>