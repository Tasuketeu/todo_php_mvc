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
								<li class="nav-item">
									<a class="nav-link" href="/login.php">Войти в аккаунт</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="/index.php/?page=1">Вернуться назад</a>
								</li>

				</ul>
			</div>
		</div>
	</nav>

<div class="content-width">
			<div class="container jumbotron">

				<div class="row justify-content-center">

				<div class="row">
					<form method="POST" action="">
						<?php foreach ($errors as $error) { ?> 
							<div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div> 
						 <?php } ?>
							<div class="form-group">
		<label for="exampleInputUserName1">Имя пользователя</label>
		<input type="text" name="username" class="form-control" id="exampleInputUserName1" required>
	</div>
	<div class="form-group">
		<label for="exampleInputEmail1">E-mail</label>
		<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Пароль</label>
		<input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
	</div>
	<button class="btn btn-primary" name="register" type="submit">Зарегистрироваться</button>

					</form>
				</div>

				
				</div>
			</div>
		</div>


<?php include('Scripts.php'); ?>
</body>

<?php include('Footer.php'); ?>
</html>