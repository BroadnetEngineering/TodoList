<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A coding challenge for Broadnet">
    <meta name="author" content="Elias Baez">
    <title>Todo List</title>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="d-flex flex-column h-100">
    <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Todo List</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Add a new task</h1>
    <div class="jumbotron">
			<form>
			  <div class="form-group">
			    <label for="titleInput">Title</label>
			    <input type="text" class="form-control" id="titleInput">
			  </div>
			  <div class="form-group">
			    <label for="descriptionInput">Description</label>
			    <textarea rows="4" cols="50" class="form-control" id="descriptionInput"></textarea>
			  </div>
			  <div class="form-group">
			    <label for="datepicker">Due date</label>
			    <input id="datepicker" width="276" />
			  </div>
			  <button type="submit" class="btn btn-primary" id="add">Add task</button>
			</form>
		</div>
		<div class="container" id="tasks">
	    <h1 class="mt-5">All of my tasks</h1>
	    <table id="table_id" class="display">
			</table>
		</div>
  </div>
</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">A coding challenge for Broadnet</span>
  </div>
</footer>
      <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
      <script src="./actions.js"></script>
</html>
