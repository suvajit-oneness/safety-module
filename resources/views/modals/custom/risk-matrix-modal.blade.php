@section('partials_css')
	<link href="/css/custom/riskMatrixModal.css" rel="stylesheet"> 
@endsection


	<div id="popWindow" class="popup pop-shadow">
		<div class="pop-wrapper">
			<header>
				<div class="pop-header pop-drag">
					<div class="left pop-title">
						Quantitative Risk Matrix
					</div>
					<div class="right pop-control">
						<span class="pop-close" id="close-pop">X</span>
					</div>
				</div>
			</header>
			<div class="main-content">

				<img class="img-style" src="/images/RiskMatrix.png">
			</div>
			<footer>
				<div class="pop-header pop-drag">
					<div class="left pop-title">
						Click and Drag to move the image
					</div>
				</div>
			</footer>
		</div>
	</div>

@section('partial_scripts')
	<script src="\js\jquery\jquery-ui.js"></script>
	<script type="text/javascript" src="\js\custom\riskMatrixModal.js"></script>
@endsection