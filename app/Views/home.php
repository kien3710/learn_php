



<div class="container-xl">
	<div class="table-responsive d-flex flex-column">
	<?php
			if(session()->getFlashdata("success")){
			?>
		<div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
		
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php }?>
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>CodeIgniter 4 <b>CRUD</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
						<a href="#" class="delete_all_data btn btn-danger"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>Name</th>
						<th>Email</th>
						<th>Images</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if($users) {
					foreach($users as $user) {
						

					?>	<tr>
                        <input type="hidden" id="userId" name="id" value = "<?php echo $user['id'] ?>" >
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" id="data_checkbox" class="data_checkbox" name="data_checkbox" value="<?php echo $user['id'] ?>">
								<label for="data_checkbox"></label>
							</span>
						</td>
						<td><?php echo $user['username'] ?></td>
						<td><?php echo $user['email']?></td>
						<td><div class="td-img"><img src="uploads/<?php echo $user['image']?>" alt=""></div></td>
						<td>
							<a href="#editEmployeeModal" class="edit" id="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					<?php
					}
				}
				?>
					
				</tbody>
			</table>
			<div class="d-flex justify-content-center align-items-center">
				<ul class="pagination">
					<?= $pager->links('group1','bs_pagination'); ?>
				</ul>
			</div>
		</div>
	</div>        
</div>
<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form enctype="multipart/form-data" action = "<?php echo base_url(). '/saveUser';?>" method = "POST" >
				<div class="modal-header">						
					<h4 class="modal-title">Add Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">	
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control"  name="username" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control email" name="email" required>
					</div>		
					<div class="form-group">
						<label>Image</label>
						<input type="file" class="form-control userfile" name="userfile" required>
					</div>			
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" name="submit" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
<form action="<?php echo base_url(). '/do_upload'; ?>" method="post" enctype="multipart/form-data">
   <input type="file" name="userfile" size="20" />
   <input type="submit" value="upload" />
</form>

<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action = "<?php echo base_url(). '/updateUser';?>" method = "POST">
				<div class="modal-header">						
					<h4 class="modal-title">Edit Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
                    <input type="hidden" name="updateId" class = "updateId" >					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control updateUsername username" value="kien" name = "username" required>
					</div>
					<div class="form-group">
						<label>password</label>
						<input type="text" class="form-control updatePassword" name = "password"  required>
                    </div>			
				</div>
				<div class="modal-footer">
					<input type="button" name = "submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info save" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<script>

	$('.edit').click(function(e) {
		e.preventDefault();
		var id = $(this).parent().siblings()[0].value;
		$.get( "" +"/getSingleUser/" +id, function( data ) {
			var res = JSON.parse(data); 
			$('.updateUsername').val(res.username)
			$('.updatePassword').val(res.email)
			$('.updateId').val(res.id)
			
	})
	})
	$('.delete').click(function(e){
		e.preventDefault();		
		var id = $(this).parent().siblings()[0].value;
		$.post("" + "/deleteUser/", {id:id} , function(data) {
			location.reload()
		})
	})
	$('.delete_all_data').click(function(e) {
		var checkbox = $('.data_checkbox:checked');
		if(checkbox.length > 0){
			var ids = [];
			checkbox.each(function() {
				ids.push($(this).val())
			})
		}
		$.post("" + "/deleteMultiUser" , function(data) {
			console.log(data)
		})
		
	})
</script>
