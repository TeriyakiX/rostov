<div class="col-12 col-md-12">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="container">
                        <div class="form-group">
                            <label for="{{ $fieldName }}" style="margin-bottom:20px;">{{ $fieldData['title'] }}</label>
                            @if($positions)
                                <table>
                                    <tbody>
                                    @foreach($positions as $position)
                                        <tr>
                                            <td>
                                                {{ $position->title }}:
                                            </td>
                                            <td>
                                                {{($position->pivot->options) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
