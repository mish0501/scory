<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Резултати за стая №{{ $code }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            table td{
                padding: 5px;
                text-align: center;
                border: 2px solid #000;
            }
        </style>
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <td>Номер в стаята</td>
                    <td>Име</td>
                    <td>Фамилия</td>
                    <td>Брой точки</td>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->number }}</td>
                        <td>{{ explode(' ', $student->user->name)[0] }}</td>
                        <td>{{ explode(' ', $student->user->name)[1] }}</td>
                        <td>{{ $student->correct }}</td>
                    </tr>
                @endforeach
            </tbody>           
        </table>
    </body>
</html>