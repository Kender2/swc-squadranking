@extends('web')

@section('title')
    F.A.Q.
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Why are wars from before june 22nd not included?</h5>
            <p>That's when the SWC devs stopped messing with the war requirements, levels and outposts and started keeping track of the opponents in the war history.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Can you make an exception for me and add my wars manually?</h5>
            <p>Only if you can provide and proof the unrecorded wars of al 13.000+ squads and then come help us type it all in ;)</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Where are you getting this data?</h5>
            <p>We have a droid logging in to the game and visiting all the squads. It notes down all the information it sees before moving on to the next squad.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> How is the skill change calculated?</h5>
            <p>Using the math in this paper: <a href="https://www.microsoft.com/en-us/research/wp-content/uploads/2007/01/NIPS2006_0688.pdf">"TrueSkill&trade;: A Bayesian Skill Rating System"</a></p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> How does the ranking work?</h5>
            <p>We use TrueSkill&trade;. It's an algorithm to determine the relative strength between opponents. <a href="http://www.moserware.com/2010/03/computing-your-skill.html">This site</a> has an excellent explanation. In short it looks more at <i>who</i> you win or lose from than <i>how much</i> you win or lose.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> When does a war appear on the site?</h5>
            <p>Our droid is programmed so that every squad should be updated roughly once every 24 hours. Sometimes a bit faster, sometimes a bit slower.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Why do we need {{ config('sod.win_threshold') }} victories to be ranked?</h5>
            <p>Because the skill determination algorithm needs to have enough data to work with to become accurate enough. And using the amount of wins rather than the amount of wars keeps out the losers.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> When will you provide ranking for windows server?</h5>
            <p>There are no current plans to provide ranking for the windows server. This may change if we can find a highly skilled and trustworthy extra engineer to help out.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Why are squad war matches so unfair?</h5>
            <p>Because the developers at Disney use their own matchmaking algorithms and not ours ;)</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> What does "Rep invested" mean?"</h5>
            <p>That is the amount of reputation points that that member has invested in their squad.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> What does "base strength" mean?</h5>
            <p>The base strength is an internal value that is used for matchmaking. It depends on the level of your HQ and SC (SquadCenter), turrets and traps. It is a MUCH better indicator of the strength of a base than HQ level.</p>
            <h5 class="text-info"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> What does "UL" mean?</h5>
            <p>UpLinks.</p>
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
