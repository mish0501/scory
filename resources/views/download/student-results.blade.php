<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $student->name }} {{ $student->lastname }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            table td{
                padding: 5px;
                text-align: center;
                border: 2px solid #000;
                wrap-text: true;
                vertical-align: middle;
            }

            .correct {
                background-color: #00FF00;
            }

            .correct_checked {
                background-color: #0FF;
            }

            .wrong_checked {
                background-color: #F00;
            }
        </style>
    </head>
    <body>
    
        @if(!empty($questions))
            <table border="1">
                <thead>
                    <tr>
                        <td colspan="3" width="90">Име: {{ $student->name }} {{ $student->lastname }}</td>
                        <td colspan="3" width="90">Номер в стаята: {{ $student->number }}</td>
                        <td colspan="3" width="90">Брой точки: {{ $student->correct }}</td>
                    </tr>
                    <tr>
                        <td width="50">Въпрос</td>
                        <td colspan="8" width="240">Отговори</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td width="30">
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
                                    width="30"
                                >
                                    {{ $question->answers[$i]->name }}
                                </td>  
                                @else
                                    <td width="10"></td>
                                @endif
                            @endfor
                        </tr>
                    @endforeach
                </tbody>           
            </table>
        @else
            <table>
                <tr>
                    <td width="50">Няма намери данни за този ученик.</td>
                </tr>
            </table>
        @endif
    </body>
</html>