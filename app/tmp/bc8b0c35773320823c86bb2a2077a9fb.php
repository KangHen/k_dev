<div class="row">
	<div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label>Test Name</label>
            <?= Form::text('testname', null, array('class'=>'form-control', 'placeholder'=>'masukkan test di sini')) ?>
        </div>
         <div class="form-group">
            <label>Bidang</label>
        </div>
        <div class="form-group">
        	<button class="btn btn-success">Simpan</button>
        	<a class="btn btn-warning" href="#">Batal</a>
        </div>
        <?= Form::close() ?>
 	</div>
</div>