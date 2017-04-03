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
        </style>
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <td colspan="3">Име: {{ $student->name }} {{ $student->lastname }}</td>
                    <td colspan="3">Номер в стаята: {{ $student->number }}</td>
                    <td colspan="3">Брой точки: {{ $student->correct }}</td>
                </tr>
                <tr>
                    <td>Въпрос</td>
                    <td colspan="8">Отговори</td>
                </tr>
            </thead>

            <tbody>
                @if($questions != "")
                    @foreach($questions as $question)
                        <tr>
                            <td>
                                {{ $question->name }}
                            </td>

                            @for($i = 0; $i < 8; $i++)
                                @if(isset($question->answers[$i]))
                                <td 
                                    @if($question->answers[$i]->checked && !$question->answers[$i]->correct)
                                        class="wrong_checked"                                    
                                    @elseif($question->answers[$i] && $question->answers[$i]->checked)
                                        class="correct_checked"
                                    @elseif($question->answers[$i]->correct)
                                        class="correct"
                                    @endif
                                >
                                    {{ $question->answers[$i]->name }}
                                </td>  
                                @else
                                    <td></td>
                                @endif
                            @endfor
                        </tr>
                    @endforeach
                @else
                    <td colspan="9">Няма намери данни за този ученик.</td>
                @endif
            </tbody>           
        </table>
    </body>
</html>