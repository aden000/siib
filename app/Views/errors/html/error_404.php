<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<link rel="stylesheet" href="/assets/css/mystyle.css">
	<style>
		div.logo {
			height: 200px;
			width: 155px;
			display: inline-block;
			opacity: 0.08;
			position: absolute;
			top: 2rem;
			left: 50%;
			margin-left: -73px;
		}

		body {
			height: 100%;
			background: #fafafa;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			color: #777;
			font-weight: 300;
		}

		h1 {
			font-weight: lighter;
			letter-spacing: 0.8;
			font-size: 3rem;
			margin-top: 0;
			margin-bottom: 0;
			color: #222;
		}

		.wrap {
			max-width: 1024px;
			margin: 5rem auto;
			padding: 2rem;
			background: #fff;
			text-align: left;
			border: 1px solid #efefef;
			border-radius: 0.5rem;
			position: relative;
		}

		pre {
			white-space: normal;
			margin-top: 1.5rem;
		}

		code {
			background: #fafafa;
			border: 1px solid #efefef;
			padding: 0.5rem 1rem;
			border-radius: 5px;
			display: block;
		}

		p {
			margin-top: 1.5rem;
		}

		.footer {
			margin-top: 2rem;
			border-top: 1px solid #efefef;
			padding: 1em 2em 0 2em;
			font-size: 85%;
			color: #999;
		}

		a:active,
		a:link,
		a:visited {
			color: #dd4814;
		}

		.link {
			border-radius: 7%;
			border: #dd4814 1px solid;
			color: #dd4814;
			padding: 10px;
			background-color: wheat;
			margin: auto;
			margin-bottom: 5px;
			text-decoration: none;
		}

		.link:hover {
			background-color: coral;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<div class="wrap">
		<h1 style="margin-bottom: 1rem;">:(</h1>
		<div class="section-heading">
			<h3>404 Not Found - <b>Halaman tidak ditemukan</b></h3>
			<p>
				<?php if (!empty($message) && $message !== '(null)') : ?>
					<b><?= esc($message) ?></b>
				<?php else : ?>
					Cobalah kembali ke halaman awal
				<?php endif ?>
				<br />
			</p>
			<button type="button" class="link" id="backPreviousPage">&#10094;&nbsp;Kembali ke halaman sebelumnya</button> <button type="button" id="toRootWeb" class="link">&#10094;&nbsp;Kembali ke halaman awal</button>
		</div>
	</div>
	<script>
		document.getElementById('backPreviousPage').addEventListener('click', function() {
			history.back()
		}, false)
		document.getElementById('toRootWeb').addEventListener('click', function() {
			window.location.href = '../'
		}, false)
	</script>
</body>

</html>