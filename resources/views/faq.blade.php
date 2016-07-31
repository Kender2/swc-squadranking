@extends('web')

@section('title')
    F.A.Q.
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            No questions yet.
        </div>
        <hr/>
    </div>

    <div class="row">
        <form class="form-horizontal" method="POST" action="{{ action('FAQController@form') }}">
            {!! csrf_field() !!}

            <div class="form-group @if ($errors->has('question')) has-error @endif">
                <div class="col-sm-offset-2 col-sm-8">
                    <label>Ask a question</label>
                    <input maxlength="512" class="form-control" type="text" name="question"
                           value="{{ old('question') }}"
                           placeholder="Question">
                    @if ($errors->has('question'))
                        <div class="text-danger">{{ $errors->first('question') }}</div> @endif
                </div>
            </div>

            <input type="text" name="agreement" id="inputAgreement" style="display: none" title="agreement">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-default" id="inputSubmit" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
