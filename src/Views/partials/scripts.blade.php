<!-- SCRIPTS -->

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/1.1.3/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ $monkyz_assets }}js/monkyz.min.js"></script>

@if(!empty($scripts['datatables']))
	<!--  Datatables     -->
	<script src="//cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>

	<script>
		{!! $scripts['datatables'] !!}
	</script>
@endif