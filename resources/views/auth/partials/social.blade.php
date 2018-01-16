<h4>Entrar usando</h4>
<div class="col-md-8">
    <a href="{{ route('social.login', ['provider'=>'facebook']) }}" 
    class="btn btn-social-icon btn-facebook">
        <i class="fa fa-facebook"></i>
    </a>
    <a href="{{ route('social.login', ['provider'=>'google']) }}" 
    class="btn btn-social-icon btn-google">
        <i class="fa fa-google"></i>
    </a>
    <a href="{{ route('social.login', ['provider'=>'github']) }}" 
    class="btn btn-social-icon btn-github">
        <i class="fa fa-github"></i>
    </a>
</div>