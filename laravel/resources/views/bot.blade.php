<table>
    <thead>
    <tr>
        <th>Questions</th>
        <th>Answers</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $questions as $question)
        <tr>
            <td>{!! $question->question !!}</td>
            <td>{!! $question->answer !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>