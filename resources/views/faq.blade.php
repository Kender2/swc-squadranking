@extends('web')

@section('title')
    F.A.Q.
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Why are wars from before june 22nd not included?</h5>
            <p>That's when the SWC devs stopped messing with the war requirements, levels and outposts and started keeping track of the opponents in the war history.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> When does a war appear on the site?</h5>
            <p>Our droids are programmed so that every squad should be updated at least once every 24 hours.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> What is TrueSkill&trade;?</h5>
            <p>It's an algorithm to determine the relative strength between opponents. <a href="http://www.moserware.com/2010/03/computing-your-skill.html">This site</a> has an excellent explanation.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Why do we need 10 victories to be ranked?</h5>
            <p>Because the skill determination algorithm needs to have enough data to work with to become accurate enough. And using the amount of wins rather than the amount of wars keeps out the losers.</p>
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
