

<div class="row">
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'facebook']), 'fa fa-facebook mr-3', 'Facebook', array('class' => 'btn numo-btn-fb ')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'twitter']), 'fa fa-twitter mr-3', 'Twitter', array('class' => 'btn numo-btn-twt')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'google']), 'fa fa-google-plus mr-3', 'Google +', array('class' => 'btn numo-btn-goog')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'github']), 'fa fa-github mr-3', 'GitHub', array('class' => 'btn numo-btn-git')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'youtube']), 'fa fa-youtube mr-3', 'YouTube', array('class' => 'btn numo-btn-yt')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'twitch']), 'fa fa-twitch mr-3', 'Twitch', array('class' => 'btn numo-btn-twi')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => 'instagram']), 'fa fa-instagram mr-3', 'Instagram', array('class' => 'btn numo-btn-insta')) !!}
    </div>
    <div class="col-sm-3 mb-5 text-center">
        {!! HTML::icon_link(route('social.redirect',['provider' => '37signals']), 'fa fa-signal mr-3', 'Basecamp', array('class' => 'btn numo-btn-signa')) !!}
    </div>
</div>
