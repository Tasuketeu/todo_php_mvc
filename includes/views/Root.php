<!DOCTYPE html>
<html>
<?php include('Header.php'); ?>
<body>

	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
								<?php if($_SESSION['user']) {echo "<li class=\"nav-item\"><a class=\"nav-link\">$uname</a></li>
									 <li class=\"nav-item\"><a class=\"nav-link\" href=\"/logout.php\">Выйти из аккаунта</a> </li>
						 ";} else{
								echo "<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"/register.php\">Зарегистрироваться</a>
						</li>
						<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"/login.php\">Войти в аккаунт</a>
						</li>";
						 } ?>
				</ul>
			</div>
		</div>
	</nav>

<div class="content-width">
			<div class="container jumbotron">

				<div class="row justify-content-center">
					<form method="POST" action="/add.php">
						<?php
						if(isset($_COOKIE['error'])){
						$errors = json_decode($_COOKIE['error']);
					}
					if(isset($_COOKIE['success'])){
						$success = json_decode($_COOKIE['success']);
					}
						 if(isset($errors)){foreach ($errors as $error) {?> 
							<div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div> 
							<?php }} ?>
							<?php if(isset($success)){foreach ($success as $s) {?> 
							<div class="alert alert-success" role="alert"> <?php echo $s; ?> </div> 
						<?php }} ?>

						<div class="form-group">
		<p class="text-center">Приложение-задачник</p>
	</div>
													<div class="form-group">
		<label for="exampleInputUserName1">Имя пользователя</label>
		<input type="text" name="username" class="form-control" id="exampleInputUserName1" required>
	</div>
	<div class="form-group">
		<label for="exampleInputEmail1">E-mail</label>
		<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
	</div>
						<div class="form-group">
						<label for="InputTask1">Задача</label>
						<input type="text" name="task" class="form-control" id="InputTask1" required/>
				</div>
				<div class="form-group">
				<label for="exampleFormControlSelect1">Статус</label>
				<select class="form-control" id="exampleFormControlSelect1" name="status1">
					<option value="0">
						Выберите статус:
					</option>
					<option value="1">
							не начато
					</option> 
					<option value="2">
							выполняется
					</option> 
				</select>
			</div>
						<button type="submit" class="btn btn-primary" name="addTask">Добавить задачу</button>
					</form>
				</div>

				<div class="row">
					<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col"><?php echo $sortBtn['name']; ?></th>
								<th scope="col"><?php echo $sortBtn['email']; ?></th>
								<th scope="col">Задача</th>
								<th scope="col"><?php echo $sortBtn['status']; ?></th>
								<th scope="col">Удаление</th>
								<th scope="col">Редактирование</th>
							</tr>
						</thead>
						<tbody>
								<?php $i=1;while($row = mysqli_fetch_array($result1)){ ?>
								<tr>
								<th scope="row"><?php echo $i; ?></th>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['email']; ?></td>

							 <?php
									$task_row = $row['task'];
								if($_COOKIE['editor']==$i){
																		echo "<td>
										<form method=\"POST\" action=\"/edit.php/?page=$page&&order=$order&&sort=$sort\">
										<div class=\"form-group\">
										<input type=\"text\" name=\"editedTask\" class=\"form-control\" id=\"InputTask1\" value=\"$task_row\" required/>
										</div>
										<button class=\"btn btn-primary\" type=\"submit\">Завершить редактирование</button>
										</form>
									</td>
									<td>
										<form method=\"POST\" action=\"/edit.php/?page=$page&&order=$order&&sort=$sort\">
										<select class=\"form-control\" name=\"status\" id=\"status\">
										<option value=\"0\">
											Статус
										</option>
										<option value=\"1\">
												не начато
										</option> 
										<option value=\"2\">
												выполняется
										</option>
										<option value=\"3\">
																выполнено
										</option> 
										<option value=\"4\">
																отложено
										</option>  
										</select>
										</form>
									</td>
									";
								}
								else{
									echo "<td>$task_row</td>";

									$status_name = $row['status_name'];
									$statusForm = "<td> <p>$status_name</p>";

									if($row['admin_status']==1){
									$statusForm.= "<p>отредактировано администратором</p>";
									}
									$statusForm.= "</td>";
									echo $statusForm;
								}
								
								?>
								<td class="delete">
									<?php

									$row_id=$row['id'];
									$row_name=$row['name'];
									$row_status=$row['status'];
									$row_task=$row['task'];

										echo "<a class=\"btn btn-danger\" href=\"/task/delete/?page=$page&&del_task=$row_id&&user_name=$row_name\">x</a>";
									 ?>
								</td>
								<td class="edit">
									<?php
										echo "<a class=\"btn btn-warning\" href=\"/edit.php/?row_num=$i&&page=$page&&edit_task=$row_id&&editor_name=$row_name&&edit_status=$row_status&&tasks=$row_task&&order=$order&&sort=$sort\">!!!!</a>";
									 ?>
									
								</td>
							</tr>

								<?php $i++;} ?>
							
						</tbody>
					</table>
					</div>
				</div>
				<div class="row justify-content-end">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
								<?php
								for($k=1; $k<=$pagesCount;$k++){  ?>
		<?php echo "<li name=\"page\" class=\"page-item\"><a class=\"page-link\" href=\"/index.php/?page=$k&&order=$order&&sort=$sort\">$k</a></li>"; ?>
	<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<?php include('Scripts.php'); ?>
		<script type="text/javascript"><?php include('includes/js/Root.js'); ?></script>


</body>

<?php include('Footer.php'); ?>

</html>