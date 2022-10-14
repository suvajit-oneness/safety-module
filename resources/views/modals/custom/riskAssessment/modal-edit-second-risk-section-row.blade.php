<div class="modal fade modal-md modal-top" id="editSetion2Row" name="editSetion2Row"  data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="AddRowModalLabel">
	<div class="modal-dialog " role="document" style="min-width: 95%;">
    	<div class="modal-content">
	      	<div class="modal-header">
	          	<h4 class="text-center" id="AddRowModalLabel">Edit</h4>
	      	</div>
	      	<div class="modal-body" >
	      		<form id="section2EditRowForm" class="w-100">
	      			<input type="text" id="id" hidden>
		      		<div class="row">
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-reference">Reference</label>
		      				<div class="form-control" name="reference" id="edit-reference" readonly></div>
		      			</div>
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-hazard-name">Hazard Name</label>
		      				<div class="form-control" name="hazard_name" id="edit-hazard-name" readonly></div>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-threats">Threats</label>
		      				<textarea class="form-control" rows="3" name="threats" id="edit-threats" value=""></textarea>
		      			</div>

		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-top-events">Threats</label>
		      				<textarea class="form-control" rows="3" name="top_events" id="edit-top-events" value=""></textarea>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-consequence">Consequence</label>
		      				<textarea class="form-control" rows="3" name="consequence" id="edit-consequence" value=""></textarea>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-sm-12 col-md-12 form-group">
		      				<label for="edit-grr">Gross Risk Rating</label>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-grr-p" name="grr_p"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-grr-e" name="grr_e"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-grr-a" name="grr_a"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-grr-r" name="grr_r"></select>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-control">Control</label>
		      				<textarea class="form-control" rows="3" name="control" id="edit-control" value=""></textarea>
		      			</div>

		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-recovery-measure">Recovery Measure</label>
		      				<textarea class="form-control" rows="3" name="recovery_measure" id="edit-recovery-measure" value=""></textarea>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-sm-12 col-md-12 form-group">
		      				<label for="edit-nrr">Nett / Residual Risk Rating</label>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-nrr-p" name="nrr_p"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-nrr-e" name="nrr_e"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-nrr-a" name="nrr_a"></select>
		      			</div>
		      			<div class="col-md-3 col-sm-12 form-group">
		      				<select class="form-control risk_select" id="edit-nrr-r" name="nrr_r"></select>
		      			</div>
		      		</div>

		      		<div class="row mt-3">
		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-reduction-measure">Reduction Measure</label>
		      				<textarea class="form-control" rows="3" name="reduction_measure" id="edit-reduction-measure" value=""></textarea>
		      			</div>

		      			<div class="col-md-6 col-sm-6 form-group">
		      				<label for="edit-remarks">Remarks</label>
		      				<textarea class="form-control" rows="3" name="remarks" id="edit-remarks" value=""></textarea>
		      			</div>
		      		</div>
		      	</form>
	      	</div>
	      	<div class="modal-footer">
	      		<div class="row w-100">
	      			<div class="col-md-3 col-sm-3"></div>
	      			<div class="col-md-6 col-sm-6 d-flex">
	      				<button type="button" class="btn btn-primary w-100 mr-2" onclick="saveSection2Row()">Update</button>
			            <button class="btn btn-danger w-100" id="editSetion2Row-cancel-btn" data-dismiss="modal" aria-label="Close">Cancel</button>
	      			</div>
	      			<div class="col-md-3 col-sm-3"></div>
	      		</div>
      		</div>
  		</div>
	</div>
</div>