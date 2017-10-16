<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Daftar Permohonan
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a><?php echo ucfirst($this->ion_auth->user()->row()->username); ?></a></li>
			<li><a>Permohonan</a></li>
			<li class="active">
				<?php echo ucfirst($this->uri->segment(2));?>
			</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box">
			<div class="box-body">
				<!-- Modal alert-->
				<?php pesanModal();

				//flash messages
				if($this->session->flashdata('flash_message')=='added'){
					echo'<script>
					window.onload = function(){
						$("#sukses").modal();
					};
					</script>';
				}else if(validation_errors())
				{ echo'<script>
					window.onload = function(){
						$("#gagal").modal();
					};
					</script>';
				}else if($this->session->flashdata('flash_message')=='deleted')
				{ echo'<script>
					window.onload = function(){
						$("#deleted").modal();
					};
					</script>';
				}
				?>

				<div class="row">
					<div class="span12 columns">
						<div class="well col-sm-12 col-xs-12">

							<form action="<?php echo base_url();?>/prainspeksi_permohonan/index" method="get" class="form-inline reset-margin">

							<?php
							//$attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
							//echo form_open('prainspeksi_permohonan/index', $attributes);

							echo '<div class="col-sm-3 col-xs-12" id="" style="" align="right" >
							<div class="input-group" >
							<input type="text" class="form-control" name="search_string" id="" value="'.$search_string_selected.'" placeholder="kata kunci" >
							<span class="input-group-btn" id=""><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button></span>
							</div>
							</div>';

							echo '<div class="col-sm-3 col-xs-12" id="" style="" align="center">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Cari di:</span>
									<select class="form-control" name="search_in" value="'.$search_in_field.'">'; ?>
										<option value="NamaGedung" <?php if ($search_in_field=='NamaGedung') {
											echo 'selected';
										}?> >Nama Gedung</option>
										<option value="NamaPengelola" <?php if ($search_in_field=='NamaPengelola') {
											echo 'selected';
										}?> >Nama Pengelola</option>
										<option value="TipePermhn" <?php if ($search_in_field=='TipePermhn') {
											echo 'selected';
										}?> >Tipe Permohonan</option>
										<option value="NoPermhn" <?php if ($search_in_field=='NoPermhn') {
											echo 'selected';
										}?> >No Permohonan</option>
										<option value="TglPermhn" <?php if ($search_in_field=='TglPermhn') {
											echo 'selected';
										}?> >Tgl Permohonan</option>
									</select>
								</div>
							</div>

							<?php
							echo '<div class="col-sm-6 hidden-xs" id="" style="">
							<div class="form-inline">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Pengurutan:</span>
									<select class="form-control" name="order" value="'.$order.'">'; ?>
										<option value="id" <?php if ($order=='id') {
											echo 'selected';
										}?> >No</option>
										<option value="NamaGedung" <?php if ($order=='NamaGedung') {
											echo 'selected';
										}?> >Nama Gedung</option>
										<option value="NamaPengelola" <?php if ($order=='NamaPengelola') {
											echo 'selected';
										}?> >Nama Pengelola</option>
										<option value="NoPermhn" <?php if ($order=='NoPermhn') {
											echo 'selected';
										}?> >No Permohonan</option>
										<option value="TglPermhn" <?php if ($order=='TglPermhn') {
											echo 'selected';
										}?> >Tgl Permohonan</option>
									</select>
								</div>

								<select class="form-control" name="order_type" value="<?php echo $order_type_selected; ?>">
									<option value="Asc" <?php if ($order_type_selected=='Asc') {
										echo 'selected';
									}?> > terkecil->terbesar </option>
									<option value="Desc" <?php if ($order_type_selected=='Desc') {
										echo 'selected';
									}?> > terbesar->terkecil </option>
								</select>
							</div>
							</div>
							<?php
							//echo form_close();
							echo '</form>';
							?>

						</div>

						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="crud-actions">Action</th>
									<th class="header">No</th>
									<th class="">Nama Pengelola</th>
									<th class="">Nama Gedung</th>
									<th class="">Tipe Permohonan</th>
									<th class="hidden-xs">No Permohonan</th>
									<th class="hidden-xs">Tgl Permohonan</th>
									<th class="hidden-xs">Tgl Surat Diterima</th>
									<th class="hidden-xs">Proggres</th>
								</tr>
							</thead>
							<tbody>
								<?php
								//$rows=count($permohonans);
								$count = 1;
								foreach($permohonans as $row)
								{
									if($row['StatusPermhn']==1){
										$progress='20%';
										$warna='black';
	                }else if($row['StatusPermhn']==2){
										$progress='40%';
										$warna='orange';
	                }else if($row['StatusPermhn']==3){
										$progress='60%';
										$warna='purple';
	                }else if($row['StatusPermhn']==4){
										$progress='80%';
										$warna='blue';
	                }else if($row['StatusPermhn']==5){
										$progress='100%';
										$warna='red';
	                }else{
										$progress='0%';
										$warna='black';
									}
									echo '<tr'; if($this->session->flashdata('flash_message')=='added' && $count==1){echo ' class="kedipGrey" >'; $this->session->set_flashdata('flash_message', '');}else{echo '>';}
										echo '<td class="">
											<div class="btn-group" role="group">
												<a href="'.site_url("prainspeksi_permohonan/update").'/'.$row['id'].'" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Lihat & Edit"><span class="glyphicon glyphicon-edit"></span></a>
												<a href="'.site_url("prainspeksi_permohonan/delete").'/'.$row['id'].'" data-toggle="confirmation" data-title="Yakin hapus?" class="btn btn-danger btn-sm" ><span class="glyphicon glyphicon-trash"></span></a>
											</div>
										</td>';
										echo '<td>'.$row['id'].'</td>';
										echo '<td>'.$row['NamaPengelola'].'</td>';
										echo '<td>'.$row['Nama_Gedung_Id'].'</td>';
										echo '<td>'.$row['TipePermhn'].'</td>';
										echo '<td class="hidden-xs">'.$row['NoPermhn'].'</td>';
										echo '<td class="hidden-xs">'.sqlDate2html($row['TglPermhn']).'</td>';
										echo '<td class="hidden-xs">'.sqlDate2html($row['TglSuratDiterima']).'</td>';
										echo '<td><span class="badge bg-'.$warna.'">'.$progress.'</span></td>';
									echo '</tr>';
									$count++ ;
								}
								?>
							</tbody>
						</table>

						<div style="text-align: center;">
							<?php echo $this->pagination->create_links(); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
