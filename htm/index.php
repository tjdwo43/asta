<?
	include "../inc/header.php";
?>
		<!-- 본문 내용 -->
		<div id="page-wrapper">
<?
if($_GET[viewMode] =='IDINSERTALL'){
	include "idinsertall.php";
} else if($_GET[viewMode] =='ORDERWRITE'){
	include "orderwrite.php";
} else if($_GET[viewMode] =='DRIVERS'){
	include "drivers.php";
} else {
?>
			<div class="row">
				<div class="col-xs-12">
					<h3 class="page-header"><img src="/images/bar.png" >&nbsp;<?=$title1?></h3>
				</div>
				<div class="col-xs-12">
						<!-- /.panel-heading -->

							<div class="table-responsive">
								{ROWTRS}
								<table class="table table-hover" >
									{ROWTR}
								</table>
							</div>
							<!-- /.table-responsive -->
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->

				<!-- /.col-lg-6 -->
			</div>
<?
}
?>
		<!-- 본문내용 끝 -->
<?
	include "../inc/footer.php";
?>
