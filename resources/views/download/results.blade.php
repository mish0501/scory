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
            }

            .correct {
                background-color: green;
            }

            .correct_checked {
                background-color: cyan;
            }

            .wrong_checked {
                background-color: red;
            }

            .page-break {
                page-break-after: always;
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
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->lastname }}</td>
                        <td>{{ $student->correct }}</td>
                    </tr>
                @endforeach
            </tbody>           
        </table>
    </body>
</html>