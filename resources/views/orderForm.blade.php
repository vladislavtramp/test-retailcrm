<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="container">
                <form method="post" action="/send">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">ФИО</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name">
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Комментарий клиента</label>
                        <input type="text" class="form-control" name="comment" id="comment">
                    </div>
                    <div class="mb-3">
                        <label for="articulate" class="form-label">Артикул товара</label>
                        <input type="text" class="form-control" name="articulate" id="articulate">
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Бренд товара</label>
                        <input type="text" class="form-control" name="brand" id="brand">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Заказать</button>
                </form>
            </div>
        </div>
    </body>
</html>
