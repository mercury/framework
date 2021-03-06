<?php $this->layout($gs_template, $ga_templatedata) ?>

<section class="content-header">
	<h1>
		Config Variable <small>preview of simple tables</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Simple</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Config Variable</h3>
				</div><!-- /.box-header -->

				<form role="form" method="POST" action="/admin/configvar/edit/<?= $la_configvar['configid'] ?>">
					<div class="box-body">
						<?

						if($la_configvar['admin'])
							echo $this->htmlinput('readonly', 'key', 'Key', $la_configvar['key']);

						else
							echo $this->htmlinput('text', 'key', 'Key', $la_configvar['key']);

						echo $this->htmlinput('text', 'value', 'Value', $la_configvar['value']);

						?>
					</div><!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>