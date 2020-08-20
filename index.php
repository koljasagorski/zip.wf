
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zippyshare Downloader">
    <meta name="author" content="https://github.com/GunawanJSP">

    <title>ZippyShare Downloader</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="sticky.css" rel="stylesheet">
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Zippy Downloader</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">Zippy Downloader</h1>
      <p class="lead">Place The link on the box.</p>
      <form class="form" method="get" action="./download.php">
      <div class="row">
        <div class="col-lg-12">
            <div class="input-group input-group-lg">
            <input type="text" class="form-control input-lg" placeholder="Your Link Here" name="url">
            <span class="input-group-btn">
                <button class="btn btn-primary btn-lg" type="submit">Download</button>
            </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
      </form>
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Zippy Downloader &copy; 2018</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>