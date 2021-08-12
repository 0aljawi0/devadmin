<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name', 'Laravel')}} | Page Not Found</title>

        <link rel="stylesheet" href="{{asset('css/error.css')}}">

    </head>
    <body>
        <div class="container-fluid bg-dark">
            <div class="row vh-100 align-items-center"> 
                <div class="col">
                    @include('errors.icon')
                </div>
            </div>
        </div>
    </body>
</html>
